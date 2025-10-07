<?php

namespace App\Controllers;

use App\Models\Board;
use App\Models\Post;
use App\Models\Comment;
use App\Core\Helper;

class BoardController
{
    private Board $boardModel;
    private Post $postModel;
    private Comment $commentModel;

    public function __construct()
    {
        $this->boardModel = new Board();
        $this->postModel = new Post();
        $this->commentModel = new Comment();
    }

    /**
     * 게시판 목록 (게시글 목록)
     */
    public function index(array $params): string
    {
        $boardName = $params['board_name'] ?? '';
        $board = $this->boardModel->findByName($boardName);

        if (!$board) {
            http_response_code(404);
            return '게시판을 찾을 수 없습니다.';
        }

        // 페이징
        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = (int)Helper::config('posts_per_page', 20);
        $totalPosts = $this->postModel->count($board['id']);
        $pagination = Helper::paginate($totalPosts, $perPage, $page);

        // 검색
        $keyword = $_GET['keyword'] ?? '';
        $searchType = $_GET['search_type'] ?? 'all';

        if ($keyword) {
            $posts = $this->postModel->search($board['id'], $keyword, $searchType, $perPage, $pagination['offset']);
        } else {
            $posts = $this->postModel->getList($board['id'], $perPage, $pagination['offset']);
        }

        ob_start();
        require BASE_PATH . '/app/Views/board/list.php';
        return ob_get_clean();
    }

    /**
     * 게시글 보기
     */
    public function view(array $params): string
    {
        $boardName = $params['board_name'] ?? '';
        $postId = (int)($params['post_id'] ?? 0);

        $board = $this->boardModel->findByName($boardName);
        if (!$board) {
            http_response_code(404);
            return '게시판을 찾을 수 없습니다.';
        }

        $post = $this->postModel->findById($postId);
        if (!$post || $post['board_id'] != $board['id']) {
            http_response_code(404);
            return '게시글을 찾을 수 없습니다.';
        }

        // 조회수 증가
        $this->postModel->incrementViewCount($postId);

        // 댓글 조회
        $comments = $this->commentModel->getByPostId($postId);

        // 이전/다음 글
        $adjacentPosts = $this->postModel->getAdjacentPosts($board['id'], $postId);

        ob_start();
        require BASE_PATH . '/app/Views/board/view.php';
        return ob_get_clean();
    }

    /**
     * 글쓰기 폼
     */
    public function write(array $params): string
    {
        $boardName = $params['board_name'] ?? '';
        $board = $this->boardModel->findByName($boardName);

        if (!$board) {
            http_response_code(404);
            return '게시판을 찾을 수 없습니다.';
        }

        // 권한 체크
        if ($board['write_level'] > 0 && !Helper::isLoggedIn()) {
            Helper::flash('error', '로그인이 필요합니다.');
            Helper::redirect('/login');
        }

        ob_start();
        require BASE_PATH . '/app/Views/board/write.php';
        return ob_get_clean();
    }

