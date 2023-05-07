# 🚀 Company & Employee Management System

A simple company and employee management system with simple laravle auth built in vue.js

## Installation

At first, clone the repository in your computer

```bash
  git clone https://github.com/dipakmahatara/company-employee-mgmt.git
```

Go to the project directory

```bash
  cd company-employee-mgmt
```

Composer install

```bash
  composer install
```

Install dependencies

```bash
  npm install
```

Install my-project with npm

```bash
  npm install my-project
  cd my-project
```

## Environment Variables

To run this project, you will need to set the following environment variables to your .env file. One is for session and mail environment variables are used to send email notification

copy .env.example to .env and set the following variable

Set the database credentials in the following variables

`DB_CONNECTION=mysql`

`DB_HOST=127.0.0.1`

`DB_PORT=3306`

`DB_DATABASE=company`\_mgmt`

`DB_USERNAME=root`

`DB_PASSWORD=`

Set SESSION_DRIVER to cookie

`SESSION_DRIVER=cookie`

Set the mail configuration. You can use mailtrap for this

`MAIL_MAILER=`

`MAIL_HOST=`

`MAIL_PORT=`

`MAIL_USERNAME=`

`MAIL_PASSWORD=`

`MAIL_ENCRYPTION=`

`MAIL_FROM_ADDRESS=`

`MAIL_FROM_NAME=`

## Run Database Seeder

```bash
php artisan key:generate
php artisan migrate
```

## Run Locally

```bash
npm run build
npm run dev
```

Open new terminal and run the followin command

```bash
php artisan serve
```

Now, you can enter the address shown in the terminal. It usually [http://127.0.0.1:8000].
