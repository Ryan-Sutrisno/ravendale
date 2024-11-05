DROP DATABASE IF EXISTS `ravendale`;

CREATE DATABASE `ravendale`;

USE `ravendale`;

CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    profile_picture VARCHAR(255) DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    role ENUM('admin', 'moderator', 'user') DEFAULT 'user'
);

CREATE TABLE Categories (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE Subforums (
    id INT AUTO_INCREMENT PRIMARY KEY,
    category_id INT,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT DEFAULT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (category_id) REFERENCES Categories(id) ON DELETE CASCADE
);

CREATE TABLE Threads (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subforum_id INT,
    user_id INT,
    title VARCHAR(255) NOT NULL,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    is_locked BOOLEAN DEFAULT FALSE,
    views INT DEFAULT 0,
    FOREIGN KEY (subforum_id) REFERENCES Subforums(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE SET NULL
);

CREATE TABLE Posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    thread_id INT,
    user_id INT,
    content TEXT NOT NULL,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (thread_id) REFERENCES Threads(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE SET NULL
);

CREATE TABLE Likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    type ENUM('reply', 'like', 'mention') NOT NULL,
    related_id INT DEFAULT NULL,
    is_read BOOLEAN DEFAULT FALSE,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

CREATE TABLE Reports (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT,
    user_id INT,
    reason TEXT NOT NULL,
    status ENUM('pending', 'resolved', 'dismissed') DEFAULT 'pending',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES Posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES Users(id) ON DELETE CASCADE
);

-- Insert into Users table
INSERT INTO Users (username, email, password, profile_picture, role)
VALUES 
('johndoe', 'johndoe@example.com', 'hashedpassword1', 'john_profile.jpg', 'user'),
('janedoe', 'janedoe@example.com', 'hashedpassword2', 'jane_profile.jpg', 'admin');

-- Insert into Categories table
INSERT INTO Categories (name, description)
VALUES 
('General Discussion', 'A place for general discussions about various topics.'),
('Gaming', 'Talk about everything related to gaming.');

-- Insert into Subforums table
INSERT INTO Subforums (category_id, name, description)
VALUES 
(1, 'Introductions', 'New to the forum? Introduce yourself here!'),
(2, 'Game Reviews', 'Discuss and review the latest games.');

-- Insert into Threads table
INSERT INTO Threads (subforum_id, user_id, title, content, is_locked, views)
VALUES 
(1, 1, 'Hello Everyone!', 'Just joined the forum, excited to be here!', FALSE, 23),
(2, 2, 'Review of Ravendale RPG', 'Here are my thoughts on the new Ravendale RPG...', FALSE, 15);

-- Insert into Posts table
INSERT INTO Posts (thread_id, user_id, content)
VALUES 
(1, 2, 'Welcome to the forum! Hope you enjoy it here.'),
(2, 1, 'Great review, I agree with most of your points.');

-- Insert into Likes table
INSERT INTO Likes (post_id, user_id)
VALUES 
(1, 1),
(2, 2);

-- Insert into Notifications table
INSERT INTO Notifications (user_id, type, related_id, is_read)
VALUES 
(1, 'reply', 1, FALSE),
(2, 'like', 2, TRUE);

-- Insert into Reports table
INSERT INTO Reports (post_id, user_id, reason, status)
VALUES 
(1, 2, 'Offensive content', 'pending'),
(2, 1, 'Spam content', 'resolved');
