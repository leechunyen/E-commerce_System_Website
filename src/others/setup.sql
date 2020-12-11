create table if not exists `admin`(
    `ID` int not null auto_increment,
    `Username` varchar(100) not null,
    `Password` varchar(100) not null,
    `Email` varchar(100) not null,
    `FirstName` varchar(100) not null,
    `LastName` varchar(100) not null,
    `Gender` char not null,
    `Photo` varchar(100) null,
    `Type` char not null,
    `Permission` varchar(100) null,
    `LastLoginIp` varchar(100) null,
    `LastLoginDateTime` datetime null,
    `CreateDateTime` datetime not null,
    `Locked` boolean not null,
    primary key(`ID`)
);
create table if not exists `user`(
    `ID` int not null auto_increment,
    `Username` varchar(100) not null,
    `Password` varchar(100) not null,
    `Email` varchar(120) not null,
    `FirstName` varchar(100) not null,
    `LastName` varchar(100) not null,
    `Gender` char not null,
    `Photo` varchar(100) null,
    `DobYear` int not null,
    `DobMonth` int not null,
    `DobDay` int not null,
    `CountryRegional` varchar(100) not null,
    `Activated` boolean not null,
    `Deleted` boolean not null,
    `Locked` boolean not null,
    `LastLoginIp` varchar(100) null,
    `LastLoginDateTime` datetime null,
    `CreateDateTime` datetime not null,
    primary key(`ID`)
);
create table if not exists `product`(
        `ID` int not null auto_increment,
        `Name` varchar(100) not null,
    `DefaultPhoto` varchar(100) not null,
    `Price` decimal(15,2) not null,
    `Detail` longtext null,
    `ModelID` varchar(100) not null,
    `Stock` int not null,
    `Available` boolean not null,
    `AutoAvailableDateTime` datetime null,
    `AutoUnavailableDateTime` datetime null,
    `ReorderPoint` int null,
    primary key(`ID`)
);
create table if not exists `user_coupon`(
    `ID` int not null auto_increment,
    `MinPay` decimal(15,2) not null,
    `Discount` decimal(15,2) not null,
    `ExpireDateTime` datetime not null,
    `Mode` char not null,
    `Used` boolean not null,
    `CouponTypeID` int not null,
    `UserID` int not null,
    primary key(`ID`),
    foreign key(`UserID`) references `user`(`ID`)
);
create table if not exists `payment`(
    `ID` int not null auto_increment,
    `PaidAmount` decimal(15,2) not null,
    `ShippingFee` decimal(15,2) not null,
    `DateTime` datetime not null,
    `ShippingMethodSelected` varchar(50) not null,
    `UserID` int not null,
    `UserCouponID` int null,
    primary key(`ID`),
    foreign key(`UserID`) references `user`(`ID`),
    foreign key(`UserCouponID`) references `user_coupon`(`ID`)
);
create table if not exists `shipping_method`(
    `ID` int not null auto_increment,
    `Title` varchar(50) not null,
    `Price` decimal(15,2) not null,
    `DeliveryDays` varchar(10) not null,
    primary key(`ID`)
);
create table if not exists `shipping_info`(
    `ID` int not null auto_increment,
    `Name` varchar(100) not null,
    `Phone` varchar(12) not null,
    `Email` varchar(100) not null,
    `Address` varchar(100) not null,
    `City` varchar(100) not null,
    `State` varchar(100) not null,
    `Country` varchar(100) not null,
    `Postcode` varchar(10) not null,
    `Tag` varchar(50) null,
    `UserID` int not null,
    primary key(`ID`),
    foreign key(`UserID`) references `user`(`ID`)
);
create table if not exists `delivery`(
    `ID` int not null auto_increment,
    `DateTime`datetime not null,
    `TrackingNumber` varchar(100) not null,
    `UserID` int not null,
    primary key(`ID`),
    foreign key(`UserID`) references `user`(`ID`)
);
create table if not exists `order`(
    `ID` int not null auto_increment,
    `DateTime` datetime not null,
    `TotalAmount` decimal(15,2) not null,
    `ShippingEmail` varchar(100) not null,
    `ShippingPhone` varchar(12) not null,
    `ShippingName` varchar(100) not null,
    `ShippingAddress` longtext not null,
    `Finished` boolean not null,
    `UserID` int not null,
    `DeliveryID` int null,
    `PaymentID` int null,
    primary key(`ID`),
    foreign key(`UserID`) references `user`(`ID`),
    foreign key(`DeliveryID`) references `delivery`(`ID`),
    foreign key(`PaymentID`) references `payment`(`ID`)
);
create table if not exists `coupon_type`(
    `ID` int not null auto_increment,
    `MinPay` decimal(15,2) not null,
    `Discount` decimal(15,2) not null,
    `DaysToExpired` int not null,
    `Mode` char not null,
    `Available` boolean not null,
    `Description` varchar(50) not null,
    primary key(`ID`)
);
create table if not exists `manage_supplier`(
    `ID` int not null auto_increment,
    `Name` varchar(100) not null,
    `Address` longtext not null,
    `Phone` varchar(12) not null,
    `Email` varchar(100) not null,
    primary key(`ID`)
);
create table if not exists `purchase_history`(
    `ID` int not null auto_increment,
    `Quantity` int not null,
    `Price` decimal(15,2) not null,
    `Count` int null,
    `Status` char not null,
    `ProductPhoto` varchar(100) not null,
    `ProductName` varchar(100) not null,
    `ProductModelID` varchar(100) not null,
    `SupplierID` int not null,
    `SupplierName` varchar(100) not null,
    `SupplierAddress`longtext not null,
    `SupplierEmail` varchar(100) not null,
    `SupplierPhone` varchar(12) not null,
    `ProductID` int not null,
    primary key(`ID`),
    foreign key(`ProductID`) references `product`(`ID`)
);
create table if not exists `product_photo`(
    `ProductID` int not null,
    `Photo` varchar(255) not null,
    primary key(`ProductID`,`Photo`),
    foreign key(`ProductID`) references `product`(`ID`)
);
create table if not exists `order_product`(
    `OrderID` int not null,
    `ProductID` int not null,
    `Remarks` longtext null,
    `ProductPrice` decimal(15,2) not null,
    `Quantity` int not null,
    `ProductName` varchar(100) not null,
    `ProductPhoto` varchar(100) not null,
    primary key(`OrderID`,`ProductID`),
    foreign key(`OrderID`) references `order`(`ID`),
    foreign key(`ProductID`) references `product`(`ID`)
);
create table if not exists `user_cart_product`(
    `UserID` int not null,
    `ProductID` int not null,
    `Remarks` longtext null,
    `DateTime` datetime not null,
    `Quantity` int not null,
    primary key(`UserID`,`ProductID`),
    foreign key(`ProductID`) references `product`(`ID`),
    foreign key(`UserID`) references `user`(`ID`)
);
create table if not exists `user_wishlist_product`(
    `UserID` int not null,
    `ProductID` int not null,
    `DateTime` datetime not null,
    primary key(`UserID`,`ProductID`),
    foreign key(`ProductID`) references `product`(`ID`),
    foreign key(`UserID`) references `user`(`ID`)
);