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

create table game(
	id int primary key auto_increment,
    description varchar(255),
    optional_thumbnail varchar(255),
    slug varchar(255),
    author int,
    foreign key(author) references user_plateform(id)
);

create table game_version(
	id int primary key auto_increment,
    game int,
    version_timestamp timestamp,
    path_to_game_files varchar(255),
	foreign key(game) references game(id)
);


create table game_score(
	id int primary key auto_increment,
    user int,
    game_version int,
    score int,
    foreign key(user) references user_plateform(id),
    foreign key(game_version) references game_version(id)
);