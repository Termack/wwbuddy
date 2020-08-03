# WWBuddy
Little vulnerable website i made for [this tryhackme room](https://tryhackme.com/p/Termack) (It isn't public yet) but to post here i patched the vulnerabilities and changed the password of the users.

The room is supposed to be 2 guys making a website to talk with people all around the world.

I know the code isn't good and i'm using some bad practices, but the 3 main reasons are:
  1. In order to make the vulnerabilities for the room i wanted to think like someone who's not thinking too much about security.
  2. I don't like frontend, so i rushed it and copied some code here and there so i know it looks bad
  3. This was my first experience using php so there is more for me to learn
  
Okay, the code is not good but i made this repository because i dont have many things here in github (yet!).

## Setup in local machine

First change the <username> and <password> in config.php to match mysql in your machine.

    define('DB_USERNAME', '<username>');
    define('DB_PASSWORD', '<password>');

Then create a database called wwbuddy in your mysql server and execute these commands.

    $ git clone https://github.com/Termack/wwbuddy.git
    $ cd wwbuddy
    $ mysql -u <username> -p wwbuddy < wwbuddy.sql
    $ php -S localhost:8080
     
Now the server is runnning, go to [localhost:8080](http://localhost:8080/) and you can use it.

The password for the user WWBuddy is password321.
