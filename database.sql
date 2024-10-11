-- import this database @ localhost:8000/phpmyadmin/

create database if not exists professionals;
use professionals;

create table if not exists users(
    id int primary key auto_increment,
    username varchar(100),
    contact int(8),
    email varchar(100),
    password varchar(100),
    created_at timestamp default current_timestamp
);

create table if not exists menu(
    name varchar(100),
    imgname varchar(100),
    price decimal(5,2),
    category varchar(100)
);

insert into menu values
    ('Super Value', 'Super_Value',16.00, 'regular'),
    ('Local Delights', 'Local_Delights', 18.00, 'regular'),
    ('Japanese Special', 'japanese_Special', 20.00, 'regular'),
    ('Signature Spread', 'Signature_Spread', 24.00, 'regular'),
    ('Mini Buffet A', 'Mini_Buffet_A', 15.00, 'mini'),
    ('Mini Buffet B', 'Mini_Buffet_B', 17.00, 'mini'),
    ('Mini Buffet C', 'Mini_Buffet_C', 19.00, 'mini'),
    ('Mini Buffet D', 'Mini_Buffet_D', 21.00, 'mini'),
    ('Signature Mini Buffet', 'Signature_Mini_Buffet', 23.00, 'mini'),
    ('Vegan Bento Set', 'Vegan_Bento_Set', 16.00, 'bento'),
    ('Indian Bento Set', 'Indian_Bento_Set', 16.00, 'bento'),
    ('Signature Bento Set', 'Signature_Bento_Set', 16.00, 'bento'),
    ('High Tea Set', 'High_Tea_Set', 11.00,'hightea');

create table if not exists orders(
    id int primary key auto_increment,
    username varchar(100),
    itemname varchar(100),
    quantity int,
    total decimal(5,2),
    created_at timestamp default current_timestamp
);

create table if not exists feedback(
    id int primary key auto_increment,
    email varchar(100),
    topic varchar(100),
    feedback text,
    created_at timestamp default current_timestamp
);