ALTER TABLE Login DROP FOREIGN KEY Login_User;
ALTER TABLE Inventory DROP FOREIGN KEY Inventory_Location;
ALTER TABLE Inventory DROP FOREIGN KEY Inventory_Category;
ALTER TABLE Inventory DROP FOREIGN KEY Inventory_User;
ALTER TABLE Discarded DROP FOREIGN KEY Discarded_Location;
ALTER TABLE Discarded DROP FOREIGN KEY Discarded_Category;
ALTER TABLE Discarded DROP FOREIGN KEY Discarded_User;

DROP TABLE IF EXISTS User, Login, Inventory, Discarded, Location, Category; 

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
  Username varchar(15) NOT NULL,
  Password varchar(60) DEFAULT NULL,
  PRIMARY KEY (Username)
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

--
-- Table structure for table Inventory
--
CREATE TABLE Inventory (
  InventoryNum int(11) NOT NULL AUTO_INCREMENT,
  Name varchar(30) DEFAULT NULL,
  LocationID int(11) DEFAULT NULL,
  CategoryID int(11) DEFAULT NULL,
  Quantity int(11) DEFAULT NULL,
  LastQuantityUpdate datetime DEFAULT NULL,
  Username varchar(15) NOT NULL,
  DescriptionInventory varchar(50) DEFAULT NULL,
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
  QuantityDiscarded int(11) DEFAULT NULL,
  LastDiscardUpdate datetime DEFAULT NULL,
  Username varchar(15) NOT NULL,
  DescriptionDiscarded varchar(50) DEFAULT NULL,
  PRIMARY KEY (DiscardedInventoryNum)
)ENGINE=INNODB;


-- Foreign Keys
-- Reference: Username (table: Login)
ALTER TABLE Login ADD CONSTRAINT Login_User FOREIGN KEY Login_User (Username)
    REFERENCES User (Username);

-- Reference: Location (table: Inventory)
ALTER TABLE Inventory ADD CONSTRAINT Inventory_Location FOREIGN KEY Inventory_Location (LocationID)
    REFERENCES Location (LocationID);

-- Reference: Caetegory (table: Inventory)
ALTER TABLE Inventory ADD CONSTRAINT Inventory_Category FOREIGN KEY Inventory_Category (CategoryID)
    REFERENCES Category (CategoryID);

-- Reference: Username (table: Inventory)
ALTER TABLE Inventory ADD CONSTRAINT Inventory_User FOREIGN KEY Inventory_User (Username)
    REFERENCES User (Username);

-- Reference: Location (table: Discarded)
ALTER TABLE Discarded ADD CONSTRAINT Discarded_Location FOREIGN KEY Discarded_Location (LocationID)
    REFERENCES Location (LocationID);

-- Reference: Caetegory (table: Discarded)
ALTER TABLE Discarded ADD CONSTRAINT Discarded_Category FOREIGN KEY Discarded_Category (CategoryID)
    REFERENCES Category (CategoryID);

-- Reference: Username (table: Discarded)
ALTER TABLE Discarded ADD CONSTRAINT Discarded_User FOREIGN KEY Discarded_User (Username)
    REFERENCES User (Username);
