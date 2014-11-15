<!DOCTYPE html>
<html>
    <title>Setting Up Database</title>
</html>
<body>
    <h3>Setting up...</h3>
<?php
//functions.php is where the database functions are
//including other functions.
include 'functions.php';

//DROP TABLE IF EXISTS User, Account, Transaction, Mortgage, CreditCard

createTable('Users', 'username VARCHAR(30) NOT NULL PRIMARY KEY,
                      password VARCHAR(30) NOT NULL,
                      email VARCHAR(30) NOT NULL,
                      loginDate DATE,
                      openDate DATE
            ');

createTable('Account', 'accID INT PRIMARY KEY,
                        username VARCHAR(30),
                        acctype VARCHAR(30),
                        balance FLOAT,
                        interest FLOAT,
                        date TIMESTAMP,
                        FOREIGN KEY(username) REFERENCES Users(username)
			ON DELETE CASCADE
            ');

createTable('Transaction', 'accID INT PRIMARY KEY,
                            username VARCHAR(30),
                            acctype VARCHAR(30),
                            transtype VARCHAR(30),
                            toID INT,
                            date TIMESTAMP,
                            FOREIGN KEY(username) REFERENCES Users(username)
                            ON DELETE CASCADE
            ');

createTable('Mortgage', 'accID INT PRIMARY KEY,
                        username VARCHAR(30),
                        balance FLOAT,
                        minPayment DOUBLE,
                        interestRate FLOAT,
                        date TIMESTAMP,
                        FOREIGN KEY(username) REFERENCES Users(username)
                        ON DELETE CASCADE
            ');

createTable('CreditCard', 'accID INT PRIMARY KEY,
                            username VARCHAR(30),
                            balance FLOAT,
                            minPayment DOUBLE,
                            interestRate FLOAT,
                            maxLimit DOUBLE,
                            date TIMESTAMP, 
                            FOREIGN KEY (username) REFERENCES Users(username)
                            ON DELETE CASCADE
            ');
?>

</body>
</html>
