use loginserver;
CREATE TABLE user
(
   user_id BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY auto_increment,
   class ENUM('Admin', 'Manager', 'Director', 'Accountant','Employee', 'Contact') NOT NULL,
   email CHAR(30) NOT NULL UNIQUE,
   name CHAR(30) NOT NULL,
   password CHAR(32) NOT NULL,
   status ENUM ('active','inactive','pending','needPassword','pendingEmailVerification','pendingMobileVerification') NOT NULL,
   forget_minutes int(9) NOT NULL default '2880',
   reg_date datetime NOT NULL
);


CREATE TABLE user_detail
(      
   user_id BIGINT(20) UNSIGNED  NOT NULL PRIMARY KEY,
   title varchar(15) NOT NULL,
   f_name varchar(255) NOT NULL,
   l_name varchar(255) NOT NULL,
   job_title varchar(255) NOT NULL,      
   company_name varchar(255) NOT NULL,  
   company_id BIGINT(20) UNSIGNED  NOT NULL default '0',
   phone varchar(20) NOT NULL,
   mobile varchar(20) NOT NULL,
   address  varchar(255) NOT NULL,
   city_id  int(3) NOT NULL,
   state_id int(3) NOT NULL,
   postcode varchar(15) NOT NULL,
   country_code char(5) NOT NULL,
   capabilities VARCHAR(255)
);
drop table if exists icode_configuration;
CREATE TABLE icode_configuration
(
   name varchar(255) NOT NULL PRIMARY KEY,
   value varchar(255) NOT NULL,
   type ENUM('developer','pagination','server','email') NOT NULL default 'developer'
);
insert  into icode_configuration values('salt','urboshilogin','developer');

