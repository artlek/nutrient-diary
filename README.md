# Nutrient Diray App
Welcome to Nutrient Diary - simple app to calculate consumed nutrient.

With the application, you can easily control consumed nutrients like fat, carbohydrates or protein. Nutrient Diary is useful for people who are on a diet. Every day shows you the quantity of consumed products. It also tell you how many nutrients (e.g. carbohydrates) you have consumed during the day. Moreover you can set the nutrient target to control how many nutrients you should still eat.
To start just login or register. 

## How to use it
Is recommended use Docker to try this app.
1. Install Docker, run Docker Desktop
2. Download this repository and unzip it
3. Open app folder in terminal
4. Build image in Docker by command: <code>docker-compose build</code> and then <code>docker-compose up -d</code>
5. Open app container by command: <code>docker exec -it nutrient-diary-main_fpm_1 bash</code>. Name 'nutrient-diary-main_fpm_1' may be different according what Docker named the container. 
6. Install vendors: <code>composer install</code>
7. Make database migrations: <code>php bin/console make:migration --no-interaction</code> and <code>php bin/console doctrine:migrations:migrate --no-interaction</code>
8. Fill nutrient table: <code>php bin/console dbal:run-sql "INSERT INTO nutrient (name, is_deleted) VALUES ('fat', 0), ('carbo', 0), ('protein', 0), ('kcal', 0);"</code>
9. Now you can test the app - open localhost:10302 in your webbrowser
