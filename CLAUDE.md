# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

카페24 저가형 호스팅 환경에 최적화된 경량 PHP CMS 솔루션. MVC 패턴 기반으로 사용자 관리, 게시판, 컨텐츠 관리 기능을 제공하며 플러그인 시스템을 통한 확장 가능.

## Architecture

### Core Components

- **Router** ([app/Core/Router.php](app/Core/Router.php)): URL 파라미터를 지원하는 RESTful 라우터. `:id` 패턴으로 동적 파라미터 캡처
- **Database** ([app/Core/Database.php](app/Core/Database.php)): PDO 기반 Singleton 패턴 데이터베이스 래퍼. Prepared Statements로 SQL 인젝션 방지
- **Autoloader** ([www/index.php](www/index.php:14-29)): PSR-4 스타일 클래스 자동 로딩. `App\` 네임스페이스를 `app/` 디렉토리에 매핑

### Directory Structure

```
cafe24/
├── www/                   # Public 폴더 (DocumentRoot)
│   ├── index.php         # 애플리케이션 진입점, 라우팅 정의
│   └── .htaccess         # mod_rewrite 설정
├── app/
│   ├── Core/             # 핵심 클래스 (Router, Database)
│   ├── Controllers/      # MVC 컨트롤러
│   ├── Models/          # 데이터 모델
│   └── Views/           # PHP 뷰 템플릿
├── config/
│   └── database.php     # DB 접속 정보
└── database/
    └── schema.sql       # 테이블 스키마
```

### Database Schema

**기본 테이블 구조:**
- `configs`: 시스템 설정
- `users`: 사용자 계정 (is_admin 필드로 관리자 구분)
- `contents`: 페이지 컨텐츠
- `boards`: 게시판 설정
- `posts`: 게시글
- `comments`: 댓글
- `attachments`: 파일 첨부
- `plugins`: 플러그인 설정
- `sessions`: 세션 정보 (DB 기반 세션 관리)

**구현 완료:** users 테이블에서 is_admin 필드로 관리자 구분, 이메일을 아이디로 사용

## Key Patterns

### MVC Flow
1. [www/index.php](www/index.php) - 라우트 등록 및 디스패치
2. Controller - 요청 처리, 인증 체크
3. Model - DB 쿼리 실행
4. View - 출력 버퍼링으로 HTML 렌더링 (`ob_start()` / `ob_get_clean()`)

### Authentication
- 세션 기반 인증 (`$_SESSION['admin_id']`)
- `isLoggedIn()` 메서드로 인증 상태 확인
- 미인증 시 `/admin/login`으로 리다이렉트

### Database Access
```php
$db = Database::getInstance();
$result = $db->fetchOne($sql, $params);  // 단일 행
$results = $db->fetchAll($sql, $params); // 다중 행
$success = $db->execute($sql, $params);  // INSERT/UPDATE/DELETE
```

## Development Commands

### Database Setup
```bash
mysql -u root cafe24 < database/schema.sql
```

### Testing on XAMPP
- Apache 시작 후 `http://localhost/cafe24` 접속
- DB: cafe24, user: root, password: (empty)

### Route Registration
[www/index.php](www/index.php)에 라우트 추가:
```php
$router->get('/boards/:name', [BoardController::class, 'show']);
$router->post('/boards/:name/posts', [PostController::class, 'create']);
```

## Implementation Guidelines

### 게시판 URL 구조
- 목록: `/boards/free`, `/boards/notice`
- 상세: `/boards/free/posts/:id`
- 작성: POST `/boards/:board_name/posts`

### 관리자 페이지
- 모든 관리 기능은 `/admin/*` 경로 사용
- 컨트롤러에서 `requireAuth()` 호출로 인증 필수화

### 에디터 통합
- CKEditor 4.22.1 오픈소스 버전 사용 예정
- `www/` 폴더에 에디터 파일 배치
- 뷰 템플릿에서 `<textarea>` 요소를 에디터로 변환

### 플러그인 시스템
- `plugins/` 디렉토리 구조 설계 필요
- 훅 시스템으로 핵심 기능 확장 가능하도록 구현

## Cafe24 Hosting Specifics

- PHP 7.4+ 환경
- `www/` 폴더만 웹 접근 가능 (나머지는 상위 디렉토리에 배치)
- mod_rewrite 기본 활성화
- 파일 업로드 제한: 20MB (htaccess에서 설정)
- 세션은 파일 기반 사용

## Security Notes

- 모든 DB 쿼리는 PDO Prepared Statements 사용 필수
- 비밀번호는 `password_hash()` (bcrypt) 사용
- 운영 환경에서는 `display_errors Off` 설정
- htaccess로 `.env`, `.sql`, `.log` 파일 접근 차단
- XSS 방지: 출력 시 `htmlspecialchars()` 사용
