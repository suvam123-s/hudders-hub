-- =========================
-- USER_ACCOUNT
-- =========================
CREATE TABLE USER_ACCOUNT (
    user_ID        INTEGER PRIMARY KEY,
    first_name     VARCHAR2(50) NOT NULL,
    last_name      VARCHAR2(50) NOT NULL,
    age            INTEGER,
    DOB            DATE,
    phonenumber    VARCHAR2(20),
    email          VARCHAR2(150) NOT NULL UNIQUE,
    user_role      VARCHAR2(20) NOT NULL 
                   CHECK (user_role IN ('CUSTOMER','TRADER','ADMIN')),
    created_date   DATE DEFAULT SYSDATE,
    user_name      VARCHAR2(100),
    password       VARCHAR2(255) NOT NULL
    
);

-- =========================
-- SHOP
-- =========================
CREATE TABLE SHOP (
    shop_ID          INTEGER PRIMARY KEY,
    shop_name        VARCHAR2(100) NOT NULL,
    shop_type        VARCHAR2(50) NOT NULL,
    shop_location    VARCHAR2(255),
    shop_discription CLOB,
    user_ID          INTEGER NOT NULL,

    CONSTRAINT fk_shop_user FOREIGN KEY (user_ID) REFERENCES USER_ACCOUNT(user_ID)
);

-- =========================
-- COLLECTION_SLOT
-- =========================
CREATE TABLE COLLECTION_SLOT (
    slot_id    INTEGER PRIMARY KEY,
    slot_day   VARCHAR2(10) NOT NULL 
               CHECK (slot_day IN ('WED','THU','FRI')),
    slot_date  DATE NOT NULL,
    slot_time  VARCHAR2(20) NOT NULL 
               CHECK (slot_time IN ('10:00-13:00','13:00-16:00','16:00-19:00')),
    max_orders INTEGER DEFAULT 20,
    shop_ID    INTEGER NOT NULL,

    CONSTRAINT fk_slot_shop 
        FOREIGN KEY (shop_ID) REFERENCES SHOP(shop_ID),

    CONSTRAINT uq_slot 
        UNIQUE (slot_date, slot_time, shop_ID)
);

-- =========================
-- PRODUCT_CATEGORY
-- =========================
CREATE TABLE PRODUCT_CATEGORY (
    category_ID          INTEGER PRIMARY KEY,
    category_name        VARCHAR2(100) NOT NULL UNIQUE,
    category_description CLOB
);

-- =========================
-- DISCOUNT
-- =========================
CREATE TABLE DISCOUNT (
    discount_ID         INTEGER PRIMARY KEY,
    discount_code       VARCHAR2(50) NOT NULL UNIQUE,
    expiry_date         DATE NOT NULL,
    initiation_date     DATE DEFAULT SYSDATE,
    discount_percentage NUMBER(5,2) DEFAULT 0                        
    CHECK (discount_percentage > 0 AND discount_percentage <= 100)
);

-- =========================
-- PRODUCT
-- =========================
DROP TABLE PRODUCT CASCADE CONSTRAINTS;
CREATE TABLE PRODUCT (
    product_ID          INTEGER PRIMARY KEY,
    product_name        VARCHAR2(100) NOT NULL,
    product_description CLOB,
    item_price          NUMBER(10,2) NOT NULL CHECK (item_price > 0),
    quantity_per_item   VARCHAR2(50) NOT NULL,
    stock               INTEGER DEFAULT 0 NOT NULL,
    min_order           INTEGER DEFAULT 1 NOT NULL,
    max_order           INTEGER NOT NULL,
    product_image       VARCHAR2(255),
    allergy             VARCHAR2(255),
    product_type        VARCHAR2(10) DEFAULT 'FRESH' NOT NULL 
                        CHECK (product_type IN ('FRESH','PACKAGED')),
    shop_ID             INTEGER NOT NULL,
    category_ID         INTEGER NOT NULL,
    discount_ID         INTEGER,

    CONSTRAINT fk_prod_shop 
        FOREIGN KEY (shop_ID) REFERENCES SHOP(shop_ID),

    CONSTRAINT fk_prod_cat 
        FOREIGN KEY (category_ID) REFERENCES PRODUCT_CATEGORY(category_ID),

    CONSTRAINT fk_prod_discount 
        FOREIGN KEY (discount_ID) REFERENCES DISCOUNT(discount_ID)
);

