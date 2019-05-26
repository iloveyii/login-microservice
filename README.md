Login / Register Micro service
===============================
This is a small Micro service application to Login / Register using Rest API, developed in PHP.

 GOAL
---------------
 * Writing a micro service exposing a REST API for a basic user login
 
 * Requirements:  
   Implementation must use PHP. You are free to use any framework for the task. Vanilla PHP is acceptable as well but ideally we would like to see usage of an established microframework.
 
 * Some sort of storage of your choice, give us clear instructions how to set it up for testing your code.
 
 * REST service that handles following endpoints: 
    * /login (email, password)
    * /register (email, name, password )
    * /getAuthorizedUser (fetch the authorized user)
 
 * Frameworks are allowed, but not required.
 If you use a PHP framework, please do not include the framework code. Write instructions allowing us to install the framework by ourselves.
 If you use Composer packages, don't include the vendor/ directory, we will run the install.
 This exercise is not meant to take more than a few hours
 
 * Keep in mind:
 Security in both storage and interaction with the service.
 Write reusable code where possible and warranted
 Code quality and elegance.
 
 DIRECTORY STRUCTURE
 -------------------
 
 ```
     config.php           contains all app configurations
     controllers/         contains controller (UserController)
     migrations/          contains database migrations
     models/              contains model classes (User)
     web/                 contains index.php entry point, i.e root web directory
 ```
 END POINTS
 ---------------
   * /login - POST - to login
   * /register - POST - to register a new user
   * /getAuthorizedUser - GET - get the authorized user 
   * /users - GET - get a list of all users registered 
 
 INSTALLATION
 ---------------
   * Clone the repository `git clone git@bitbucket.org:iloveyii/challenge.git`.
   * Run composer install `composer install`.
   * If you want to use MySQL then create a database at your MySQL Server, and adjust the database credentials in the `config.php`, and also rename db2 to db.
   * If you don't want to use MySQL database this app uses sqlite by default, the db file is database.sqlite.
   * Run migrations to create the database tables as `vendor/bin/yii migrate/up --appconfig=./config.php`.
   * Point your web server www directory or Create a virtual host using [vh](https://github.com/iloveyii/vh) `vh new micrologin -p ~/<install_dir>/web`
   * Browse to [http://micrologin.loc/users](http://micrologin.loc/users) or better use Postman.
 
 PROBLEMS AND SOLUTIONS
 ---------------
 * If the database.sqlite database is read only then run the following commands (on linux).
 ```
    sudo chown -R :www-data .
    sudo chmod 777 database.sqlite
 ```
 Change user name as per your web server user name.