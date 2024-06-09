CREATE TABLE restaurant (
	id VARCHAR(30) NOT NULL,
	name VARCHAR(30) NOT NULL,
    latitude FLOAT NOT NULL,
    longitude FLOAT NOT NULL,
    rating FLOAT NOT NULL,
    comment_num INT NOT NULL,
	PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE user (
	name VARCHAR(30) NOT NULL,
	password VARCHAR(60) NOT NULL,
	PRIMARY KEY (name)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE hope (
	restaurant_id VARCHAR(30) NOT NULL,
    user_name VARCHAR(30) NOT NULL,
	PRIMARY KEY (restaurant_id, user_name),
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(id) ON DELETE CASCADE,
    FOREIGN KEY (user_name) REFERENCES user(name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE love (
	restaurant_id VARCHAR(30) NOT NULL,
    user_name VARCHAR(30) NOT NULL,
	PRIMARY KEY (restaurant_id, user_name),
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(id) ON DELETE CASCADE,
    FOREIGN KEY (user_name) REFERENCES user(name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE message (
	restaurant_id VARCHAR(30) NOT NULL,
    user_name VARCHAR(30) NOT NULL,
	text VARCHAR(100),
	PRIMARY KEY (restaurant_id, user_name),
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(id) ON DELETE CASCADE,
    FOREIGN KEY (user_name) REFERENCES user(name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE tag (
	restaurant_id VARCHAR(30) NOT NULL,
    user_name VARCHAR(30) NOT NULL,
	keyword VARCHAR(30),
	PRIMARY KEY (restaurant_id, user_name, keyword),
    FOREIGN KEY (restaurant_id) REFERENCES restaurant(id) ON DELETE CASCADE,
    FOREIGN KEY (user_name) REFERENCES user(name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE friend (
	user1_name VARCHAR(30) NOT NULL,
    user2_name VARCHAR(30) NOT NULL,
	text VARCHAR(100),
	PRIMARY KEY (user1_name, user2_name),
    FOREIGN KEY (user1_name) REFERENCES user(name) ON DELETE CASCADE,
    FOREIGN KEY (user2_name) REFERENCES user(name) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;