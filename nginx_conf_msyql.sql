CREATE TABLE services (
  id int auto_increment NOT NULL UNIQUE,
  domain_name varchar(255) NOT NULL,
  serverip varchar(255) NOT NULL,
  status int NOT NULL default 0,
  userid int not null default 1,
  conf_name varchar(255) not null,
  primary key(domain_name,serverip)
);
CREATE TABLE users (
  id int auto_increment NOT NULL UNIQUE,
  username varchar(255) NOT NULL,
  password varchar(255) NOT NULL,
  admin varchar(255) NOT NULL default 'no',
  primary key(username)
);
INSERT INTO users VALUES (1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'yes');
create table upstreams (
 id int auto_increment not null unique,
 upstream_name varchar(255) not null,
 real_server varchar(255) not null,
 options varchar(255) default null,
 service_id int not null,
 primary key(upstream_name,real_server) 
);
create table locations (
 id int auto_increment not null unique,
 location_path varchar(255) not null,
 alias varchar(255) default null,
 root_path varchar(255) default null,
 proxy_pass varchar(255) default null,
 proxy_next_upstream varchar(255) default null,
 access_log varchar(255) not null,
 valid_referers varchar(500) default null,
 service_id int not null,
 primary key(location_path,service_id)
);
create table templates (
 id int auto_increment not null unique,
 template_name varchar(255) not null,
 template_type varchar(255) not null,
 userid int not null,
 date datetime not null,
 primary key(template_name)
);
create table rewrites (
 id int auto_increment not null unique,
 protasis varchar(500) not null,
 method varchar(255) not null,
 comments varchar(255) not null
);
create table rewrites_in_location (
 id int auto_increment not null unique,
 location_id int not null,
 service_id int not null,
 comments varchar (255) not null,
 primary key(location_id,service_id,comments)
);
