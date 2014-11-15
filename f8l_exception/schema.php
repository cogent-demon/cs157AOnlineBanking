<?php

$dbhost='localhost';
$dbuser='f8lexception'
$dbpass='Kim157'
//connect

mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
mysql_select_db("f8lexception") or die(mysql_error());

echo 'Connection Success!'

//DROP TABLE IF EXISTS User, Account, Transaction, Mortgage, CreditCard

mysql_query("CREATE TABLE User ( 
				username VARCHAR(30) NOT NULL PRIMARY KEY,
				password VARCHAR(30) NOT NULL,
				email VARCHAR(30) NOT NULL,
				loginDate DATE,
				openDate DATE )");

			//can you stuff mult create table in 1 query for effic?
			("CREATE TABLE Account (
			 	accID INT PRIMARY KEY,
			 	username VARCHAR(30),
			 	acctype VARCHAR(30),
			 	balance FLOAT,
			 	interest FLOAT,
			 	date TIMESTAMP,
			 	FOREIGN KEY (username) REFERENCE User(username)
			 	ON DELETE CASCADE
			 	 )")

			("CREATE TABLE Transaction (
				accID INT PRIMARY KEY,
				username VARCHAR(30),
				acctype VARCHAR(30),
				transtype VARCHAR(30),
				toID INT,
				date TIMESTAMP
				FOREIGN KEY (username) REFERENCE User(username)
			 	ON DELETE CASCADE
				 )")

			("CREATE TABLE Mortgage (
				accID INT FOREIGN KEY PRIMARY KEY,
				username VARCHAR(30) FOREIGN KEY,
				balance FLOAT,
				minPayment DOUBLE,
				interestRate FLOAT,
				date TIMESTAMP
				FOREIGN KEY (username) REFERENCE User(username)
			 	ON DELETE CASCADE
				 )")

			("CREATE TABLE CreditCard (
				accID INT FOREIGN KEY PRIMARY KEY,
				username VARCHAR(30),
				balance FLOAT,
				minPayment DOUBLE,
				interestRate FLOAT,
				maxLimit DOUBLE,
				date TIMESTAMP 
				FOREIGN KEY (username) REFERENCE User(username)
			 	ON DELETE CASCADE
				)")

			print("All databases have been created successfully");
?>