-- =========================
-- BASKET
-- =========================
CREATE TABLE BASKET (
    basket_ID    INTEGER PRIMARY KEY,
    created_date DATE DEFAULT SYSDATE,
    last_updated DATE,
    user_ID      INTEGER NOT NULL,

    CONSTRAINT fk_basket_user 
        FOREIGN KEY (user_ID) REFERENCES USER_ACCOUNT(user_ID)
);

-- =========================
-- BASKET_ITEM
-- =========================
CREATE TABLE BASKET_ITEM (
    basket_ID  INTEGER NOT NULL,
    product_ID  INTEGER NOT NULL,
    quantity   INTEGER NOT NULL CHECK (quantity > 0),

    CONSTRAINT fk_bi_basket 
        FOREIGN KEY (basket_ID) REFERENCES BASKET(basket_ID),

    CONSTRAINT fk_bi_product 
        FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID)
);



-- =========================
-- ORDERS
-- =========================
DROP TABLE ORDERS CASCADE CONSTRAINTS;
CREATE TABLE ORDERS (
    order_ID     INTEGER PRIMARY KEY,
    order_date   DATE DEFAULT SYSDATE,
    order_status VARCHAR2(20) DEFAULT 'PENDING' 
                 CHECK (order_status IN ('PENDING','CONFIRMED','COLLECTED','CANCELLED')),
    total        NUMBER(10,2),
    user_ID      INTEGER NOT NULL,
    slot_ID      INTEGER NOT NULL,
    basket_ID    INTEGER,

    CONSTRAINT fk_order_user 
        FOREIGN KEY (user_ID) REFERENCES USER_ACCOUNT(user_ID),

    CONSTRAINT fk_order_slot 
        FOREIGN KEY (slot_ID) REFERENCES COLLECTION_SLOT(slot_id),

    CONSTRAINT fk_order_basket 
        FOREIGN KEY (basket_ID) REFERENCES BASKET(basket_ID)
);

-- =========================
-- ORDER_ITEM
-- =========================

DROP TABLE ORDER_ITEM CASCADE CONSTRAINTS;
CREATE TABLE ORDER_ITEM (
    order_ID       INTEGER NOT NULL,
    product_ID     INTEGER NOT NULL,
    quantity       INTEGER NOT NULL CHECK (quantity > 0),
    purchase_price NUMBER(10,2) NOT NULL,
    shop_ID        INTEGER NOT NULL,

    CONSTRAINT fk_oi_order 
        FOREIGN KEY (order_ID) REFERENCES ORDERS(order_ID),

    CONSTRAINT fk_oi_product 
        FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID),

    CONSTRAINT fk_oi_shop 
        FOREIGN KEY (shop_ID) REFERENCES SHOP(shop_ID)
);

-- =========================
-- PAYMENT
-- =========================
CREATE TABLE PAYMENT (
    payment_ID     INTEGER PRIMARY KEY,
    amount_paid    NUMBER(10,2) NOT NULL CHECK (amount_paid > 0),
    payment_date   DATE DEFAULT SYSDATE,
    payment_status VARCHAR2(20) NOT NULL 
                   CHECK (payment_status IN ('SUCCESS','FAILED','REFUNDED')),
    payment_method VARCHAR2(20) NOT NULL 
                   CHECK (payment_method IN ('PAYPAL','STRIPE')),
    order_ID       INTEGER NOT NULL UNIQUE,

    CONSTRAINT fk_payment_order 
        FOREIGN KEY (order_ID) REFERENCES ORDERS(order_ID)
);



-- =========================
-- REVIEW
-- =========================
CREATE TABLE REVIEW (
    review_ID   INTEGER PRIMARY KEY,
    rating      NUMBER(1) NOT NULL CHECK (rating BETWEEN 1 AND 5),
    review_date DATE DEFAULT SYSDATE,
    user_ID     INTEGER NOT NULL,
    product_ID  INTEGER NOT NULL,

    CONSTRAINT fk_review_user 
        FOREIGN KEY (user_ID) REFERENCES USER_ACCOUNT(user_ID),

    CONSTRAINT fk_review_product 
        FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID)
);

ALTER TABLE REVIEW 
ADD review_description CLOB NULL;

