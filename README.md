## About This App


This is a small restaurant ordering application

The app is consumed by a vue spa powered by a laravel api.


This app uses three models User, Meal(Inventory), Orders.
There are 3 roles driver, customer, admin.


A user can choose the role to be on registration.

Only the admin has access to the meals route on the dashbaord

THe authentication endpoints are rate limited to 5 attempts in 30 minutes.

The meals are cached forever. The cache is forgotten when a meal is created, updated or deleted.



I am using same db for tests so you'll need to reset it before running the app.

I created a composer script fo that: composer db:app


