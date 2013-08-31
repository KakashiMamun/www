USE Bang;

CREATE TABLE Bang.session_table
(
    user_id INT PRIMARY KEY NOT NULL auto_increment,
    session_key VARCHAR(100) NOT NULL,
    user_data VARCHAR(300) NOT NULL,
    exp_date DATE NOT NULL
) ENGINE=MEMORY;
