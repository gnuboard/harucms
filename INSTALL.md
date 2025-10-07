# 설치 가이드

카페24 PHP 웹솔루션 설치 및 초기 설정 가이드입니다.

## 1. XAMPP 환경에서 설치

### Step 1: XAMPP 시작
1. XAMPP Control Panel 실행
2. Apache와 MySQL 시작

### Step 2: 데이터베이스 생성

#### 방법 1: phpMyAdmin 사용 (권장)
1. 브라우저에서 `http://localhost/phpmyadmin` 접속
2. 왼쪽 메뉴에서 "New" 클릭
3. 데이터베이스 이름: `cafe24`
4. Collation: `utf8mb4_unicode_ci` 선택
5. "Create" 버튼 클릭

#### 방법 2: MySQL 콘솔 사용
```bash
# XAMPP MySQL 콘솔 실행
c:\xampp\mysql\bin\mysql.exe -u root

# 데이터베이스 생성
CREATE DATABASE cafe24 CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cafe24;
```

### Step 3: 테이블 생성

phpMyAdmin에서:
1. 생성한 `cafe24` 데이터베이스 선택
2. 상단 메뉴에서 "Import" 클릭
3. "Choose File" 버튼 클릭
4. `c:\xampp\htdocs\cafe24\database\schema.sql` 파일 선택
5. 하단의 "Go" 버튼 클릭
6. 성공 메시지 확인

### Step 4: 설정 확인

`config/database.php` 파일이 다음과 같이 설정되어 있는지 확인:

```php
return [
    'host' => 'localhost',
    'database' => 'cafe24',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
```

### Step 5: 접속 확인

브라우저에서 다음 URL로 접속:

**프론트엔드:**
- http://localhost/cafe24

**관리자 페이지:**
- http://localhost/cafe24/admin

**기본 관리자 계정:**
- 아이디: `admin`
- 비밀번호: `admin1234`

⚠️ **반드시 첫 로그인 후 비밀번호를 변경하세요!**

## 2. 데이터베이스 테이블 확인

다음 테이블들이 정상적으로 생성되었는지 확인:

- ✅ `users` - 사용자 정보 (관리자 포함)
- ✅ `boards` - 게시판 설정 (free, notice 기본 생성)
- ✅ `posts` - 게시글
- ✅ `comments` - 댓글
- ✅ `contents` - 컨텐츠 페이지
- ✅ `configs` - 시스템 설정
- ✅ `files` - 파일 첨부
- ✅ `plugins` - 플러그인
- ✅ `sessions` - 세션 (선택사항)

## 3. 초기 데이터 확인

### 기본 관리자 계정
```sql
SELECT * FROM users WHERE username = 'admin';
```

### 기본 게시판
```sql
SELECT * FROM boards;
```
- free (자유게시판)
- notice (공지사항)

### 기본 설정
```sql
SELECT * FROM configs;
```

## 4. 테스트

### 프론트엔드 테스트
1. `http://localhost/cafe24` 접속 → 자유게시판으로 리다이렉트 확인
2. `/login` → 로그인 페이지 확인
3. `/register` → 회원가입 페이지 확인
4. `/boards/free` → 자유게시판 확인
5. `/boards/notice` → 공지사항 확인

### 관리자 페이지 테스트
1. `http://localhost/cafe24/admin` 접속
2. admin@example.com / admin1234 로그인
3. 대시보드 확인
4. 사용자 관리 확인
5. 게시판 관리 확인
6. 컨텐츠 관리 확인

## 5. 문제 해결

### "404 Not Found" 에러
**원인:** .htaccess 파일이 작동하지 않거나 mod_rewrite가 비활성화됨

**해결:**
1. `c:\xampp\apache\conf\httpd.conf` 파일 열기
2. 다음 줄 찾기:
   ```
   #LoadModule rewrite_module modules/mod_rewrite.so
   ```
3. 주석(#) 제거:
   ```
   LoadModule rewrite_module modules/mod_rewrite.so
   ```
4. Apache 재시작

### "Access denied for user 'root'@'localhost'" 에러
**원인:** MySQL 비밀번호가 설정되어 있음

**해결:**
1. `config/database.php` 파일에서 password 설정
2. 또는 phpMyAdmin에서 root 비밀번호 제거

### "Database connection failed" 에러
**원인:** MySQL 서버가 실행되지 않음

**해결:**
1. XAMPP Control Panel에서 MySQL 시작
2. MySQL이 3306 포트에서 실행 중인지 확인

### 세션 오류
**원인:** PHP 세션 디렉토리 권한 문제

**해결:**
1. `c:\xampp\tmp` 폴더 권한 확인
2. XAMPP를 관리자 권한으로 실행

## 6. 카페24 호스팅 배포

### 파일 업로드
1. FTP 접속 (FileZilla 등 사용)
2. 파일 배치:
   ```
   /public_html/          ← www/ 폴더 내용
   /cafe24/app/           ← app/ 폴더
   /cafe24/config/        ← config/ 폴더
   /cafe24/database/      ← database/ 폴더
   ```

### 데이터베이스 설정
1. 카페24 관리자 페이지 접속
2. MySQL 데이터베이스 생성
3. 데이터베이스 정보 확인 (호스트, DB명, 사용자명, 비밀번호)
4. phpMyAdmin 접속
5. `schema.sql` 파일 import

### config/database.php 수정
```php
return [
    'host' => 'localhost',  // 또는 카페24에서 제공한 호스트
    'database' => '실제_DB명',
    'username' => '실제_사용자명',
    'password' => '실제_비밀번호',
    'charset' => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
];
```

### www/index.php 수정 (운영 환경)
```php
// 오류 출력 비활성화
error_reporting(0);
ini_set('display_errors', 0);
```

## 7. 보안 설정

### 관리자 비밀번호 변경
1. 관리자 페이지 로그인
2. 사용자 관리 → admin 계정 수정
3. 새 비밀번호 설정

### .htaccess 보안 강화
`www/.htaccess` 파일에 추가:
```apache
# HTTPS 강제 (SSL 인증서 있는 경우)
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### 디렉토리 권한 설정 (Linux/카페24)
```bash
chmod 755 www/
chmod 644 config/database.php
chmod 755 app/
```

## 8. CKEditor 설치 (선택사항)

1. [CKEditor 4.22.1 다운로드](https://ckeditor.com/ckeditor-4/download/)
2. 압축 해제 후 `www/assets/ckeditor/` 폴더에 복사
3. 게시글 작성/수정 페이지에서 자동으로 로드됨

폴더 구조:
```
www/
  assets/
    ckeditor/
      ckeditor.js
      config.js
      ...
```

## 완료!

모든 설정이 완료되었습니다. 이제 카페24 PHP 웹솔루션을 사용할 수 있습니다.

문제가 발생하면 [CLAUDE.md](CLAUDE.md) 및 [README.md](README.md)를 참고하세요.
