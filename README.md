## About Reservations

This is a reservation system web app built using TALL stack with Filament 3.

## How to install

Clone the repository

Install the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**) together with a seeder for roles and users

    php artisan migrate --seed

Install node dependencies

    npm i

Run dev vite server

    npm run dev

## Routes and available pages
- `/login` - Login page for classic user
- `/register` - Register page for classic user
- `/logout` - Wel.. logout.. (only POST)
- `/` - Homepage for logged user (list of reservations in this case)
- `/edit-account` - For editing user information
- `/create-reservation` - For creating new reservation

- `/admin` - Admin panel with it's own subtree of routes

## Built in roles
- `user` - Classic user with no special abilities
- `admin` - Has also access to /admin routes

## Before anything
After seeding db with users and roles, there are no tables or reservations. By default this user with credentials 

    admin@reservations.test
    password

is created with admin role. Log in with this account into `/admin` and add some tables. After you're done, come back to `/create-reservation` to create your reservation.

## Interactive table manipulation
There are 3 ways you can manipulate interactive tables. The styling might not be done and might require some rethinking to complete, but the tech is there 💅

- `First, in the /admin root page` - This is a generic overview of the current state. When a table is reserved for now(), it will be highlighted there with a couple options to choose from upon clicking the table
- `Second, in the /create-reservation page` - This is a selector of tables. Select a table or two, this will reflect on the available time options (Certain time options wont be available where there already is a reservation for that time)
- `Last, in the /admin/tables page` - This is a place where you can move the tables, create new ones, edit them, etc etc (with live polling btw)



