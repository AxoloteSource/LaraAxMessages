## Running Tests in Laravel

###  Before running the tests, make sure all project dependencies are installed:

- composer install
- pnpm/npm install

Create the databases in your database manager (if you don't have them) and adjust the database connection settings in your .env file:

    DB_CONNECTION=mysql
    DB_DATABASE=test_database_name
    DB_USERNAME=your_name
    DB_PASSWORD=your_password

Also your database test in the phpunit.xml file:

    <env name="DB_CONNECTION" value="mysql"/>
    <env name="DB_DATABASE" value="myDb_test"/>


### Generate application key, type in terminal:
 
- php artisan key:generate

Also run migrations and seeders if any.

### Run the tests 

Once the environment is set up, you can run the tests with the following command:

- php artisan test

### Other notes

- The tests must be in the folder **tests/**
- The TestCase.php file in the tests/ folder defines the base configuration for all tests.