    /**
     * 글 저장
     */
    public function store(array $params): void
    {
        $boardName = $params['board_name'] ?? '';
        $board = $this->boardModel->findByName($boardName);

        if (!$board) {
            http_response_code(404);
            echo '게시판을 찾을 수 없습니다.';
            return;
        }

        // 권한 체크
        if ($board['write_level'] > 0 && !Helper::isLoggedIn()) {
            Helper::flash('error', '로그인이 필요합니다.');
            Helper::redirect('/login');
        }

        $title = trim($_POST['title'] ?? '');
        $content = $_POST['content'] ?? '';

        if (empty($title)) {
            Helper::flash('error', '제목을 입력해주세요.');
            Helper::redirect("/boards/{$boardName}/write");
        }

        $postData = [
            'board_id' => $board['id'],
            'user_id' => Helper::userId(),
            'title' => $title,
            'content' => $content,
            'is_notice' => Helper::isAdmin() && isset($_POST['is_notice']) ? 1 : 0
        ];

        $postId = $this->postModel->create($postData);

        if ($postId) {
            Helper::flash('success', '게시글이 등록되었습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}");
        } else {
            Helper::flash('error', '게시글 등록에 실패했습니다.');
            Helper::redirect("/boards/{$boardName}/write");
        }
    }

    /**
     * 글 수정 폼
     */
    public function edit(array $params): string
    {
        $boardName = $params['board_name'] ?? '';
        $postId = (int)($params['post_id'] ?? 0);

        if (!Helper::isLoggedIn()) {
            Helper::flash('error', '로그인이 필요합니다.');
            Helper::redirect('/login');
        }

        $board = $this->boardModel->findByName($boardName);
        $post = $this->postModel->findById($postId);

        if (!$board || !$post || $post['board_id'] != $board['id']) {
            http_response_code(404);
            return '게시글을 찾을 수 없습니다.';
        }

        // 권한 체크 (작성자 또는 관리자만)
        if ($post['user_id'] != Helper::userId() && !Helper::isAdmin()) {
            Helper::flash('error', '수정 권한이 없습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}");
        }

        ob_start();
        require BASE_PATH . '/app/Views/board/edit.php';
        return ob_get_clean();
    }

    /**
     * 글 수정 처리
     */
    public function update(array $params): void
    {
        $boardName = $params['board_name'] ?? '';
        $postId = (int)($params['post_id'] ?? 0);

        if (!Helper::isLoggedIn()) {
            Helper::flash('error', '로그인이 필요합니다.');
            Helper::redirect('/login');
        }

        $post = $this->postModel->findById($postId);
        if (!$post) {
            http_response_code(404);
            echo '게시글을 찾을 수 없습니다.';
            return;
        }

        // 권한 체크
        if ($post['user_id'] != Helper::userId() && !Helper::isAdmin()) {
            Helper::flash('error', '수정 권한이 없습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}");
        }

        $title = trim($_POST['title'] ?? '');
        $content = $_POST['content'] ?? '';

        if (empty($title)) {
            Helper::flash('error', '제목을 입력해주세요.');
            Helper::redirect("/boards/{$boardName}/{$postId}/edit");
        }

        $updateData = [
            'title' => $title,
            'content' => $content
        ];

        if (Helper::isAdmin()) {
            $updateData['is_notice'] = isset($_POST['is_notice']) ? 1 : 0;
        }

        if ($this->postModel->update($postId, $updateData)) {
            Helper::flash('success', '게시글이 수정되었습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}");
        } else {
            Helper::flash('error', '게시글 수정에 실패했습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}/edit");
        }
    }

    /**
     * 글 삭제
     */
    public function delete(array $params): void
    {
        $boardName = $params['board_name'] ?? '';
        $postId = (int)($params['post_id'] ?? 0);

        if (!Helper::isLoggedIn()) {
            Helper::json(['success' => false, 'message' => '로그인이 필요합니다.'], 401);
        }

        $post = $this->postModel->findById($postId);
        if (!$post) {
            Helper::json(['success' => false, 'message' => '게시글을 찾을 수 없습니다.'], 404);
        }

        // 권한 체크
        if ($post['user_id'] != Helper::userId() && !Helper::isAdmin()) {
            Helper::json(['success' => false, 'message' => '삭제 권한이 없습니다.'], 403);
        }

        if ($this->postModel->delete($postId)) {
            Helper::flash('success', '게시글이 삭제되었습니다.');
            Helper::redirect("/boards/{$boardName}");
        } else {
            Helper::flash('error', '게시글 삭제에 실패했습니다.');
            Helper::redirect("/boards/{$boardName}/{$postId}");
        }
    }

    /**
     * 댓글 작성
     */
    public function addComment(array $params): void
    {
        if (!Helper::isLoggedIn()) {
            Helper::json(['success' => false, 'message' => '로그인이 필요합니다.'], 401);
        }

        $postId = (int)($params['post_id'] ?? 0);
        $content = trim($_POST['content'] ?? '');

        if (empty($content)) {
            Helper::json(['success' => false, 'message' => '댓글 내용을 입력해주세요.']);
        }

        $commentData = [
            'post_id' => $postId,
            'user_id' => Helper::userId(),
            'content' => $content
        ];

        $commentId = $this->commentModel->create($commentData);

        if ($commentId) {
            Helper::json(['success' => true, 'message' => '댓글이 등록되었습니다.', 'comment_id' => $commentId]);
        } else {
            Helper::json(['success' => false, 'message' => '댓글 등록에 실패했습니다.']);
        }
    }

    /**
     * 댓글 삭제
     */
    public function deleteComment(array $params): void
    {
        if (!Helper::isLoggedIn()) {
            Helper::json(['success' => false, 'message' => '로그인이 필요합니다.'], 401);
        }

        $commentId = (int)($params['comment_id'] ?? 0);
        $comment = $this->commentModel->findById($commentId);

        if (!$comment) {
            Helper::json(['success' => false, 'message' => '댓글을 찾을 수 없습니다.'], 404);
        }

        // 권한 체크
        if ($comment['user_id'] != Helper::userId() && !Helper::isAdmin()) {
            Helper::json(['success' => false, 'message' => '삭제 권한이 없습니다.'], 403);
        }

        if ($this->commentModel->delete($commentId)) {
            Helper::json(['success' => true, 'message' => '댓글이 삭제되었습니다.']);
        } else {
            Helper::json(['success' => false, 'message' => '댓글 삭제에 실패했습니다.']);
        }
    }
}