-- =========================
-- WISHLIST
-- =========================
CREATE TABLE WISHLIST (
    wishlist_ID INTEGER PRIMARY KEY,
    create_date DATE DEFAULT SYSDATE,
    user_ID     INTEGER NOT NULL UNIQUE,

    CONSTRAINT fk_wishlist_user 
        FOREIGN KEY (user_ID) REFERENCES USER_ACCOUNT(user_ID)
);

-- =========================
-- WISHLIST_ITEM
-- =========================
CREATE TABLE WISHLIST_ITEM (
    wishlist_item_ID INTEGER PRIMARY KEY,
    wishlist_ID      INTEGER NOT NULL,
    product_ID       INTEGER NOT NULL,

    CONSTRAINT fk_wi_wishlist 
        FOREIGN KEY (wishlist_ID) REFERENCES WISHLIST(wishlist_ID),

    CONSTRAINT fk_wi_product 
        FOREIGN KEY (product_ID) REFERENCES PRODUCT(product_ID)
);



-- ==================================
-- SEQUENCE AND TRIGGER FOR UNIQUE ID.
-- ==================================

-- USER_ACCOUNT

CREATE SEQUENCE user_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER user_trigger
BEFORE INSERT ON USER_ACCOUNT
FOR EACH ROW
BEGIN
    IF :NEW.user_ID IS NULL THEN
        :NEW.user_ID := user_seq.NEXTVAL;
    END IF;
END;
/

-- SHOP

CREATE SEQUENCE shop_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER shop_trigger
BEFORE INSERT ON SHOP
FOR EACH ROW
BEGIN
    IF :NEW.shop_ID IS NULL THEN
        :NEW.shop_ID := shop_seq.NEXTVAL;
    END IF;
END;
/

-- PRODUCT

DROP SEQUENCE product_seq;
DROP TRIGGER product_trigger;
CREATE SEQUENCE product_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER product_trigger
BEFORE INSERT ON PRODUCT
FOR EACH ROW
BEGIN
    IF :NEW.product_ID IS NULL THEN
        :NEW.product_ID := product_seq.NEXTVAL;
    END IF;
END;
/

-- DISCOUNT

CREATE SEQUENCE discount_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER discount_trigger
BEFORE INSERT ON DISCOUNT
FOR EACH ROW
BEGIN
    IF :NEW.discount_ID IS NULL THEN
        :NEW.discount_ID := discount_seq.NEXTVAL;
    END IF;
END;
/

-- COLLECTION_SLOT

CREATE SEQUENCE slot_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER slot_trigger
BEFORE INSERT ON COLLECTION_SLOT
FOR EACH ROW
BEGIN
    IF :NEW.slot_id IS NULL THEN
        :NEW.slot_id := slot_seq.NEXTVAL;
    END IF;
END;
/

-- PRODUCT_CATEGORY

CREATE SEQUENCE category_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER category_trigger
BEFORE INSERT ON PRODUCT_CATEGORY
FOR EACH ROW
BEGIN
    IF :NEW.category_ID IS NULL THEN
        :NEW.category_ID := category_seq.NEXTVAL;
    END IF;
END;
/


-- WISHLIST

CREATE SEQUENCE wishlist_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER wishlist_trigger
BEFORE INSERT ON WISHLIST
FOR EACH ROW
BEGIN
    IF :NEW.wishlist_ID IS NULL THEN
        :NEW.wishlist_ID := wishlist_seq.NEXTVAL;
    END IF;
END;
/

-- WISHLIST_ITEM

CREATE SEQUENCE wishlist_item_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER wishlist_item_trigger
BEFORE INSERT ON WISHLIST_ITEM
FOR EACH ROW
BEGIN
    IF :NEW.wishlist_item_ID IS NULL THEN
        :NEW.wishlist_item_ID := wishlist_item_seq.NEXTVAL;
    END IF;
END;
/

-- REVIEW

CREATE SEQUENCE review_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER review_trigger
BEFORE INSERT ON REVIEW
FOR EACH ROW
BEGIN
    IF :NEW.review_ID IS NULL THEN
        :NEW.review_ID := review_seq.NEXTVAL;
    END IF;
END;
/

-- PAYMENT

CREATE SEQUENCE payment_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER payment_trigger
BEFORE INSERT ON PAYMENT
FOR EACH ROW
BEGIN
    IF :NEW.payment_ID IS NULL THEN
        :NEW.payment_ID := payment_seq.NEXTVAL;
    END IF;
END;
/

-- BASKET

