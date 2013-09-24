create table icode_error_log(

  id INT primary key NOT NULL auto_increment ,
  uri varchar (30),
  content text,
  module varchar (20),
  function varchar (20),
  type varchar (20)

);