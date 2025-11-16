-- contents 테이블에서 created_by 컬럼 제거
-- 실행 방법: mysql -u root -p harucms < remove_created_by_from_contents.sql

-- 외래 키 먼저 제거
ALTER TABLE `contents` DROP FOREIGN KEY `contents_ibfk_1`;

-- created_by 인덱스 제거
ALTER TABLE `contents` DROP INDEX `created_by`;

-- created_by 컬럼 제거
ALTER TABLE `contents` DROP COLUMN `created_by`;
