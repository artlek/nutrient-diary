# Nutrient Diray App

![symfony](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=Symfony&logoColor=white) 
![bootstrap](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)
![docker](https://img.shields.io/badge/Docker-2CA5E0?style=for-the-badge&logo=docker&logoColor=white) 

Welcome to Nutrient Diary - simple web app to calculate consumed nutrient.

With the application, you can easily control consumed nutrients. Nutrient Diary is useful for people who are on a diet. Every day shows you the quantity of consumed products. It also indicates you how many nutrients (e.g. carbohydrates or fat) you have consumed during the day. Moreover you can set the nutrient target to control how many nutrients you should still eat. 

## Features
1. Control consumed products value divided into nutrients.
2. Allow to set a daily nutrient target.
3. Compute how much nutrient are left to eat to achieve the target.

## How to try it
Is recommended use Docker to try this app.
1. Install Docker, run Docker Desktop.
2. Download this repository and unzip it.
3. Open app folder in terminal.
4. Build image in Docker by command: <code>docker-compose build</code> and then <code>docker-compose up -d</code>.
5. Open app container by command: <code>docker exec -it nutrient-diary-main_fpm_1 bash</code>. Name 'nutrient-diary-main_fpm_1' may be different according what Docker named the container. 
6. Install vendors: <code>composer install</code>.
7. Change folder owner <code>chown -R www-data:www-data /var/www</code>.
8. Now you can test the app - open localhost:10302 in your webbrowser.

Note that the database is filled with example product and nutrient data. You can use it by loging with <code>artur@email.com</code> and <code>NOPASS</code> password. 

You can also register new account and add nutrient and product manually with steps:
1. Add some nutrients.
Go to nutrients tab and add several nutrients (for example protein or fat). Daily target means how much nutrient you want to consumption per a day. If you dont know type 0. You can always change this value in nutrient details. 
2. Add several products.
When at least one nutrient is added you can add some products. Click the products tab and add several products. Nutrient content is a value describing how many grams of a nutrient contained in 100 grams of a product. 
3. Add product to diary
Finally you are able to add a product to the diary. Choose a day you are interested in. Default it's today. Choose a product from the list and type product quantity you are going to eat. Summary section shows you how much nutrients you have ate that day. It also displays daily target and value of the ingredient left to consumption.

## Screenshots
![obraz](https://github.com/artlek/nutrient-diary/assets/107640069/f8ac753c-7434-446c-9e18-2a53ee8e0b6c)

![obraz](https://github.com/artlek/nutrient-diary/assets/107640069/655fddad-4b00-4da4-9991-16a7a08c7086)

![obraz](https://github.com/artlek/nutrient-diary/assets/107640069/d067b8d8-8b41-4c62-95fb-aae9f1ddf6e0)

Created only for education purposes.
