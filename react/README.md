# HaruCMS React Frontend

React로 구현된 HaruCMS SPA 프론트엔드입니다.

## 설치 방법

```bash
cd react
npm install
```

## 개발 서버 실행

```bash
npm run dev
```

브라우저에서 `http://localhost:3000` 접속

## 빌드

```bash
npm run build
```

빌드된 파일은 `dist/` 폴더에 생성됩니다.

## API 서버 설정

API 서버는 `https://haru.gnuboard.net`으로 설정되어 있습니다.

개발 환경에서는 Vite 프록시를 통해 CORS 문제를 해결합니다.

프로덕션 환경에서 다른 도메인을 사용하려면:
1. `src/services/api.js`의 `API_URL` 변경
2. PHP 백엔드의 `ApiController.php`에서 허용된 오리진에 프론트엔드 도메인 추가

## 페이지 구성

- `/` - 홈 (로그인 필요)
- `/login` - 로그인

## 사용된 기술

- React 18
- React Router v6
- Vite
- Fetch API
