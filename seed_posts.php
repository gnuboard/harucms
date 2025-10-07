<?php

/**
 * 게시판 데이터 시드 스크립트
 * 자유게시판에 100개의 테스트 게시글을 생성합니다.
 */

require __DIR__ . '/app/Core/Database.php';

use App\Core\Database;

try {
    $db = Database::getInstance();

    // 자유게시판(free) ID 조회
    $sql = "SELECT id FROM boards WHERE name = 'free' LIMIT 1";
    $board = $db->fetchOne($sql);

    if (!$board) {
        die("자유게시판을 찾을 수 없습니다.\n");
    }

    $boardId = $board['id'];

    // 관리자 사용자 ID 조회
    $sql = "SELECT id FROM users WHERE is_admin = 1 LIMIT 1";
    $admin = $db->fetchOne($sql);

    if (!$admin) {
        die("관리자 계정을 찾을 수 없습니다.\n");
    }

    $userId = $admin['id'];

    // 샘플 제목과 내용 데이터
    $titlePrefixes = [
        '안녕하세요', '질문있습니다', '도움이 필요해요', '추천 부탁드립니다',
        '궁금한게 있어요', '정보 공유합니다', '후기 남깁니다', '감사합니다',
        '문의드립니다', '의견 부탁드려요', '같이 해요', '이거 어떻게 하나요',
        '정말 좋네요', '추천합니다', '강력 추천', '비추천합니다',
        '주의하세요', '팁 공유', '초보 질문', '고수님들께 질문'
    ];

    $titleSuffixes = [
        'PHP 관련', 'MySQL 관련', 'JavaScript 관련', '프로젝트 관련',
        '개발 환경', '성능 최적화', '보안 이슈', '버그 수정',
        '코드 리뷰', '아키텍처', '디자인 패턴', 'API 개발',
        '프론트엔드', '백엔드', '데이터베이스', '서버 관리',
        '배포 방법', '테스트 코드', '문서화', '협업 도구'
    ];

    $contentTemplates = [
        "안녕하세요.\n\n{topic}에 대해서 궁금한 점이 있어서 글을 남깁니다.\n\n여러분의 경험과 조언을 듣고 싶습니다.\n\n감사합니다.",
        "{topic} 관련해서 정보를 공유합니다.\n\n최근에 이것을 사용해보니 정말 좋더라구요.\n\n관심있으신 분들은 참고하세요!",
        "{topic} 작업 중인데 막혔습니다.\n\n혹시 비슷한 경험 있으신 분 계신가요?\n\n도움 부탁드립니다!",
        "오늘 {topic}를 공부했습니다.\n\n정리한 내용을 공유합니다.\n\n도움이 되셨으면 좋겠습니다.",
        "{topic} 초보입니다.\n\n기본적인 것부터 배우고 싶은데 추천해주실 만한 자료가 있을까요?\n\n감사합니다!",
        "프로젝트에서 {topic}를 사용하고 있는데 성능 이슈가 있습니다.\n\n최적화 방법에 대해 조언 부탁드립니다.",
        "{topic} 관련 튜토리얼을 작성했습니다.\n\n초보자분들께 도움이 되었으면 좋겠습니다.\n\n피드백 환영합니다!",
        "{topic}에서 이런 기능을 구현하려고 하는데\n\n어떤 방법이 가장 좋을까요?\n\n경험 많으신 분들의 의견이 궁금합니다.",
    ];

    echo "자유게시판(ID: {$boardId})에 100개의 게시글을 생성합니다...\n\n";

    $sql = "INSERT INTO posts (board_id, user_id, title, content, is_notice, view_count, status, created_at, updated_at)
            VALUES (?, ?, ?, ?, ?, ?, 'active', NOW(), NOW())";

    $successCount = 0;

    for ($i = 1; $i <= 100; $i++) {
        // 랜덤 제목 생성
        $prefix = $titlePrefixes[array_rand($titlePrefixes)];
        $suffix = $titleSuffixes[array_rand($titleSuffixes)];
        $title = "[{$i}] {$prefix} - {$suffix}";

        // 랜덤 내용 생성
        $template = $contentTemplates[array_rand($contentTemplates)];
        $content = str_replace('{topic}', $suffix, $template);
        $content .= "\n\n게시글 번호: {$i}\n작성일: " . date('Y-m-d H:i:s');

        // 공지사항 여부 (처음 5개만 공지로)
        $isNotice = ($i <= 5) ? 1 : 0;

        // 랜덤 조회수 (0-500)
        $viewCount = rand(0, 500);

        $params = [
            $boardId,
            $userId,
            $title,
            $content,
            $isNotice,
            $viewCount
        ];

        if ($db->execute($sql, $params)) {
            $successCount++;
            if ($i % 10 == 0) {
                echo "{$i}개 생성 완료...\n";
            }
        } else {
            echo "오류: {$i}번째 게시글 생성 실패\n";
        }
    }

    echo "\n완료! 총 {$successCount}개의 게시글이 생성되었습니다.\n";
    echo "http://cafe24.local/boards/free 에서 확인하세요.\n";

} catch (Exception $e) {
    die("오류 발생: " . $e->getMessage() . "\n");
}
