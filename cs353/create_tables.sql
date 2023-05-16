CREATE TABLE any_user (
	user_id char(40) NOT NULL PRIMARY KEY,
	password varchar(25) NOT NULL,
	first_name varchar(25) DEFAULT NULL,
	middle_name varchar(25) DEFAULT NULL,
	last_name varchar(25) DEFAULT NULL,
	email varchar(40) DEFAULT NULL,
	phone_num varchar(12) DEFAULT NULL,
	gender varchar(25) DEFAULT NULL,
	date_of_birth date DEFAULT NULL,
	age varchar(3) DEFAULT NULL) ENGINE=InnoDB;


CREATE TABLE admin (
	user_id char(40) PRIMARY KEY,
	jurisdiction varchar(40),
	FOREIGN KEY (user_id) references any_user(user_id)) ENGINE=InnoDB;
    
CREATE TABLE civilian (
	user_id char(40) PRIMARY KEY,
	balance numeric (20,2),
	FOREIGN KEY (user_id) references any_user(user_id) ) ENGINE=InnoDB;
    
CREATE TABLE any_event (
    event_id int PRIMARY KEY AUTO_INCREMENT,
    event_name varchar(50) NOT NULL,
    event_date date NOT NULL,
    description varchar(250) NOT NULL,
    organiser varchar(50) NOT NULL,
    type varchar(25),
    start_time time NOT NULL,
    end_time time NOT NULL,
    age_restriction int NOT NULL,
    address varchar(90) NOT NULL,
    attendance int NOT NULL,
    quota char(10)) ENGINE=InnoDB;
    
CREATE TABLE ticket (
    ticket_id int PRIMARY KEY AUTO_INCREMENT,
    event_id int NOT NULL,
    ticket_type varchar(20) NOT NULL UNIQUE,
    ticket_price int,
    FOREIGN KEY (event_id) references any_event(event_id)) ENGINE=InnoDB;
    
CREATE TABLE buy_ticket (
    purchase_id int PRIMARY KEY AUTO_INCREMENT,
    user_id char(40),
    ticket_id int,
    FOREIGN KEY (user_id) references civilian(user_id),
    FOREIGN KEY (ticket_id) references ticket(ticket_id) ) ENGINE=InnoDB;

CREATE TABLE joins (
    user_id char(40),
    event_id int,
    FOREIGN KEY (event_id) references any_event(event_id),
    FOREIGN KEY (user_id) references any_user(user_id) ) ENGINE=InnoDB;

CREATE TABLE souvenir (
    souvenir_id int PRIMARY KEY AUTO_INCREMENT,
    event_id int NOT NULL,
    souvenir_name varchar(20) NOT NULL UNIQUE,
    souvenir_price int,
    FOREIGN KEY (event_id) references any_event(event_id)) ENGINE=InnoDB;

CREATE TABLE buy_souvenir (
    purchase_id int PRIMARY KEY AUTO_INCREMENT,
    user_id char(40),
    souvenir_id int,
    FOREIGN KEY (user_id) references civilian(user_id),
    FOREIGN KEY (souvenir_id) references souvenir(souvenir_id) ) ENGINE=InnoDB;