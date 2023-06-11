Database name is bitcot

1. Create Table users in bitcot db
CREATE TABLE `bitcot`.`users` (`first_name` VARCHAR(255) NOT NULL , `last_name` VARCHAR(255) NOT NULL , `user_role` VARCHAR(255) NOT NULL , `email` VARCHAR(255) NOT NULL , `password` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;

2. Insert users in the table 
DELETE FROM users where 1=1;
INSERT INTO users VALUES ("Deepesh", "Acharya", "super_admin", "deepeshac280@gmail.com", "deep1", "deep123");
INSERT INTO users VALUES ("User2", "Surname2", "super_admin", "user2@gmail.com", "userPass2", "user2");
INSERT INTO users VALUES ("User3", "Surname3", "super_admin", "user3@gmail.com", "userPass3", "user3");
INSERT INTO users VALUES ("User4", "Surname4", "super_admin", "user4@gmail.com", "userPass4", "user4");
INSERT INTO users VALUES ("User5", "Surname5", "super_admin", "user5@gmail.com", "userPass5", "user5");
INSERT INTO users VALUES ("User6", "Surname6", "super_admin", "user6@gmail.com", "userPass6", "user6");
INSERT INTO users VALUES ("User7", "Surname7", "super_admin", "user7@gmail.com", "userPass7", "user7");
INSERT INTO users VALUES ("User8", "Surname8", "super_admin", "user8@gmail.com", "userPass8", "user8");
INSERT INTO users VALUES ("User9", "Surname9", "super_admin", "user9@gmail.com", "userPass9", "user9");

3. Create Table userRoles in bitcot db
CREATE TABLE `bitcot`.`userroles` (`role_name` VARCHAR(255) NOT NULL , `dashboard_access` VARCHAR(255) NOT NULL , `aboutUs_access` VARCHAR(255) NOT NULL , `managerList_access` VARCHAR(255) NOT NULL , `salesPerson_access` VARCHAR(255) NOT NULL ) ENGINE = InnoDB;

4. Create initial data for each role
DELETE FROM userroles where 1=1;
INSERT INTO userroles VALUES ("manager", "View", "View", "View | Add | Edit","View | Add | Edit | Delete");
INSERT INTO userroles VALUES ("salesperson", "", "", "","View | Add | Edit");
INSERT into userroles VALUES("super_admin","View","View","View | Edit | Delete | Add", "View | Edit | Delete | Add");

5. To reset the userroles
UPDATE userroles SET dashboard_access="",managerList_access="",salesPerson_access="",aboutUs_access="";