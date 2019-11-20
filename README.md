# Movies API

A simple web application demonstrating knowledge of building/using APIs to create and manipulate database data.

### The Prompt
> Part I: Design and code a webapp application that can store the following information:
> At least three Movie production companies
> Each company produces 5-10 movies a year
> 8% of the movies fail financially
> Actors are paid a base amount for the movie plus rev share 
> Assume 3 core actors per movie. 
> 
> Make sure your UI displays the movie production companies, the actors, actor base, actor revenue, movie production companies revenue, losses for each movie and a form that allows a user to enter an actor and map to a movie, base pay for the movie and rev share. Actual $ numbers up to candidate 
> 
> Part II: 
> Assume a movie script starts of each speaking and/or moving event which we will call a “line” with a reference to an Actor > in the movie. The line can include more than one sentence and/or paragraphs. The line ends when a next reference to the same or different Actor’s speaking and/or moving event is made in the script.  Create a file that has a sample movie script for the Actors in your database based on this description.  Add to your webapp a display that also shows the following calculations against that file:
> a) the number of script “lines” and the number of spoken words in each movie script for each Actor, and,  
> b) the number of times the Actor's character will be mentioned in each movie script by other Actors (for instance, Actor plays "Mad Max", b) will be a count of how many times a reference to "Max" or "Mad Max" by another character is made in the movie script


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
navigate to http://localhost:8080/MoviesProject/install
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
