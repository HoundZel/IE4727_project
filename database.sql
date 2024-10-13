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

insert into users values
    (1, 'admin1', 81234567, 'admin@gmail.com', 'admin_123', '2024-10-13 20:35:02');

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

create table if not exists dish(
    name varchar(100),
    category varchar(100),
    course varchar(100)
);

insert into dish values
    ('Fried Bee Hoon', 'regular', 'main'),
    ('Yang Chow Fried Rice', 'regular', 'main'),
    ('Signature Mee goreng', 'regular','main'),
    ('Signature Curry Chicken', 'regular', 'meat'),
    ('Roasted Chicken Chop with BBQ Sauce', 'regular', 'meat'),
    ('Sweet and Sour Fish', 'regular', 'meat'),
    ('Chinese Cabbage', 'regular', 'vege'),
    ('Sambal Long Beans', 'regular', 'vege'),
    ('Signature Sambal Kangkong', 'regular', 'vege'),
    ('Cabbage Spring Roll','regular','sides'),
    ('Steamed Mini Chicken & Shrimp Siew Mai','regular','sides'),
    ('Golden Sotong Ball','regular','sides'),
    ('Chilled Honeydew Sago','regular','dessert'),
    ('Chilled Almond Beancurd with Longan','regular','dessert'),
    ('Chilled Cheng Tng','regular','dessert'),
    ('Refreshing Tropical Punch','regular','beverage'),
    ('Wintermelon Tea','regular','beverage'),
    ('Iced Lemon Tea','regular','beverage'),
    ('Fried Bee Hoon', 'mini', 'main'),
    ('Yang Chow Fried Rice', 'mini', 'main'),
    ('Signature Mee goreng', 'mini','main'),
    ('Signature Curry Chicken', 'mini', 'meat'),
    ('Roasted Chicken Chop with BBQ Sauce', 'mini', 'meat'),
    ('Sweet and Sour Fish', 'mini', 'meat'),
    ('Chinese Cabbage', 'mini', 'vege'),
    ('Sambal Long Beans', 'mini', 'vege'),
    ('Signature Sambal Kangkong', 'mini', 'vege'),
    ('Cabbage Spring Roll','mini','sides'),
    ('Steamed Mini Chicken & Shrimp Siew Mai','mini','sides'),
    ('Golden Sotong Ball','mini','sides'),
    ('Chilled Honeydew Sago','mini','dessert'),
    ('Chilled Almond Beancurd with Longan','mini','dessert'),
    ('Chilled Cheng Tng','mini','dessert'),
    ('Refreshing Tropical Punch','mini','beverage'),
    ('Wintermelon Tea','mini','beverage'),
    ('Iced Lemon Tea','mini','beverage'),
    ('Buttered Broccoli & Baby Carrot','bento','main'),
    ('Chilled Aloe Vera with Peach and Black Pearl','bento','main'),
    ('Creamy Honey Glazed Salmon Fillets','bento','main'),
    ('Golden Onion Rings','bento','main'),
    ('Homemade Garlic Bread','bento','main'),
    ('Italian Fusilli Pasta w Neapolitan Sauce','bento','main'),
    ('Japanese Potato Salad','hightea','salad'),
    ('International Fruit Salad','hightea','salad'),
    ('Thai Mango Salad','hightea','salad'),
    ('Pan-Fried Carrot Cake with Egg','hightea','main'),
    ('Yong Chow Fried Rice','hightea','main'),
    ('Mee Goreng','hightea','main'),
    ('Roti Prata w Curry Gravy','hightea','main'),
    ('Baked Mini Chicken Pie','hightea','pastry'),
    ('Lattice Mini Apple Pie','hightea','pastry'),
    ('New York Mini Cheese Cake','hightea','pastry'),
    ('Mini Oreo Cheese Cake','hightea','pastry'),
    ('Mini Chocolate Éclairs','hightea','pastry'),
    ('Breaded Butterfly Shrimp','hightea','sides'),
    ('Golden Prawn Ball','hightea','sides'),
    ('Potato Curry Puff','hightea','sides'),
    ('Golden Seafood Pocket','hightea','sides'),
    ('Buffalo Drumlets','hightea','sides'),
    ('Teriyaki Mini Drumlet','hightea','sides'),
    ('Steam Mini Lotus Pau','hightea','sides'),
    ('Chilled Honeydew Sago','hightea','dessert'),
    ('Chilled Almond Beancurd with Longan','hightea','dessert'),
    ('Chilled Cheng Tng','hightea','dessert'),
    ('Refreshing Tropical Punch','hightea','beverage'),
    ('Wintermelon Tea','hightea','beverage'),
    ('Iced Lemon Tea','hightea','beverage'),
    ('Coffee & Tea','hightea','beverage');
 
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