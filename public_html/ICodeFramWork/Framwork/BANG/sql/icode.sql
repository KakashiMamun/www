use bang;
CREATE TABLE user
(
   user_id BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY auto_increment,
   class ENUM('Admin', 'Manager', 'Director', 'Accountant','Employee', 'Contact') NOT NULL,
   email VARCHAR(100) NOT NULL UNIQUE,
   password VARCHAR(36) NOT NULL,
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
CREATE TABLE icode_error
(
   error_id BIGINT(20) UNSIGNED  NOT NULL PRIMARY KEY auto_increment,
   date timestamp NOT NULL,
   script varchar(255) NOT NULL,
   category varchar(255) NOT NULL,
   error_code varchar(100),
   error_msg text
);
CREATE TABLE icode_file
(
   file_id BIGINT(20) UNSIGNED  NOT NULL PRIMARY KEY auto_increment, 
   cdn_id INT(9) NOT NULL default 0,
   path varchar(255) NOT NULL,
   file_name varchar(255) NOT NULL,
   has_thumb enum ('yes','no') NOT NULL default 'no',
   type varchar(50) NOT NULL,
   added_on datetime NOT NULL
);
CREATE TABLE if not exists icode_cart
(                                                            
    cart_id BIGINT(20) UNSIGNED not null primary key auto_increment,
    customer_id BIGINT(20) not null,
    product_id BIGINT(20) not null,
    product_type ENUM('site','tenant') NOT NULL default 'site',
    currency_code char(3) not null,
    amount decimal(9,2) not null,
    transaction_id varchar(100),         
    paying_account varchar(200),
    cart_date date not null,
    payment_date date,
    gateway enum('nanacast','paypal'),
    status enum('payment_waiting','payment_recieved','canceled'),
    name varchar(255),
    address varchar(255),
    city_id int(3),
    state_id int(3),
    postcode varchar(15),
    country_code char(5)
);
             
CREATE TABLE IF NOT EXISTS state (
  state_id int(11) UNSIGNED UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  PRIMARY KEY (state_id)
);
    
CREATE TABLE IF NOT EXISTS city (
  city_id int(11) UNSIGNED NOT NULL AUTO_INCREMENT,
  name varchar(200) NOT NULL,
  state_id int(11) NOT NULL,
  PRIMARY KEY (city_id)
);
    
create table category
(
  cat_id INT(4) UNSIGNED not null primary key auto_increment,
  parent INT(4) UNSIGNED not null default 0,
  name varchar(100) not null
);

create table country
(
  country_code char(3) not null primary key,
  name varchar(200) not null unique
);

create table unique_code
(
    id INT(10) UNSIGNED not null primary key auto_increment,
    code char(16) not null unique
);


create table unique_number
(
  id BIGINT(20) UNSIGNED not null primary key auto_increment,
  number BIGINT(20) UNSIGNED not null unique
);