CREATE SEQUENCE basket_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER basket_trigger
BEFORE INSERT ON BASKET
FOR EACH ROW
BEGIN
    IF :NEW.basket_ID IS NULL THEN
        :NEW.basket_ID := basket_seq.NEXTVAL;
    END IF;
END;
/

-- ORDER

DROP  SEQUENCE order_seq;
DROP TRIGGER order_trigger;
CREATE SEQUENCE order_seq START WITH 1 INCREMENT BY 1 NOCACHE NOCYCLE;

CREATE OR REPLACE TRIGGER order_trigger
BEFORE INSERT ON ORDERS
FOR EACH ROW
BEGIN
    IF :NEW.order_ID IS NULL THEN
        :NEW.order_ID := order_seq.NEXTVAL;
    END IF;
END;
/





-- ================
-- INSERTING VALUES 
-- ================

--USER_ACCOUNT
--5 TRADERS
INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('James','Morrison',46, DATE '1978-06-14','07711223344','james@thebutcher.co.uk','TRADER','jmorrison','hashed_pw_1');

INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Sarah','Greenway',38,DATE '1986-03-22','07722334455','sarah@greengrocers.co.uk','TRADER','sgreenway','hashed_pw_2');

INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Pete','Fisher',52,DATE '1972-09-08','07733445566','pete@fishmonger.co.uk','TRADER','pfisher','hashed_pw_3');

INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Anne','Baker',44,DATE '1980-11-30','07744556677','anne@huddershub-bakery.co.uk','TRADER','abaker','hashed_pw_4');

INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Marco','DelVecchio',50,DATE '1974-07-19','07755667788','marco@deli.co.uk','TRADER','mdelvecchio','hashed_pw_5');

-- 1 Admin
INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Lisa','Admin',35,DATE '1989-01-01','07766778899','admin@huddershubmarket.co.uk','ADMIN','ladmin','hashed_pw_6');

-- 3 Customers
INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('John','Smith',34,DATE '1990-04-15','07700111222','john.smith@email.com','CUSTOMER','jsmith','hashed_pw_7');
INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Emily','Jones',28,DATE '1996-08-20','07700222333','emily.jones@email.com','CUSTOMER','ejones','hashed_pw_8');
INSERT INTO USER_ACCOUNT (first_name,last_name,age,DOB,phonenumber,email,user_role,user_name,password)
VALUES ('Tom','Davies',41,DATE '1983-12-05','07700333444','tom.davies@email.com','CUSTOMER','tdavies','hashed_pw_9');



--SHOP

INSERT INTO SHOP (shop_name,shop_type,shop_location,shop_discription,user_ID)
VALUES ('The Butcher','Meat & Poultry','8 Market Place, Cleckhuddersfax HD2 1AB','Premium meats from Yorkshire farms. Est. 1987.',1);

INSERT INTO SHOP (shop_name,shop_type,shop_location,shop_discription,user_ID)
VALUES ('Greengrocer','Fruit & Vegetables','14 High Street, Cleckhuddersfax HD2 1AC','Fresh seasonal fruit and vegetables from local farms.',2);

INSERT INTO SHOP (shop_name,shop_type,shop_location,shop_discription,user_ID)
VALUES ('The Fishmonger','Fish & Seafood','3 Riverside Lane, Cleckhuddersfax HD2 1AD','Freshly caught fish and seafood delivered daily.',3);

INSERT INTO SHOP (shop_name,shop_type,shop_location,shop_discription,user_ID)
VALUES ('The Bakery','Bakery & Pastry','22 Church Street, Cleckhuddersfax HD2 1AE','Artisan breads and pastries baked fresh each morning.',4);

INSERT INTO SHOP (shop_name,shop_type,shop_location,shop_discription,user_ID)
VALUES ('Deli Marco','Delicatessen','5 Old Square, Cleckhuddersfax HD2 1AF','Fine cheeses, cured meats and continental deli goods.',5);


-- COLLECTION SLOT 

