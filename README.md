# 카페24 PHP 웹솔루션

카페24 저가형 호스팅 환경에 최적화된 경량 PHP CMS 솔루션입니다.

## 주요 기능

- ✅ **사용자 관리**: 회원가입, 로그인, 프로필 관리
- ✅ **게시판 시스템**: 다중 게시판, 게시글, 댓글 관리
- ✅ **컨텐츠 관리**: 정적 페이지 생성 및 관리
- ✅ **관리자 페이지**: 통합 관리 대시보드 (/admin)
- ✅ **플러그인 시스템**: 확장 가능한 훅 기반 아키텍처
- ✅ **CKEditor 지원**: 4.22.1 오픈소스 버전

## 시스템 요구사항

- PHP 7.4 이상
- MySQL 5.7 이상
- Apache with mod_rewrite

## 프로젝트 구조

```
cafe24/
├── www/                    # Public 디렉토리 (DocumentRoot)
│   ├── index.php          # 애플리케이션 진입점
│   └── .htaccess          # Apache 설정
├── app/
│   ├── Core/              # 핵심 클래스
│   │   ├── Router.php     # RESTful 라우터
│   │   ├── Database.php   # PDO 데이터베이스 래퍼
│   │   ├── Helper.php     # 헬퍼 함수
│   │   └── Plugin.php     # 플러그인 시스템
│   ├── Controllers/       # MVC 컨트롤러
│   │   ├── UserController.php
│   │   ├── BoardController.php
│   │   ├── ContentController.php
│   │   └── Admin/
│   │       └── AdminController.php
│   ├── Models/            # 데이터 모델
│   │   ├── User.php
│   │   ├── Board.php
│   │   ├── Post.php
│   │   ├── Comment.php
│   │   └── Content.php
│   └── Views/             # 뷰 템플릿
│       ├── admin/         # 관리자 페이지
│       ├── board/         # 게시판
│       └── user/          # 사용자
├── config/
│   └── database.php       # 데이터베이스 설정
├── database/
│   └── schema.sql         # 데이터베이스 스키마
└── plugins/               # 플러그인 디렉토리
```

## 설치 방법

### 1. 데이터베이스 설정

MySQL에서 데이터베이스를 생성합니다:

```sql
CREATE DATABASE cafe24 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

테이블 생성:

```bash
mysql -u root cafe24 < database/schema.sql
```

또는 phpMyAdmin에서 `database/schema.sql` 파일을 가져오기합니다.

### 2. 설정 파일 수정

`config/database.php` 파일에서 데이터베이스 정보를 설정합니다:

```php
return [
    'host' => 'localhost',
    'database' => 'cafe24',
    'username' => 'root',
    'password' => '',  // 실제 비밀번호로 변경
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
```

### 3. Apache 설정

`www/` 디렉토리를 DocumentRoot로 설정하거나, 가상 호스트를 구성합니다.

XAMPP 사용 시:
- `c:\xampp\htdocs\cafe24`에 프로젝트 배치
- `http://localhost/cafe24` 접속

### 4. 기본 관리자 계정

데이터베이스 스키마 실행 시 자동으로 생성됩니다:

- **이메일**: admin@example.com
- **비밀번호**: admin1234

⚠️ **보안을 위해 첫 로그인 후 반드시 비밀번호를 변경하세요!**

## 주요 URL

### 프론트엔드
- `/` - 메인 페이지 (자유게시판으로 리다이렉트)
- `/boards/free` - 자유게시판
- `/boards/notice` - 공지사항
- `/login` - 로그인
- `/register` - 회원가입
- `/mypage` - 마이페이지

### 관리자 페이지
- `/admin` - 관리자 대시보드
- `/admin/users` - 사용자 관리
- `/admin/boards` - 게시판 관리
- `/admin/contents` - 컨텐츠 관리

## 데이터베이스 구조

### 주요 테이블
- **users**: 사용자 정보 (is_admin 필드로 관리자 구분)
- **boards**: 게시판 설정
- **posts**: 게시글
- **comments**: 댓글
- **contents**: 정적 컨텐츠 페이지
- **configs**: 시스템 설정
- **attachments**: 파일 첨부
- **plugins**: 플러그인 정보
- **sessions**: 세션 정보 (DB 기반 세션 관리)

## 개발 가이드

### 새로운 라우트 추가

`www/index.php`에서 라우트를 추가합니다:

```php
$router->get('/custom-page', [CustomController::class, 'index']);
$router->post('/custom-page', [CustomController::class, 'store']);
```

### 플러그인 개발

`plugins/my-plugin/plugin.php` 파일을 생성:

```php
<?php
use App\Core\Plugin;

// 훅 등록
Plugin::addHook('post_created', function($postId) {
    // 게시글 생성 시 실행될 코드
}, 10);

// 필터 등록
Plugin::addHook('post_content', function($content) {
    // 게시글 내용 필터링
    return $content;
}, 10);
```

### Helper 함수 사용

```php
use App\Core\Helper;

// XSS 방지
Helper::e($text);

// 리다이렉트
Helper::redirect('/login');

// JSON 응답
Helper::json(['success' => true]);

// 플래시 메시지
Helper::flash('success', '저장되었습니다.');
$message = Helper::getFlash('success');

// 로그인 체크
if (Helper::isLoggedIn()) { }
if (Helper::isAdmin()) { }

// 페이징
$pagination = Helper::paginate($total, $perPage, $currentPage);
```

## 보안 권장사항

1. **운영 환경 설정** - `www/index.php`에서 에러 출력 비활성화:
   ```php
   error_reporting(0);
   ini_set('display_errors', 0);
   ```

2. **데이터베이스 계정** - root 계정 대신 제한된 권한의 계정 사용

3. **파일 권한** - 업로드 디렉토리는 실행 권한 제거

4. **HTTPS 사용** - `.htaccess`에서 HTTPS 강제 리다이렉트 활성화

5. **정기적인 백업** - 데이터베이스와 업로드 파일 백업

## CKEditor 설치

1. [CKEditor 4.22.1](https://ckeditor.com/ckeditor-4/download/) 다운로드
2. `www/assets/ckeditor/` 디렉토리에 압축 해제
3. 게시글 작성 페이지에서 자동으로 로드됨

## 카페24 호스팅 배포

1. FTP로 파일 업로드:
   - `www/` 내용을 public 디렉토리에 업로드
   - 나머지 파일은 public 상위 디렉토리에 업로드

2. 카페24 관리자 페이지에서 MySQL 데이터베이스 생성

3. phpMyAdmin에서 `database/schema.sql` 실행

4. `config/database.php` 파일 수정

## 문제 해결

### 404 에러 발생 시
- `.htaccess` 파일이 제대로 업로드되었는지 확인
- Apache `mod_rewrite` 모듈이 활성화되어 있는지 확인

### 데이터베이스 연결 실패
- `config/database.php` 설정 확인
- MySQL 서버 실행 여부 확인
- 사용자 계정 권한 확인

### 세션 문제
- PHP 세션 디렉토리 쓰기 권한 확인
- `session_start()` 호출 확인

## 라이선스

MIT License

## 개발자

카페24 호스팅 최적화 PHP CMS - 2024
