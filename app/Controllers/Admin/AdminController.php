<?php

namespace App\Controllers\Admin;

use App\Models\User;
use App\Models\Board;
use App\Models\Post;
use App\Models\Content;
use App\Core\Helper;

class AdminController
{
    private User $userModel;
    private Board $boardModel;
    private Post $postModel;
    private Content $contentModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->boardModel = new Board();
        $this->postModel = new Post();
        $this->contentModel = new Content();
    }

    /**
     * 관리자 인증 체크
     */
    private function requireAuth(): void
    {
        if (!Helper::isLoggedIn() || !Helper::isAdmin()) {
            Helper::flash('error', '관리자 권한이 필요합니다.');
            Helper::redirect('/login');
        }
    }

    /**
     * 로그인 폼
     */
    public function showLoginForm(): string
    {
        if (Helper::isLoggedIn() && Helper::isAdmin()) {
            Helper::redirect('/admin');
        }

        ob_start();
        require BASE_PATH . '/app/Views/admin/login.php';
        return ob_get_clean();
    }

    /**
     * 로그인 처리
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            Helper::redirect('/admin/login');
        }

        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($email) || empty($password)) {
            Helper::flash('error', '이메일과 비밀번호를 입력해주세요.');
            Helper::redirect('/admin/login');
        }

        $user = $this->userModel->login($email, $password);

        if ($user && $user['is_admin'] == 1) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['is_admin'] = $user['is_admin'];

            Helper::flash('success', '관리자 로그인되었습니다.');
            Helper::redirect('/admin');
        } else {
            Helper::flash('error', '관리자 계정이 아니거나 로그인 정보가 올바르지 않습니다.');
            Helper::redirect('/admin/login');
        }
    }

    /**
     * 로그아웃
     */
    public function logout(): void
    {
        session_destroy();
        Helper::redirect('/admin/login');
    }

    /**
     * 대시보드
     */
    public function dashboard(): string
    {
        $this->requireAuth();

        // 통계 데이터
        $stats = [
            'total_users' => $this->userModel->count(),
            'total_posts' => $this->postModel->countByUser(0), // 전체
            'total_boards' => count($this->boardModel->getAll()),
            'total_contents' => $this->contentModel->count()
        ];

        ob_start();
        require BASE_PATH . '/app/Views/admin/dashboard.php';
        return ob_get_clean();
    }

    /**
     * 사용자 관리 목록
     */
    public function users(): string
    {
        $this->requireAuth();

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $users = $this->userModel->getAll($perPage, $offset);
        $totalUsers = $this->userModel->count();
        $pagination = Helper::paginate($totalUsers, $perPage, $page);

        ob_start();
        require BASE_PATH . '/app/Views/admin/users/list.php';
        return ob_get_clean();
    }

    /**
     * 사용자 수정 폼
     */
    public function editUser(array $params): string
    {
        $this->requireAuth();

        $userId = (int)($params['id'] ?? 0);
        $user = $this->userModel->findById($userId);

        if (!$user) {
            Helper::flash('error', '사용자를 찾을 수 없습니다.');
            Helper::redirect('/admin/users');
        }

        ob_start();
        require BASE_PATH . '/app/Views/admin/users/edit.php';
        return ob_get_clean();
    }

    /**
     * 사용자 수정 처리
     */
    public function updateUser(array $params): void
    {
        $this->requireAuth();

        $userId = (int)($params['id'] ?? 0);
        $data = [];

        if (!empty($_POST['email'])) {
            $data['email'] = $_POST['email'];
        }

        if (!empty($_POST['name'])) {
            $data['name'] = $_POST['name'];
        }

        if (isset($_POST['is_admin'])) {
            $data['is_admin'] = (int)$_POST['is_admin'];
        }

        if (isset($_POST['status'])) {
            $data['status'] = (int)$_POST['status'];
        }

        if (!empty($_POST['password'])) {
            $data['password'] = $_POST['password'];
        }

        if ($this->userModel->update($userId, $data)) {
            Helper::flash('success', '사용자 정보가 수정되었습니다.');
        } else {
            Helper::flash('error', '사용자 정보 수정에 실패했습니다.');
        }

        Helper::redirect('/admin/users');
    }

    /**
     * 게시판 관리 목록
     */
    public function boards(): string
    {
        $this->requireAuth();

        $boards = $this->boardModel->getAll();

        // 각 게시판의 게시글 수 조회
        foreach ($boards as &$board) {
            $board['post_count'] = $this->boardModel->getPostCount($board['id']);
        }

        ob_start();
        require BASE_PATH . '/app/Views/admin/boards/list.php';
        return ob_get_clean();
    }

    /**
     * 게시판 생성 폼
     */
    public function createBoard(): string
    {
        $this->requireAuth();

        ob_start();
        require BASE_PATH . '/app/Views/admin/boards/create.php';
        return ob_get_clean();
    }

    /**
     * 게시판 저장
     */
    public function storeBoard(): void
    {
        $this->requireAuth();

        $data = [
            'name' => $_POST['name'] ?? '',
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'use_comments' => isset($_POST['use_comments']) ? 1 : 0,
            'use_files' => isset($_POST['use_files']) ? 1 : 0,
            'write_level' => (int)($_POST['write_level'] ?? 0),
            'read_level' => (int)($_POST['read_level'] ?? 0),
            'list_level' => (int)($_POST['list_level'] ?? 0),
            'order_num' => (int)($_POST['order_num'] ?? 0),
        ];

        if (empty($data['name']) || empty($data['title'])) {
            Helper::flash('error', '게시판 이름과 제목을 입력해주세요.');
            Helper::redirect('/admin/boards/create');
        }

        if ($this->boardModel->create($data)) {
            Helper::flash('success', '게시판이 생성되었습니다.');
            Helper::redirect('/admin/boards');
        } else {
            Helper::flash('error', '게시판 생성에 실패했습니다.');
            Helper::redirect('/admin/boards/create');
        }
    }

    /**
     * 게시판 수정 폼
     */
    public function editBoard(array $params): string
    {
        $this->requireAuth();

        $boardId = (int)($params['id'] ?? 0);
        $board = $this->boardModel->findById($boardId);

        if (!$board) {
            Helper::flash('error', '게시판을 찾을 수 없습니다.');
            Helper::redirect('/admin/boards');
        }

        ob_start();
        require BASE_PATH . '/app/Views/admin/boards/edit.php';
        return ob_get_clean();
    }

    /**
     * 게시판 수정 처리
     */
    public function updateBoard(array $params): void
    {
        $this->requireAuth();

        $boardId = (int)($params['id'] ?? 0);
        $data = [
            'title' => $_POST['title'] ?? '',
            'description' => $_POST['description'] ?? '',
            'use_comments' => isset($_POST['use_comments']) ? 1 : 0,
            'use_files' => isset($_POST['use_files']) ? 1 : 0,
            'write_level' => (int)($_POST['write_level'] ?? 0),
            'read_level' => (int)($_POST['read_level'] ?? 0),
            'list_level' => (int)($_POST['list_level'] ?? 0),
            'order_num' => (int)($_POST['order_num'] ?? 0),
        ];

        if ($this->boardModel->update($boardId, $data)) {
            Helper::flash('success', '게시판이 수정되었습니다.');
        } else {
            Helper::flash('error', '게시판 수정에 실패했습니다.');
        }

        Helper::redirect('/admin/boards');
    }

    /**
     * 컨텐츠 관리 목록
     */
    public function contents(): string
    {
        $this->requireAuth();

        $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
        $perPage = 20;
        $offset = ($page - 1) * $perPage;

        $contents = $this->contentModel->getAll('all', $perPage, $offset);
        $totalContents = $this->contentModel->count();
        $pagination = Helper::paginate($totalContents, $perPage, $page);

        ob_start();
        require BASE_PATH . '/app/Views/admin/contents/list.php';
        return ob_get_clean();
    }

    /**
     * 컨텐츠 생성 폼
     */
    public function createContent(): string
    {
        $this->requireAuth();

        ob_start();
        require BASE_PATH . '/app/Views/admin/contents/create.php';
        return ob_get_clean();
    }

    /**
     * 컨텐츠 저장
     */
    public function storeContent(): void
    {
        $this->requireAuth();

        $data = [
            'slug' => Helper::slug($_POST['slug'] ?? ''),
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'status' => $_POST['status'] ?? 'draft',
            'created_by' => Helper::userId()
        ];

        if (empty($data['slug']) || empty($data['title'])) {
            Helper::flash('error', 'URL 슬러그와 제목을 입력해주세요.');
            Helper::redirect('/admin/contents/create');
        }

        if ($this->contentModel->slugExists($data['slug'])) {
            Helper::flash('error', '이미 사용중인 URL 슬러그입니다.');
            Helper::redirect('/admin/contents/create');
        }

        if ($this->contentModel->create($data)) {
            Helper::flash('success', '컨텐츠가 생성되었습니다.');
            Helper::redirect('/admin/contents');
        } else {
            Helper::flash('error', '컨텐츠 생성에 실패했습니다.');
            Helper::redirect('/admin/contents/create');
        }
    }

    /**
     * 컨텐츠 수정 폼
     */
    public function editContent(array $params): string
    {
        $this->requireAuth();

        $contentId = (int)($params['id'] ?? 0);
        $content = $this->contentModel->findById($contentId);

        if (!$content) {
            Helper::flash('error', '컨텐츠를 찾을 수 없습니다.');
            Helper::redirect('/admin/contents');
        }

        ob_start();
        require BASE_PATH . '/app/Views/admin/contents/edit.php';
        return ob_get_clean();
    }

    /**
     * 컨텐츠 수정 처리
     */
    public function updateContent(array $params): void
    {
        $this->requireAuth();

        $contentId = (int)($params['id'] ?? 0);
        $data = [
            'slug' => Helper::slug($_POST['slug'] ?? ''),
            'title' => $_POST['title'] ?? '',
            'content' => $_POST['content'] ?? '',
            'status' => $_POST['status'] ?? 'draft'
        ];

        if ($this->contentModel->slugExists($data['slug'], $contentId)) {
            Helper::flash('error', '이미 사용중인 URL 슬러그입니다.');
            Helper::redirect("/admin/contents/{$contentId}/edit");
        }

        if ($this->contentModel->update($contentId, $data)) {
            Helper::flash('success', '컨텐츠가 수정되었습니다.');
        } else {
            Helper::flash('error', '컨텐츠 수정에 실패했습니다.');
        }

        Helper::redirect('/admin/contents');
    }

    /**
     * 컨텐츠 삭제
     */
    public function deleteContent(array $params): void
    {
        $this->requireAuth();

        $contentId = (int)($params['id'] ?? 0);

        if ($this->contentModel->delete($contentId)) {
            Helper::flash('success', '컨텐츠가 삭제되었습니다.');
        } else {
            Helper::flash('error', '컨텐츠 삭제에 실패했습니다.');
        }

        Helper::redirect('/admin/contents');
    }
}
