CREATE TABLE account (
    accountID INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR UNIQUE,
    password VARCHAR
);

CREATE TABLE photo (
    photoID INT AUTO_INCREMENT PRIMARY KEY,
    data VARCHAR
);

CREATE TABLE account_photo (
    accountID INT,
    photoID INT,
    FOREIGN KEY (accountID) REFERENCES account(accountID),
    FOREIGN KEY (photoID) REFERENCES photo(photoID)
);

INSERT INTO account (username, password)
VALUES
    ('user1', 'Password1'),
    ('user2', 'Password2'),
    ('user3', 'Password3');

INSERT INTO photo (data)
VALUES
    ('D:\\photos\\photo1.jpg'),
    ('D:\\photos\\photo2.jpg'),
    ('D:\\photos\\photo3.jpg');

INSERT INTO account_photo (accountID, photoID)
VALUES
    (1, 1),
    (2, 2),
    (3, 3);
