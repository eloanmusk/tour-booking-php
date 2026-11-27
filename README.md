# Tour Booking

A web app for booking tour packages, written in PHP with MySQL.

There are two kinds of accounts. Travel agencies sign up as organizations and post tour packages with a cover image and a description written in Markdown. Travelers sign up as users, browse the packages, book the ones they want and cancel bookings they no longer need.

## Features

- Separate sign-up flows for travelers and for organizations
- Passwords stored with `password_hash` and checked with `password_verify`
- Organizations can add, list and delete their own packages and see who has booked them
- Package descriptions are written in Markdown and rendered with [Parsedown](https://github.com/erusev/parsedown)
- Travelers can browse all packages, open a detail page, book, see their bookings and cancel them
- Booking the same package twice is blocked

## Tech stack

- PHP with PDO
- MySQL
- HTML and CSS
- Composer, for Parsedown

## Running it locally

1. Install PHP, MySQL and [Composer](https://getcomposer.org). XAMPP or MAMP works too.
2. Create a MySQL database called `userDB` with `users`, `packages` and `bookings` tables.
3. Update the connection settings in `dbs/dbcon.php` if your MySQL user or password are different from the defaults.
4. Run `composer install`.
5. Serve the project folder with PHP and open `loginAndRegister/choose.php`:

   ```bash
   php -S localhost:8000
   ```

   Then go to http://localhost:8000/loginAndRegister/choose.php

## Project layout

```
loginAndRegister/   Account type choice, sign-up, login and logout
pages/              Packages, bookings and organization dashboard
dbs/                Database connection
files/              Images and sound effects used by the interface
destImages/         Images uploaded for packages
```
