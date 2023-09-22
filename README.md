## Setup mysql database

Install in Ubuntu 18.04

    sudo apt install mysql-server
    sudo mysql_secure_installation

Set a root password to remember
Add the password in the Connexio.php file

Set root to a normal password (default is auth_socket)

    sudo mysql
    mysql> SELECT user,authentication_string,plugin,host FROM mysql.user;
    mysql> ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'password';
    mysql> FLUSH PRIVILEGES;
    mysql> exit
    systemctl restart mysql.service

Try to connect to verify the login

    mysql -u root -p

Now create the database and an extra necessary user

    mysql> CREATE DATABASE pinyator;
    mysql> USE pinyator;
    mysql> GRANT ALL PRIVILEGES ON *.* TO 'marrecs'@'localhost' IDENTIFIED BY 'password';
    mysql> FLUSH PRIVILEGES;
    mysql> exit

Copy de DB structure (change Connexio.php DB name)

    mysql -u root -p pinyator < Pinyator_BD.sql
    mysql> exit


## PHP server

Install php server

    sudo apt install php7.2-cli php7.2-mysql

Clone and run project

    git clone https://github.com/alfredocalosci/pinyator_CCM pinyator
    php -S 127.0.0.1:8000

## Open webpage

On:

    http://localhost:8000/utils/Index.html

## Local Setup on Mac
### Prerequisites
* Docker

### MySQL - Mariadb

1. CD into the /db folder and run `docker-compose up -d`  
You can access to the DB server like this:
`docker exec -it repo-db-1 mariadb --user testuser -pT3niente`
2. Replace Connexio.php line 3 with `$conn = mysqli_connect("localhost:6603", "testuser", "T3niente", "pinyator");`
3. CD into the repository's parent folder and run: `php -S 127.0.0.1:8000` 
4. Use admin/PorElBote! for login as admin.