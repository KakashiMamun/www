use bang;
create table tag
(
    tag_id BIGINT(20) UNSIGNED NOT NULL   PRIMARY KEY auto_increment,
    name VARCHAR(100) NOT NULL UNIQUE
);

create table contact_tag
(
    contact_id BIGINT(20) UNSIGNED NOT NULL ,
    tag_id BIGINT(20) UNSIGNED NOT NULL ,
    PRIMARY KEY ( contact_id, tag_id )
);

create table contact_relation
(     
    contact_relation_id BIGINT(20) UNSIGNED NOT NULL UNIQUE auto_increment,
    contact_id BIGINT(20) UNSIGNED NOT NULL ,
    rel_id BIGINT(20) UNSIGNED NOT NULL ,
    relation ENUM('Colleague','Friend','Associate', 'Brother', 'Sister','Cousin','Uncle','Father','Mother','Aunt','Son','Daughter', 'Grandchild'),
    PRIMARY KEY ( contact_id, rel_id )

);

create table project
(        
    project_id BIGINT(20) UNSIGNED NOT NULL   PRIMARY KEY auto_increment,
    owner_id BIGINT(20) UNSIGNED NOT NULL ,
    manager_id BIGINT(20) UNSIGNED NOT NULL ,
    title VARCHAR(255) NOT NULL,
    description text NOT NULL,
    file_ids VARCHAR(255) NOT NULL,
    status ENUM('Seed','Discussing','Proposed','Confirmed','Started') NOT NULL,
    priority ENUM('Low','Moderate','High','Urgent','Emergency') NOT NULL,
    date_added datetime NOT NULL,
    date_started datetime NOT NULL default '0000-00-00'

);   
create table project_tag
(
    project_id BIGINT(20) UNSIGNED NOT NULL ,
    tag_id BIGINT(20) UNSIGNED NOT NULL ,
    PRIMARY KEY ( project_id, tag_id )
);

create table contact_history
(                                              
    contact_history_id BIGINT(20) UNSIGNED NOT NULL PRIMARY KEY auto_increment,
    contact_id BIGINT(20) UNSIGNED NOT NULL,
    user_id  BIGINT(20) UNSIGNED NOT NULL,
    date_contacted datetime NOT NULL,
    summary varchar(255) NOT NULL,                
    content text NOT NULL
);

create table reminder
(                                                
    reminder_id BIGINT(20) UNSIGNED NOT NULL,   
    for_id BIGINT(20) UNSIGNED NOT NULL,
    for_type ENUM('contact','project','user') NOT NULL,
    user_id BIGINT(20) UNSIGNED NOT NULL,
    content text NOT NULL

);

