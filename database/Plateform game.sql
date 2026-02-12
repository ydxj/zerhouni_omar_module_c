create database game_plateform;
use game_plateform;

-- admin table
create table admin(
	id int primary key auto_increment,
	username varchar(60),
    password varchar(255),
    registred timestamp,
    last_login timestamp
);

-- user table
create table user_plateform(
	id int primary key auto_increment,
	username varchar(60),
    password varchar(255),
	registred timestamp,
    last_login timestamp,
    game_score int,
    uploaded_games varchar(255),
    blocked int default 0,
    block_reason varchar(255) default null
);

-- game table 
create table game(
	id int primary key auto_increment,
    title varchar(50),
    description varchar(255),
    optional_thumbnail varchar(255),
    slug varchar(255),
    author int,
    deleted int default 0, -- 0 is false, and the 1 is true
    foreign key(author) references user_plateform(id) on delete cascade
);

-- game version 
create table game_version(
	id int primary key auto_increment,
    game int,
    version_timestamp timestamp,
    path_to_game_files varchar(255),
	foreign key(game) references game(id) on delete cascade
);

-- game score table
create table game_score(
	id int primary key auto_increment,
    user int,
    game_version int,
    score int,
    foreign key(user) references user_plateform(id) on delete cascade,
    foreign key(game_version) references game_version(id) on delete cascade
);


-- admin inserts
insert into admin (id, username,password, registred, last_login) values 
	(1,admin1,"hellouniverse1!",now(),now()),
    (2,admin2,"hellouniverse2!",now(),now());
    
-- user inserts
insert into user_plateform (id, username,password, registred, last_login) values 
	(1,player1,"helloworld1!",now(),now()),
    (2,player2,"helloworld2!",now(),now()),
    (3,dev1,"hellobyte1!",now(),now()),
    (4,dev2,"hellobyte2!",now(),now());

-- Games inserts
insert into game (id, title,description, slug, author) values 
	(1,"Demo Game 1","This is demo game 1","demo-game-1",3),
    (2,"Demo Game 2","This is demo game 2","demo-game-2",4);

-- Game Versions
-- i need to add them here but it need explanation 


-- Scores insert 
insert into game_score (id, user,game_version, score) values 
	(1,1,"first version of Demo Game 1",10.0), -- update here after you insert the games version
    (2,1,"first version of Demo Game 1",15.0),
    (3,1,"latest version of Demo Game 1",12.0),
    (4,2,"latest version of Demo Game 1",20.0),
    (5,2,"latest version of Demo Game 2",30.0),
    (6,3,"latest version of Demo Game 1",1000.0),
    (7,3,"latest version of Demo Game 1",-300.0 ),
    (8,4,"latest version of Demo Game 1",5.0),
    (9,4,"latest version of Demo Game 2",200.0);
    
