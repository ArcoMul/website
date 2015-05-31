# Website

## Setup

### Windows

- Install vagrant and virtualbox
- Run `$ vagrant up`
- Go on with Ubuntu setup
- Website is available at 127.0.0.1:8080

### Ubuntu

- Install docker `$ wget -qO- https://get.docker.com/ | sh`
- Copy content of the `uploads` folder from somewhere to the new `uploads` folder `$ scp -r ./uploads sudo <user>@<ip>:~/website/wp-content`
- Copy database copy from somewhere to the `wp-content` folder `$ scp -r ./database.sql sudo <user>@<ip>:~/website/wp-content`
- Run the container `$ docker run --restart=always -p 80:80 -v $PWD/wp-content:/var/www/html/wp-content -d tutum/wordpress`
- Go in the docker container `$ docker exec -it <name of the container> bash`
- Import database using `$ mysql -u root -p wordpress < /var/www/html/wp-content/database.sql`
- Create an `.htaccess` in the wordpress root `$ touch /var/www/html/.htaccess`
- Make it writable `$ chmod -v 666 /var/www/html/.htaccess`
