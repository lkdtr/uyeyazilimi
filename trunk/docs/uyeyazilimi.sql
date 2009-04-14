CREATE TABLE accounts (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  lotr_alias VARCHAR(65) NULL,
  password CHAR(32) NULL,
  active BOOL NULL,
  modified DATETIME NULL,
  PRIMARY KEY(id),
  INDEX accounts_FKIndex1(member_id)
);

CREATE TABLE leave_details (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  leave_year YEAR NOT NULL,
  leave_decision_date DATE NOT NULL,
  leave_decision_number INTEGER UNSIGNED NOT NULL,
  created DATETIME NULL,
  created_by INTEGER UNSIGNED NULL,
  modified DATETIME NULL,
  modified_by DATETIME NULL,
  PRIMARY KEY(id),
  INDEX Table_10_FKIndex1(member_id)
);

CREATE TABLE maillists (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  maillist_name VARCHAR(200) NULL,
  maillist_address VARCHAR(200) NULL,
  maillist_description TEXT NULL,
  created DATETIME NULL,
  created_by INTEGER UNSIGNED NULL,
  modified DATETIME NULL,
  modified_by INTEGER UNSIGNED NULL,
  PRIMARY KEY(id)
);

CREATE TABLE maillists_members (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  list_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id),
  INDEX lists_members_FKIndex1(list_id),
  INDEX lists_members_FKIndex2(member_id)
);

CREATE TABLE members (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  uye_no INTEGER UNSIGNED NULL,
  tckimlikno CHAR(11) NULL,
  name VARCHAR(30) NULL,
  lastname VARCHAR(30) NULL,
  gender CHAR(1) NULL,
  date_of_birth DATE NULL,
  member_type ENUM('member','treasurer','board_member') NULL,
  member_card_status ENUM('Ýstemiyor','Ýstiyor','Güncel Adres Bekleniyor','Dijital Fotoðraf Bekleniyor','Basýlacak','Baskýya Gitti','Postaya Verilecek') NULL,
  created DATETIME NULL,
  created_by INTEGER UNSIGNED NULL,
  modified DATETIME NULL,
  modified_by INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  UNIQUE INDEX members_unique1(uye_no),
  INDEX members_unique2(tckimlikno)
);

CREATE TABLE membership_fees (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  fee_year YEAR NULL,
  yearly_fee_amount FLOAT NULL,
  enterence_fee FLOAT NULL,
  PRIMARY KEY(id)
);

CREATE TABLE password_confirmations (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  account_id INTEGER UNSIGNED NOT NULL,
  hash CHAR(32) NULL,
  created DATETIME NULL,
  PRIMARY KEY(id),
  INDEX password_confirmations_FKIndex1(account_id)
);

CREATE TABLE payments (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  amount FLOAT NULL,
  payment_date DATE NULL,
  payment_method ENUM('elden','havale','kredi_karti','bilinmiyor') NULL,
  receipt_number VARCHAR(15) NULL,
  note TEXT NULL,
  created DATETIME NULL,
  created_by INTEGER UNSIGNED NULL,
  modified DATETIME NULL,
  modified_by INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX payments_FKIndex1(member_id)
);

CREATE TABLE personal_informations (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  email VARCHAR(30) NULL,
  email_2 VARCHAR(30) NULL,
  lotr_fwd_email VARCHAR(30) NULL,
  address VARCHAR(200) NULL,
  city VARCHAR(60) NULL,
  country VARCHAR(60) NULL DEFAULT 'Türkiye',
  home_number VARCHAR(25) NULL,
  mobile_number VARCHAR(25) NULL,
  work_number VARCHAR(25) NULL,
  current_school_company VARCHAR(60) NULL,
  latest_school_graduated VARCHAR(60) NULL,
  latest_year_graduated YEAR NULL,
  job_assignment VARCHAR(60) NULL,
  modified DATETIME NULL,
  modified_by INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX contact_information_FKIndex1(member_id)
);

CREATE TABLE preferences (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  PRIMARY KEY(id),
  INDEX preferences_FKIndex1(member_id)
);

CREATE TABLE registration_details (
  id INTEGER UNSIGNED NOT NULL AUTO_INCREMENT,
  member_id INTEGER UNSIGNED NOT NULL,
  registration_year YEAR NULL,
  registration_decision_number INTEGER UNSIGNED NULL,
  registration_decision_date DATE NULL,
  photos_for_documents BOOL NULL,
  registration_form BOOL NULL,
  notes TEXT NULL,
  modified DATETIME NULL,
  modified_by INTEGER UNSIGNED NULL,
  PRIMARY KEY(id),
  INDEX membership_information_FKIndex1(member_id)
);


