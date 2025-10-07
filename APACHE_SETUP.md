# Apache 설정 가이드 (XAMPP)

## 현재 문제
`http://localhost/cafe24/` 접속 시 파일 목록이 표시됨

## 해결 방법

### 방법 1: 간단한 URL 사용 (권장)
```
http://localhost/cafe24/www/
```
이 URL로 접속하면 바로 작동합니다.

---

### 방법 2: .htaccess 사용 (이미 적용됨)
루트 폴더에 `.htaccess` 파일이 생성되었습니다.

**테스트:**
1. Apache 재시작
2. `http://localhost/cafe24/` 접속
3. 자동으로 `www/index.php`로 리다이렉트됨

**만약 작동하지 않으면:**
`c:\xampp\apache\conf\httpd.conf` 파일에서 다음을 확인:

```apache
# mod_rewrite 활성화 확인 (주석 제거)
LoadModule rewrite_module modules/mod_rewrite.so

# AllowOverride 설정 확인
<Directory "C:/xampp/htdocs">
    AllowOverride All
    Require all granted
</Directory>
```

변경 후 Apache 재시작 필요!

---

### 방법 3: VirtualHost 설정 (프로덕션과 유사한 환경)

#### 1. hosts 파일 수정
`C:\Windows\System32\drivers\etc\hosts` 파일에 추가:
```
127.0.0.1    cafe24.local
```

#### 2. Apache VirtualHost 설정
`c:\xampp\apache\conf\extra\httpd-vhosts.conf` 파일에 추가:

```apache
<VirtualHost *:80>
    ServerName cafe24.local
    DocumentRoot "c:/xampp/htdocs/cafe24/www"

    <Directory "c:/xampp/htdocs/cafe24/www">
        Options Indexes FollowSymLinks
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog "logs/cafe24-error.log"
    CustomLog "logs/cafe24-access.log" common
</VirtualHost>
```

#### 3. httpd.conf에서 vhosts 활성화
`c:\xampp\apache\conf\httpd.conf` 파일에서 다음 줄의 주석 제거:
```apache
Include conf/extra/httpd-vhosts.conf
```

#### 4. Apache 재시작

#### 5. 접속
```
http://cafe24.local/
```

---

## Apache 재시작 방법

### XAMPP Control Panel 사용
1. XAMPP Control Panel 열기
2. Apache 'Stop' 클릭
3. Apache 'Start' 클릭

### 명령줄 사용
```cmd
# Apache 중지
c:\xampp\apache\bin\httpd.exe -k stop

# Apache 시작
c:\xampp\apache\bin\httpd.exe -k start
```

---

## 문제 해결

### .htaccess가 작동하지 않는 경우

1. **mod_rewrite 확인**
   ```cmd
   c:\xampp\apache\bin\httpd.exe -M | findstr rewrite
   ```
   출력: `rewrite_module (shared)` 나와야 함

2. **AllowOverride 확인**
   `c:\xampp\apache\conf\httpd.conf` 파일에서:
   ```apache
   <Directory "C:/xampp/htdocs">
       AllowOverride All  # None이 아닌 All이어야 함
   </Directory>
   ```

3. **Apache 에러 로그 확인**
   ```
   c:\xampp\apache\logs\error.log
   ```

### 404 에러가 계속 발생하는 경우

`www/.htaccess` 파일 확인:
```apache
RewriteEngine On
RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)$ index.php [QSA,L]
```

---

## 권장 설정 (개발 환경)

**가장 간단한 방법:**
```
URL: http://localhost/cafe24/www/
```

**조금 더 깔끔한 방법:**
```
URL: http://localhost/cafe24/
.htaccess 리다이렉트 사용 (이미 적용됨)
```

**프로덕션과 동일한 환경:**
```
URL: http://cafe24.local/
VirtualHost 설정 필요
```

---

## 빠른 테스트

1. Apache가 실행 중인지 확인
2. 브라우저에서 접속:
   - `http://localhost/cafe24/www/` ✅ 바로 작동
   - `http://localhost/cafe24/` ⚠️ .htaccess 필요
   - `http://cafe24.local/` ⚠️ VirtualHost 설정 필요

---

## 카페24 호스팅에서는?

카페24 호스팅에서는 `www/` 폴더의 내용을 `public_html/`에 업로드하면 됩니다.
.htaccess는 자동으로 작동합니다.
