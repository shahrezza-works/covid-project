ALTER TABLE respon_staff
	ADD COLUMN alamat1 VARCHAR(255) NULL AFTER lokasi,
	ADD COLUMN alamat2 VARCHAR(255) NULL AFTER alamat1,
	ADD COLUMN negeri VARCHAR(100) NULL AFTER alamat2,
	ADD COLUMN hamil int(2) NULL AFTER deria_rasa,
	ADD COLUMN dos1 DATE NULL AFTER vaksin,
	ADD COLUMN dos2 DATE NULL AFTER dos1,
	ADD COLUMN pusat_vaksin1 TEXT NULL AFTER dos2,
	ADD COLUMN pusat_vaksin2 TEXT NULL AFTER pusat_vaksin1;