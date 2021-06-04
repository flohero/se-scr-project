use product_rating;

insert into users (username, password)
values ('Florian', 'Test');
insert into users (username, password)
values ('Michael', 'Test2');

insert into categories (name)
values ('coffee');
insert into categories (name)
values ('coffee machines');
insert into categories (name)
values ('other');

insert into products (userId, categoryId, name, manufacturer, description)
values (1, 2, 'Lumero Portafilter Espresso Machine', 'WMF',
        'It takes not even a minute and the powerful thermoblock heating system of the WMF Lumero Espresso portafilter machine is ready to bring perfectly tempered espresso and other coffee specialities such as cappuccino, latte macchiato and cafe Americano fresh into the cup. With a power of 1400 watts and 15 bar pressure, it presses even the smallest residual aroma from the ground coffee - either for one or two cups of espresso or Doppio. Thanks to the excellently constructed sieves, a crema in barista quality is created. The integrated milk frothing nozzle allows you to turn the fresh espresso into a cappuccino with wonderfully creamy milk foam in seconds. The three dishwasher-safe strainer inserts can be used for 1 or 2 cups or even for pads. As good as espresso, the design with the housing made of high-quality matte Cromargan and as easy as it is comfortable to use');

insert into products (userId, categoryId, name, manufacturer, description)
values (1, 2, 'EC 685.M Filter Pressure Machine', 'DeLonghi',
        'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus ex neque, cursus ac ullamcorper non, mollis id turpis. Suspendisse maximus nulla et magna vehicula ornare. Fusce quis tortor eu leo hendrerit rhoncus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec facilisis orci porttitor lorem malesuada, nec lacinia magna dictum. Mauris elit diam, tempor id maximus sed, vestibulum nec mauris. Vestibulum pretium rhoncus semper. Ut est metus, laoreet et sollicitudin et, semper nec dolor. Fusce placerat suscipit lorem, quis ultricies erat sodales id.');

insert into products (userId, categoryId, name, manufacturer, description)
VALUES (2, 2, 'appliances SES875 Espresso Machine', ' Sage', ' Prepare a wonderful espresso - from the bean to the cup in less than a minute. The Barista Express grinds the beans immediately before the extraction of the espresso, and thanks to the replaceable filter and a choice of automatic or manual operation, you can prepare an authentic café quality coffee in no time at all.
The 4 key elements of the preparation of Third Wave coffee specialities at home. ');

insert into products (userId, categoryId, name, manufacturer, description)
VALUES (2, 2, 'BiancaProfessional Espresso Coffee Maker', 'Lelit', ' Only for expert baristas – with our Bianca PL162T espresso machine, we have not made any compromises: equipped with the E61 brewing unit, dual boiler technology and manual brewing pressure control via paddle. Bianca is designed for all barista experts to extract the best from any coffee
ESPRESSO AND CAPPUCCINO AS AT THE BAR - Thanks to the dual boiler technology and the ability to manually control the water flow, PL162T is the ideal solution for those who want a high level of coffee along with continuous steam distribution to prepare many cappuccinos, caffè latte, caffè mocha, caffè Americano, tea and herbal tea. By rotating the mechanical paddle attached to the brewing unit, the water flow in the brewing unit can be regulated and the brewing pressure can be optimally controlled at every stage of extraction.');

insert into products (userId, categoryId, name, manufacturer, description)
VALUES (2, 2, 'BiancaProfessional Espresso Coffee Maker', 'Lelit', ' Only for expert baristas – with our Bianca PL162T espresso machine, we have not made any compromises: equipped with the E61 brewing unit, dual boiler technology and manual brewing pressure control via paddle. Bianca is designed for all barista experts to extract the best from any coffee
ESPRESSO AND CAPPUCCINO AS AT THE BAR - Thanks to the dual boiler technology and the ability to manually control the water flow, PL162T is the ideal solution for those who want a high level of coffee along with continuous steam distribution to prepare many cappuccinos, caffè latte, caffè mocha, caffè Americano, tea and herbal tea. By rotating the mechanical paddle attached to the brewing unit, the water flow in the brewing unit can be regulated and the brewing pressure can be optimally controlled at every stage of extraction.');


insert into ratings (productId, userId, score, title, content)
VALUES (1, 1, 4, 'best coffee machine', 'I love this coffee machine, but I cant sleep anymore');

insert into ratings (productId, userId, score, title, content)
VALUES (1, 2, 1, 'Worst Coffee', 'I hate this machine, it tastes too bitter and its way too big');

commit;