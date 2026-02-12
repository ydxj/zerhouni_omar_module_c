create database game_plateform;
use game_plateform;

create table admin(
	id int primary key auto_increment,
	username varchar(60),
    registred timestamp,
    last_login timestamp
);

create table user_plateform(
	id int primary key auto_increment,
	username varchar(60),
	registred timestamp,
    last_login timestamp,
    game_score int,
    uploaded_games varchar(255)
);

create table game_score(
	id int primary key auto_increment,
    user varchar(255),
    game_version varchar(50),
    score int
);

create table game(
	id int primary key auto_increment,
    description varchar(255),
    optional_thumbnail varchar(255),
    slug varchar(255),
    author int
);

create table game_version(
	id int primary key auto_increment,
    game int,
    version_timestamp timestamp,
    path_to_game_files varchar(255)
    
);