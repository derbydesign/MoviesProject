# Movies API

A simple web application demonstrating knowledge of building/using APIs to create and manipulate database data.

## Getting Started

These instructions will get you a copy of the project up and running on your local machine.

### Installing

A step by step series of examples that tell you how to get a development env running

Clone Repository

```
Clone or download MoviesProject repository into the root folder
of your localhost server.

Project assumes server root dir is
the dir immediately preceeding 'MovieProjects' dir.
```

Set SERVER_ROOT Variable

```
in /MovieProjects/settings.php
edit define('SERVER_ROOT', 'http://localhost:8080') (line 5)
to match your local server ip
```

Set Database Variables

```
in /MovieProjects/api/config/db.php
edit variables starting at line 5
to match your local mysql database connection
```

Create and Seed Database

```
navigate to http://localhost:8080/MoviesProjects/install
(or whatever your server ip is)

This should create the movies_project db on your mysql server.

Navigate to the homepage of the app
by clicking the Start App link (/MoviesProject) after DB install
```

Then you should be good to go!

## Built With

* [PHP 7.1.30](http://www.php.net)
* [MYSQL](https://dev.mysql.com/)

## Authors

* **Zack Doyle** - *Initial work*