-- Wednesday slots (shop_ID = 1 — collection point at The Butcher)
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('WED',DATE '2025-03-19','10:00-13:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('WED',DATE '2025-03-19','13:00-16:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('WED',DATE '2025-03-19','16:00-19:00',20,1);

-- Thursday slots
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('THU',DATE '2025-03-20','10:00-13:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('THU',DATE '2025-03-20','13:00-16:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('THU',DATE '2025-03-20','16:00-19:00',20,1);

-- Friday slots
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('FRI',DATE '2025-03-21','10:00-13:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('FRI',DATE '2025-03-21','13:00-16:00',20,1);
INSERT INTO COLLECTION_SLOT (slot_day,slot_date,slot_time,max_orders,shop_ID)
VALUES ('FRI',DATE '2025-03-21','16:00-19:00',20,1);


-- PRODUCT CATEGORY

INSERT INTO PRODUCT_CATEGORY (category_name,category_description)
VALUES ('Meat & Poultry','Fresh and frozen meats including beef, pork, chicken and lamb.');

INSERT INTO PRODUCT_CATEGORY (category_name,category_description)
VALUES ('Fish & Seafood','Fresh daily catch including salmon, cod, haddock and shellfish.');

INSERT INTO PRODUCT_CATEGORY (category_name,category_description)
VALUES ('Fruit & Vegetables','Seasonal fresh produce sourced from local Yorkshire farms.');

INSERT INTO PRODUCT_CATEGORY (category_name,category_description)
VALUES ('Bakery & Pastry','Freshly baked breads, pastries, cakes and confectionery.');

INSERT INTO PRODUCT_CATEGORY (category_name,category_description)
VALUES ('Deli & Cheese','Fine cheeses, cured meats, olives and continental deli products.');


-- PRODUCTS

-- Butcher products (shop_ID=1, category_ID=1)
INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Prime Sirloin Steak','Yorkshire dry-aged 28-day sirloin. Exceptional flavour.',
8.50,'250g portion',30,1,6,'sirloin.jpg',NULL,'FRESH',1,1);

INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Free Range Whole Chicken','Yorkshire free-range corn-fed chicken. Whole bird.',
9.80,'Whole ~1.5kg',20,1,3,'chicken.jpg',NULL,'FRESH',1,1);

-- Greengrocer products (shop_ID=2, category_ID=3)
INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Organic Broccoli','Fresh organic broccoli from Holmfirth farm.',
1.20,'Per head ~500g',50,1,10,'broccoli.jpg',NULL,'FRESH',2,3);

INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Mixed Salad Leaves','Baby leaf salad mix, freshly harvested.',
1.80,'150g bag',40,1,10,'salad.jpg',NULL,'FRESH',2,3);

-- Fishmonger products (shop_ID=3, category_ID=2)
INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID) 
VALUES ('Fresh Salmon Fillet','Atlantic salmon. Skinless, boneless fillets.',6.90,'2 fillets ~300g',25,1,4,'salmon.jpg','Fish','FRESH',3,2);

INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)
VALUES ('Smoked Haddock','Traditionally smoked golden haddock fillet.',
4.50,'1 fillet ~200g',20,1,4,'haddock.jpg','Fish','FRESH',3,2);

-- Bakery products (shop_ID=4, category_ID=4)
INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)
VALUES ('Sourdough Loaf','48-hour fermented sourdough. Crispy crust, soft interior.',
3.50,'1 large loaf ~800g',30,1,6,'sourdough.jpg','Gluten','FRESH',4,4);

INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)
VALUES ('Butter Croissants','Classic French-style croissants baked fresh daily.',
2.80,'Pack of 4',25,1,4,'croissants.jpg','Gluten,Dairy,Eggs','FRESH',4,4);

-- Deli products (shop_ID=5, category_ID=5)
INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Mature Cheddar','18-month Yorkshire cheddar. Rich and crumbly.',
4.20,'200g block',20,1,4,'cheddar.jpg','Dairy','PACKAGED',5,5);

INSERT INTO PRODUCT (product_name,product_description,item_price,quantity_per_item,stock,
min_order,max_order,product_image,allergy,product_type,shop_ID,category_ID)VALUES ('Prosciutto di Parma','Imported Italian dry-cured ham, thinly sliced.',
5.50,'100g pack',15,1,3,'prosciutto.jpg',NULL,'PACKAGED',5,5);



-- BASKET

INSERT INTO BASKET (created_date,last_updated,user_ID)
VALUES (DATE '2025-03-18',DATE '2025-03-18',7);
INSERT INTO BASKET (created_date,last_updated,user_ID)
VALUES (DATE '2025-03-18',DATE '2025-03-18',8);
INSERT INTO BASKET (created_date,last_updated,user_ID)
VALUES (DATE '2025-03-17',DATE '2025-03-17',9);

-- BASKET ITEM

