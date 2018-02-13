--
-- Table structure for table User
--
CREATE TABLE User (
  Username varchar(15) NOT NULL,
  FirstName varchar(30) DEFAULT NULL,
  LastName varchar(30) DEFAULT NULL,
  Email varchar(50) DEFAULT NULL,
  PRIMARY KEY (Username)
)ENGINE=INNODB;

--
-- Table structure for table Login
--
CREATE TABLE Login (
  Username varchar(15) NOT NULL AUTO_INCREMENT,
  Password varchar(60) DEFAULT NULL,
  PRIMARY KEY (Username)
)ENGINE=INNODB;

--
-- Table structure for table Inventory
--
CREATE TABLE Inventory (
  InventoryNum int(11) NOT NULL AUTO_INCREMENT,
  Name varchar(30) DEFAULT NULL,
  Location varchar(30) DEFAULT NULL,
  Category varchar(50) DEFAULT NULL,
  Quanity int(11) DEFAULT NULL,
  LastQuanityUpdate smalldatetime DEFAULT NULL,
  Username varchar(15) DEFAULT NULL,
  PRIMARY KEY (InventoryNum)
)ENGINE=INNODB;

--
-- Table structure for table Discarded
--
CREATE TABLE Discarded (
  DiscardedInventoryNum int(11) NOT NULL AUTO_INCREMENT,
  Name varchar(30) DEFAULT NULL,
  LocationID int(11) DEFAULT NULL,
  CategoryID int(11) DEFAULT NULL,
  QuanityDiscarded int(11) DEFAULT NULL,
  LastDiscardUpdate smalldatetime DEFAULT NULL,
  Username varchar(15) DEFAULT NULL,
  PRIMARY KEY (DiscardedInventoryNum)
)ENGINE=INNODB;

--
-- Table structure for table Location
--
CREATE TABLE Location (
  LocationID int(11) NOT NULL AUTO_INCREMENT,
  LocationName varchar(30) DEFAULT NULL,
  PRIMARY KEY (LocationID)
)ENGINE=INNODB;

--
-- Table structure for table Category
--
CREATE TABLE Category (
  CategoryID int(11) NOT NULL AUTO_INCREMENT,
  CategoryName varchar(30) DEFAULT NULL,
  PRIMARY KEY (CategoryID)
)ENGINE=INNODB;

