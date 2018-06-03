drop schema if exists diploma;
create schema diploma;
use diploma;

#Пользователи
create table users (id int primary key auto_increment,
username varchar(64),
first_name varchar(64),
second_name varchar(64),
email varchar(64),
password_hash varchar(256),
auth_key varchar(256),
status int,
created_at long,
updated_at long)
engine = InnoDB;

#Поставщики
create table providers (id int primary key auto_increment,
org_name varchar(64),
email varchar(64),
phone long)
engine = InnoDB;

#Виды товаров
create table types (id int primary key auto_increment,
type varchar(32),
img_path varchar(64))
engine = InnoDB;

#Марки автомобилей
create table marks (id int primary key auto_increment,
mark varchar(16),
img_path varchar(64))
engine = InnoDB;

#Товары
create table products (id int primary key auto_increment,
code varchar(32),
name varchar(64),
cost float,
id_type int,
id_mark int,
id_provider int,
foreign key (id_type) references types (id),
foreign key (id_mark) references marks (id),
foreign key (id_provider) references providers (id))
engine = InnoDB;

#Корзина
create table cart (id int primary key auto_increment,
id_user int,
id_product int,
amount int,
foreign key (id_user) references users (id),
foreign key (id_product) references products (id))
engine = InnoDB;

#Заказы
create table orders (id int primary key auto_increment,
id_user int,
products varchar(2048),
cost float,
created_at long,
updated_at long,
status int,
foreign key (id_user) references users (id))
engine = InnoDB;

#Закупки
create table purchases (id int primary key auto_increment,
id_user int,
products varchar(2048),
providers varchar(2048),
cost float,
created_at long,
updated_at long,
foreign key (id_user) references users (id))
engine = InnoDB; 

insert into users (username, first_name, second_name, email, password_hash, auth_key, status, created_at, updated_at)
value ('admin', 'admin', 'admin', 'vovan19977@gmail.com', 'd033e22ae348aeb5660fc2140aec35850c4da997',
	'xRZSiba_yzHDXfJKX23OxvqAZhWAV2aV', 0, 1524234881, 1524234881),
('vovchai', 'Vladimir', 'Ryashentsev', 'vovan19977@mail.ru', '8cb2237d0679ca88db6464eac60da96345513964',
 'bDNYLQf-lKArYNIyDkwyoGLcY6sVeNgZ', 1, 1528009367, 1528009367);
    
insert into marks (mark, img_path) values ('BMW', '/images/bmw.png'), ('Mercedes', '/images/mercedes.png'),
('Ford', '/images/ford.png'), ('Chevrolet', '/images/chevrolet.png');
#('Toyota', null), ('Audi', null);

insert into types (type, img_path) values ('Engine', '/images/engine.png'), ('Transmission', '/images/transmission.png'),
('Brakes', '/images/brakes.png'), ('Suspension', '/images/suspension.png'), ('Car body', '/images/car_body.png'),
('Tyres', '/images/tyres.png'), ('Battery', '/images/battery.png');

insert into providers (org_name, email, phone) values ('Kayaba', 'kyb@company.com', 0999236574),
('NRF', 'nrfwebshop@hotmail.com', 0742947755),
('Krafftech', 'info@dev.krafftech.ru', 9612349345),
('Bosch', 'boshinfo@wartungsarbeiten.gn', 77742394);

insert into products (code, name, cost, id_type, id_mark, id_provider) values
('9358209607', 'BMW SuperEngine', 1500, 1, 1, 1),
('9358209606', 'BMW Eng83', 1300, 1, 1, 1),
('9321521322', 'M6X16-8.8-ZNS3', 600, 2, 1, 1),
('9321521453', 'M6X16-9.0-ZNS4', 650, 2, 1, 1),
('9235328571', 'M8X12', 420, 3, 1, 1),
('9235213332', '3G', 420, 3, 1, 1),
('9663345451', 'TYP 230K', 800, 4, 1, 1),
('9663345853', 'M27X1,5', 760, 4, 1, 1),
('9663345443', 'M28X1,5K', 780, 4, 1, 1),
#('9554628300', 'BMW 28 X4', 2000, 5, 1),
('74256648', 'M177 5.0 E2SL', 1950, 1, 2, 1),
('74256632', 'M177 5.0 D3S', 1700, 1, 2, 1),
('74256676', 'M177 5.0 D12SS', 1800, 1, 2, 1),
('75232441', 'W 4 A 040', 700, 2, 2, 1),
('75232445', 'W 28 B 012', 720, 2, 2, 1),
('78862312', 'M 12 Brakes', 500, 3, 2, 1),
('71234424', '25 SLIDING ROOF 2', 1000, 4, 2, 1),
('71234413', '25 SLIDING ROOF 3', 1200, 4, 2, 1),
('79992345', 'SHELL HYDROPNEUMATIC', 3400, 5, 2, 1),
('79992344', 'SHELL', 3000, 5, 2, 1),
('4495764987', '5.0L V8 32v DOHC EFI Mod', 1200, 1, 3, 2),
('4495764785', '2.3L TiVCT Turbo (23HD0D_C)', 1300, 1, 3, 2),
('4495764352', '6 Speed Auto 6R60/75/80', 1500, 1, 3, 2),
('4284517264', '7A508', 500, 2, 3, 2),
('4284517268', '7A510', 520, 2, 3, 2),
('4142875162', 'F26M Brakes', 400, 3, 3, 2),
('4142875174', 'F28N Brakes', 450, 3, 3, 2),
('4984314125', 'Ford Suspension', 800, 4, 3, 2),
('4777231242', 'Ford SHELL Deflector', 3000, 5, 3, 2),
('832414', 'ENGINE ASM-1.6L L4', 1500, 1, 4, 2),
('832461', 'TX69 CAMSHAFT', 1600, 1, 4, 2),
('855215', 'SA 152', 850, 2, 4, 2),
('854232', 'FF 142', 850, 2, 4, 2),
('863627', 'Chevrolet Brakes', 600, 3, 4, 2),
('899923', 'CH KK 132 S', 800, 4, 4, 2),
('899885', 'CH DS 12', 730, 4, 4, 2),
('888231', 'Chevrolet SH V15', 2000, 5, 4, 2),
('412394', 'Michelin16', 100, 6, null, 3),
('F5850', 'Yokohama', 80, 6, null, 3),
('PSR1290603', 'Bridgetstone', 100, 6, null, 4),
('789360', 'Michelin15', 90, 6, null, 4),
('528461', 'Dunlop', 80, 6, null, 3),
('1580816', 'Matador', 60, 6, null, 3),
('0 092 S40 240', 'Bosch', 200, 7, null, 4),
('560 408 054 313 2', 'Varta', 180, 7, null, 4),
('0 092 S40 210', 'Bosch', 210, 7, null, 3),
('560 408 054 315 3', 'Varta', 190, 7, null, 3);