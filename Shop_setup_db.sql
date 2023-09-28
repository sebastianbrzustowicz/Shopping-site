USE Shop_data;
GO

DROP TABLE Shop;
DROP TABLE Products;

CREATE TABLE Shop (
    PersonID int,
	Permission varchar(255),
    FirstName varchar(255),
    LastName varchar(255),
	Login varchar(255),
	Password varchar(255),
	Mail varchar(255),
    Address varchar(255),
    City varchar(255),
	order_date varchar(255),
	ordered_cart_cost float,
	product1 int,
	product2 int,
	product3 int,
	PR1 int,
	PR2 int,
	PR3 int
);


CREATE TABLE Products (
	ProductID int,
    Name varchar(255),
    Cost float,
	Description varchar(255),
);

INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES (1, 'Admin', 'Sebastian', 'Brzustowicz', 'SB123', 'SB123', 'Se.Brzustowicz@gmail.com', 'Rocha 11', 'Poznan', NULL, NULL, 0, 0, 0, 0, 0, 0);

INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES (2, 'Customer', 'Adam', 'Gaba³a', 'Ad1m0s', 'gabaa', 'spiderman1998@gmail.com', 'Szyperska 12', 'Poznan', NULL, NULL, 0, 0, 0, 0, 0, 0);

INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES (3, 'Customer', 'Piotr', 'Jankowski', 'K4pex', 'kpx', 'PJ@gmail.com', 'Mickiewicza 22', 'Poznan', NULL, NULL, 0, 0, 0, 0, 0, 0);

INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES (4, 'Customer', 'Piotr', 'KaŸmierczak', 'PK', 'PK', 'PK@gmail.com', 'Okrê¿na 8', 'Odolion', NULL, NULL, 0, 0, 0, 0, 0, 0);

INSERT INTO Shop (PersonID, Permission, FirstName, LastName, Login, Password, Mail, Address, City, order_date, ordered_cart_cost, product1, product2, product3, PR1, PR2, PR3)
VALUES (5, 'Customer', 'Adrian', 'KaŸmierczak', 'AK', 'AK', 'AK@gmail.com', 'Osiedlowa 8', 'Odolion', NULL, NULL, 0, 0, 0, 1, 2, 3);

INSERT INTO Products (ProductID, Name, Cost, Description)
VALUES (1, 'Oregano 50g', 0.99, 'Some text about oregano...');

INSERT INTO Products (ProductID, Name, Cost, Description)
VALUES (2, 'Rosemary 50g', 1.99, 'Some text about rosemary...');

INSERT INTO Products (ProductID, Name, Cost, Description)
VALUES (3, 'Mint 50g', 0.99, 'Some text about mint...');

UPDATE Shop
SET order_date = CAST('2023-03-25' AS DATETIME), PR1 = 2
WHERE Login = 'K4pex';

Select * FROM Shop

Select * FROM Products

SELECT Password FROM Shop
Where Login = 'SB123';

INSERT INTO Shop (PersonID, FirstName, LastName, Login, Password, Address, City, order_date, cost)
VALUES (1, '$name', '$surname', '$login', '$password','$address', '$city', CAST(GETDATE() AS varchar(255)), 200);

UPDATE Shop
SET product1 = 2, product2 = 2, product3 = 2
WHERE login = 'SB123';

SELECT product1, product2, product3 FROM Shop
WHERE login = 'SB123';

select count(IIF(Login = 'SB123', 1, NULL))
from Shop

SELECT IIF(Login != NULL, MAX(PersonID), 1)
FROM Shop;

select count(Login)  
from Shop

SELECT *
FROM Shop
WHERE order_date IS NOT NULL
ORDER BY order_date ASC;


UPDATE Shop
SET ordered_cart_cost = NULL, product1 = 0,product2 = 0 ,product3 = 0,PR1 = 0,PR2 = 0 ,PR3 = 0 WHERE Login = 'login';

SELECT TOP 1 ordered_cart_cost
FROM Shop
ORDER BY ordered_cart_cost DESC;

SELECT ROUND(SUM(ordered_cart_cost),0)
FROM Shop
WHERE MONTH(order_date) = 5 OR MONTH(order_date) = 4;

UPDATE Shop
SET order_date = 'April 24 2023 9:50AM'
WHERE login = 'PK';

UPDATE Shop
SET ordered_cart_cost = 15
WHERE login = 'Ad1m0s';

UPDATE Shop
SET order_date = CAST('2023-02-25' AS DATETIME)
WHERE Login = 'AK';

Select * FROM Shop