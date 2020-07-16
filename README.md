# ssv

[![version](https://img.shields.io/badge/version-1.0.22-yellow.svg)](https://semver.org)

A system for service prevent

## Getting Started

### Prerequisites

- PHP >= 7.2.5
- BCMath PHP Extension
- Ctype PHP Extension
- Fileinfo PHP extension
- JSON PHP Extension
- Mbstring PHP Extension
- OpenSSL PHP Extension
- PDO PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension

### Installing

Please check the official laravel installation guide for server requirements before you start. [Official Documentation](https://laravel.com/docs/5.4/installation#installation)

Clone the repository

    git clone https://github.com/walfrido-oliveira/ssv.git

Install all the dependencies using composer

    composer install

Install all the dependencies using npm

    npm run dev

Copy the example enf file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate

Run the database migrations (**Set the database connection in .env before migrating**)
    
    php artisan migrate

Start the local development server

    php artisan serve

You can now access the server at http://localhost:8000

## Authors

* **Walfrido Oliveira** - *Web Developer* 

## License

This project is licensed under the apache-2.0 License - see the [LICENSE.md](LICENSE.md) file for details


