use product_rating;

insert into users (username, password) values ('Florian', 'Test');

insert into products (userId, name, manufacturer, description) values (1, 'COVID-19 Vaccine', 'Pfitzer/Biontech', 'Best Covid Vaccine, 5G ready');
insert into products (userId, name, manufacturer, description) values (1, 'COVID-19 Vaccine', 'Astra Zeneca', 'Guaranteed autism');
insert into products (userId, name, manufacturer, description) values (1, 'COVID-19 Vaccine', 'Johnson & Johnson', 'Birds die, when taking in the Vaccine');

commit;