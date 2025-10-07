# PHP 웹솔루션

저가형 호스팅 환경에 최적화된 경량 PHP CMS 솔루션입니다.

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

## 설치 방법

### Apache 설정

DocumentRoot를 `www` 폴더로 지정해야 합니다.

**Apache VirtualHost 설정 예시:**

```apache
<VirtualHost *:80>
    ServerName example.com
    DocumentRoot /var/www/html/haru/www

    <Directory /var/www/html/haru/www>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/error.log
    CustomLog ${APACHE_LOG_DIR}/access.log combined
</VirtualHost>
```

**XAMPP/로컬 개발 환경:**

`httpd.conf` 또는 `httpd-vhosts.conf` 파일에서:

```apache
DocumentRoot "C:/xampp/htdocs/haru/www"
<Directory "C:/xampp/htdocs/haru/www">
    Options Indexes FollowSymLinks
    AllowOverride All
    Require all granted
</Directory>
```

**중요:** `www` 폴더만 웹에서 접근 가능하도록 설정하여 `app`, `config`, `data` 등의 폴더는 외부에서 직접 접근할 수 없도록 보호합니다.

### 데이터베이스 설정

1. 웹 브라우저에서 `/install` 경로로 접속
2. 설치 마법사의 안내에 따라 데이터베이스 정보 입력
3. 관리자 계정 생성
4. 설치 완료
