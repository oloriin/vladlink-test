CREATE TABLE menu
(
    id INT PRIMARY KEY,
    name VARCHAR(255),
    alias VARCHAR(255) ,
    parent_id INT
);
ALTER TABLE menu CONVERT TO CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;