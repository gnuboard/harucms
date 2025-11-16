# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

HaruCMS 저가형 호스팅 환경에 최적화된 경량 PHP CMS 솔루션. MVC 패턴 기반으로 사용자 관리, 게시판, 컨텐츠 관리 기능을 제공하며 플러그인 시스템을 통한 확장 가능.

## Architecture

### Core Components

- **Router** ([app/Core/Router.php](app/Core/Router.php)): URL 파라미터를 지원하는 RESTful 라우터. `:id` 패턴으로 동적 파라미터 캡처
- **Database** ([app/Core/Database.php](app/Core/Database.php)): PDO 기반 Singleton 패턴 데이터베이스 래퍼. Prepared Statements로 SQL 인젝션 방지
- **Autoloader** ([www/index.php](www/index.php:14-29)): PSR-4 스타일 클래스 자동 로딩. `App\` 네임스페이스를 `app/` 디렉토리에 매핑

### Directory Structure

```
harucms/
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
mysql -u root harucms < database/schema.sql
```

### Testing on XAMPP
- Apache 시작 후 `http://localhost/harucms` 접속
- DB: harucms, user: root, password: (empty)

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

## Hosting Specifics

- PHP 7.4+ 환경
- `www/` 폴더만 웹 접근 가능 (나머지는 상위 디렉토리에 배치)
- mod_rewrite 기본 활성화
- 파일 업로드 제한: 20MB (htaccess에서 설정)
- 세션은 DB 기반 사용

## Security Notes

- 모든 DB 쿼리는 PDO Prepared Statements 사용 필수
- 비밀번호는 `password_hash()` (bcrypt) 사용
- 운영 환경에서는 `display_errors Off` 설정
- htaccess로 `.env`, `.sql`, `.log` 파일 접근 차단
- XSS 방지: 출력 시 `htmlspecialchars()` 사용

## Design System

HaruCMS는 파란색과 에메랄드 그린의 조화를 기반으로 한 모던하고 신선한 디자인 시스템을 사용합니다.

### Color Palette

**Primary Colors:**
- Blue: `blue-600` (Primary), `blue-400` (Dark mode), `blue-700` (Hover)
- Emerald: `emerald-600` (Accent), `emerald-400` (Dark mode), `emerald-700` (Hover)
- Cyan/Teal: `cyan-600`, `teal-600` (Secondary accents)

**Neutral Colors:**
- Light mode: `white`, `gray-50/100/200/300/600/800/900`
- Dark mode: `slate-700/800/900`

**Semantic Colors:**
- Success: `green-50/100/200/800` (Light), `green-900/800/200` (Dark)
- Error: `red-50/100/200/800` (Light), `red-900/800/200` (Dark)
- Info: `blue-50/100/200/800` (Light), `blue-900/800/200` (Dark)

### Gradient Usage

**Primary Gradient:**
```css
bg-gradient-to-r from-blue-600 via-emerald-600 to-blue-600
/* Dark mode */
from-blue-400 via-emerald-400 to-blue-400
```

**Background Gradient:**
```css
bg-gradient-to-br from-white via-blue-50/30 to-emerald-50/30
/* Dark mode */
dark:bg-gradient-to-br dark:from-slate-900 dark:via-slate-800 dark:to-slate-900
```

**Card Gradients:**
- Stats/Feature cards: `from-blue-600 to-emerald-600`
- Decorative backgrounds: `from-blue-600/10 to-cyan-600/10`
- Free board: `from-emerald-600/10 to-teal-600/10`

### Typography

**Font Sizes:**
- Hero Title: `text-5xl md:text-6xl lg:text-7xl`
- Section Title: `text-2xl md:text-4xl`
- Card Title: `text-xl`
- Body: `text-base` (16px)
- Small: `text-sm` (14px)
- Extra Small: `text-xs` (12px)

**Font Weights:**
- Bold: `font-bold` (700) - Titles
- Semibold: `font-semibold` (600) - Buttons, Labels
- Medium: `font-medium` (500) - Links
- Normal: `font-normal` (400) - Body

### Spacing & Layout

**Container:**
- Max width: `max-w-7xl` (Hero/Main), `max-w-md` (Auth), `max-w-2xl` (Section headers)
- Padding: `px-4 sm:px-6 lg:px-8`
- Section spacing: `py-10 lg:py-14`

**Rounded Corners:**
- Cards: `rounded-xl` (12px)
- Buttons: `rounded-lg` (8px) or `rounded-2xl` (16px)
- Inputs: `rounded-lg` (8px)
- Full round: `rounded-full`

**Shadows:**
- Cards: `shadow-sm` (default), `shadow-lg` (hover), `shadow-xl` (active)
- Buttons: `shadow-lg shadow-blue-500/40`, `hover:shadow-2xl hover:shadow-emerald-500/50`
- Dark mode: `dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40`

### Components

**Buttons:**
```html
<!-- Primary Button -->
<button class="py-3 px-4 bg-gradient-to-r from-blue-600 to-emerald-600 hover:from-blue-700 hover:to-emerald-700 text-white font-semibold rounded-lg shadow-lg shadow-blue-500/40 hover:shadow-xl hover:shadow-emerald-500/50 dark:shadow-blue-500/30 dark:hover:shadow-emerald-500/40 transition-all duration-300 hover:-translate-y-0.5">
    버튼 텍스트
</button>

<!-- Secondary Button -->
<button class="py-3 px-4 border-2 border-gray-300 dark:border-slate-600 text-gray-800 dark:text-white bg-white/50 dark:bg-slate-800/50 backdrop-blur-sm hover:bg-white dark:hover:bg-slate-700 rounded-lg transition-all">
    버튼 텍스트
</button>
```