-- Emily's basket (basket_ID=1)
INSERT INTO BASKET_ITEM (basket_ID,product_ID,quantity) VALUES (1,1,2); -- 2x Sirloin
INSERT INTO BASKET_ITEM (basket_ID,product_ID,quantity) VALUES (1,7,1); -- 1x Sourdough--
INSERT INTO BASKET_ITEM (basket_ID,product_ID,quantity) VALUES (1,3,3); -- 3x Broccoli

-- John's basket (basket_ID=2)
INSERT INTO BASKET_ITEM (basket_ID,product_ID,quantity) VALUES (2,5,1); -- 1x Salmon
INSERT INTO BASKET_ITEM (basket_ID,product_ID,quantity) VALUES (2,9,1); -- 1x Cheddar



--ORDER 

-- John's order — Thu 20 Mar, 10-13 slot
INSERT INTO ORDERS (order_date, order_status, total, user_ID, slot_ID, basket_ID)
VALUES (DATE '2025-03-18', 'CONFIRMED', 27.50, 9, 4, 3);

-- Emily's order — Thu 20 Mar, 13-16 slot
INSERT INTO ORDERS (order_date, order_status, total, user_ID, slot_ID, basket_ID)
VALUES (DATE '2025-03-18', 'PENDING', 11.10, 7, 5, 1);

-- Tom's order — Wed 19 Mar, 16-19 slot (collected)
INSERT INTO ORDERS (order_date, order_status, total, user_ID, slot_ID, basket_ID)
VALUES (DATE '2025-03-16', 'COLLECTED', 14.70, 8, 3, 2);


-- ORDER ITEM


-- John's order items (order_ID=1)
INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (1,1,2,8.50,1); -- 2x Sirloin from The Butcher

INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (1,3,1,3.50,4); -- 1x Sourdough from The Bakery

INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (1,3,3,1.20,2); -- 3x Broccoli from Greengrocer

-- Emily's order items (order_ID=2)
INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (2,5,1,6.90,3); -- 1x Salmon from Fishmonger

INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (2,9,1,4.20,5); -- 1x Cheddar from Deli

-- Tom's order items (order_ID=3)
INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (3,6,1,4.50,3); -- 1x Haddock from Fishmonger

INSERT INTO ORDER_ITEM (order_ID,product_ID,quantity,purchase_price,shop_ID)
VALUES (3,8,2,2.80,4); -- 2x Croissants from Bakery


-- PAYMENT
-- John's payment (Order_ID= 1)
INSERT INTO PAYMENT (amount_paid,payment_date,payment_status,payment_method,order_ID)
VALUES (27.50,DATE '2025-03-18','SUCCESS','STRIPE',1);

-- Emily's payment (order_ID=2)
INSERT INTO PAYMENT (amount_paid,payment_date,payment_status,payment_method,order_ID)
VALUES (11.10,DATE '2025-03-18','SUCCESS','PAYPAL',2);

-- Tom's payment (order_ID=3)
INSERT INTO PAYMENT (amount_paid,payment_date,payment_status,payment_method,order_ID)
VALUES (14.70,DATE '2025-03-16','SUCCESS','STRIPE',3);

-- REVIEW

-- Reviews from Tom (collected order)
INSERT INTO REVIEW (rating,review_date,user_ID,product_ID,review_description)
VALUES (5,DATE '2025-03-21',8,6,'Fantastic smoked haddock — freshest I have ever had!');

INSERT INTO REVIEW (rating,review_date,user_ID,product_ID,review_description)
VALUES (4,DATE '2025-03-21',8,8,'Croissants were delicious, very buttery and flaky.');


-- Wishlists for John and Emily
INSERT INTO WISHLIST (create_date,user_ID) VALUES (DATE '2025-03-10',9);
INSERT INTO WISHLIST (create_date,user_ID) VALUES (DATE '2025-03-12',7);

-- Wishlist items
INSERT INTO WISHLIST_ITEM (wishlist_ID,product_ID) VALUES (1,2); -- John wants Chicken
INSERT INTO WISHLIST_ITEM (wishlist_ID,product_ID) VALUES (1,10); -- John wants Prosciutto
INSERT INTO WISHLIST_ITEM (wishlist_ID,product_ID) VALUES (2,7); -- Emily wants Sourdough
INSERT INTO WISHLIST_ITEM (wishlist_ID,product_ID) VALUES (2,5); -- Emily wants Salmon