**Input Fields:**
```html
<input class="w-full px-4 py-3 rounded-lg border border-gray-300 dark:border-slate-600 bg-white dark:bg-slate-700 text-gray-900 dark:text-white placeholder-gray-500 dark:placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 focus:border-transparent transition-all">
```

**Cards:**
```html
<!-- Feature Card -->
<div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl shadow-sm hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
    <!-- Card content -->
</div>

<!-- Stats Card -->
<div class="group bg-white dark:bg-slate-800 border border-gray-200 dark:border-slate-700 rounded-xl hover:shadow-lg hover:border-blue-600 dark:hover:border-blue-500 transition-all duration-300">
    <!-- Icon with gradient -->
    <div class="bg-gradient-to-br from-blue-600 to-emerald-600 rounded-lg">
        <!-- Icon -->
    </div>
    <!-- Number with gradient text -->
    <h3 class="bg-clip-text bg-gradient-to-br from-blue-600 to-emerald-600 text-transparent dark:from-blue-400 dark:to-emerald-400">
        100%
    </h3>
</div>
```

**Alert Messages:**
```html
<!-- Success -->
<div class="p-4 rounded-lg bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 text-green-800 dark:text-green-200">
    Success message
</div>

<!-- Error -->
<div class="p-4 rounded-lg bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-200">
    Error message
</div>
```

### Animations

**Keyframes:**
```css
/* Gradient animation for text */
@keyframes gradient {
    0%, 100% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
}
.animate-gradient { animation: gradient 8s ease infinite; }

/* Fade in animation */
@keyframes fade-in {
    from { opacity: 0; transform: translateY(-10px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate-fade-in { animation: fade-in 0.6s ease-out; }
```

**Transitions:**
- Default: `transition-all duration-300`
- Hover lift: `hover:-translate-y-0.5` or `hover:-translate-y-1`
- Scale on hover: `hover:scale-110`
- Color transitions: `transition-colors`

### Dark Mode Implementation

**Tailwind Configuration:**
```javascript
tailwind.config = {
    darkMode: 'class',
}
```

**Theme Toggle:**
```javascript
// Initialize theme from localStorage
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.classList.toggle('dark', savedTheme === 'dark');

// Toggle function
function toggleTheme() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');
    const newTheme = isDark ? 'light' : 'dark';
    html.classList.toggle('dark', !isDark);
    localStorage.setItem('theme', newTheme);
}
```

**Class Usage:**
- Always provide both light and dark variants
- Pattern: `bg-white dark:bg-slate-800`
- Text: `text-gray-900 dark:text-white`
- Borders: `border-gray-200 dark:border-slate-700`

### Decorative Elements

**Blur Circles:**
```html
<div class="absolute -top-40 -right-40 w-80 h-80 bg-blue-400/20 dark:bg-blue-500/10 rounded-full blur-3xl"></div>
<div class="absolute -bottom-40 -left-40 w-80 h-80 bg-emerald-400/20 dark:bg-emerald-500/10 rounded-full blur-3xl"></div>
```

**Backdrop Blur:**
```html
<div class="bg-white/80 dark:bg-slate-800/80 backdrop-blur-sm">
    <!-- Content -->
</div>
```

### Prohibited Colors

**절대 사용 금지:**
- Violet: `violet-*`
- Purple: `purple-*`
- Pink: `pink-*`
- Indigo: `indigo-*` (마이페이지, 관리자 카드는 예외)

**대체 색상:**
- Violet/Purple → Emerald/Teal/Cyan
- 모든 그라데이션에서 violet → emerald로 교체

## Communication Guidelines

### Language Preference
- **모든 세션 계획, 처리, 결과는 한글로 작성**
- 사용자와의 모든 커뮤니케이션은 한국어 사용
- 코드 주석 및 문서화는 한글로 작성
- 기술적 설명 및 에러 메시지도 한글로 제공

### File Permissions
- **app/Views/ 디렉토리의 모든 파일은 664 권한으로 생성**
- Write 도구로 뷰 파일 생성 후 즉시 `chmod 664` 실행
- 예시: `chmod 664 /home/kagla/harucms/app/Views/user/mypage.php`

## Git Workflow

### Commit Policy
- **모든 작업 완료 후 즉시 커밋 필수**
- 사용자가 명시적으로 요청하지 않아도 의미 있는 변경사항이 있으면 자동으로 커밋
- 커밋하지 않고 세션을 종료하지 말 것

### Auto-commit on Session End
- 세션 종료 시 자동으로 커밋 생성
- 커밋 메시지 앞에 매번 다른 이모지 자동 추가
- 이모지 목록: 🔧 📝 ✨ 🐛 🚀 💄 ♻️ 🔥 ⚡ 🎨 📦 🔒 🌐 🎯 💡 🧹 📚 🔨 🎉 ⬆️
- 커밋 메시지는 한글로 작성하며, 변경 내용을 명확히 설명
