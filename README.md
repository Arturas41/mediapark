Prerequistes:
1. Ubuntu 18.04+ 
2. Install Docker: (if its not already installed)

	undate packages:
	- $ sudo apt update

	let apt use packages over HTTPS:
	- $ sudo apt install apt-transport-https ca-certificates curl software-properties-common
	
	download GPG key for Docker repository to your system:
	- $ curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

	add Docker repository to APT sources:
	- $ sudo add-apt-repository "deb [arch=amd64] https://download.docker.com/linux/ubuntu bionic stable"

	update packages:
	- $ sudo apt update

	make sure you are about to install Docker repository instead of default Ubuntu:
	- $ apt-cache policy docker-ce

	install docker:
	- $ sudo apt install docker-ce

	make sure Docker is running:
	- $ sudo systemctl status docker

	add ur currently logged in user to the docker group:
	- $ sudo usermod -aG docker ${USER}

	reset updated group:
	- $ su - ${USER}
	
3. Install Docker Compose: (if its not already installed)

    download Docker Compose(check for current release https://github.com/docker/compose/releases):
    - $ sudo curl -L https://github.com/docker/compose/releases/download/1.27.4/docker-compose-`uname -s`-`uname -m` -o /usr/local/bin/docker-compose

    set permissions:
    - $ sudo chmod +x /usr/local/bin/docker-compose
    
4.  Install application:

    create folder for application files:
    - $ mkdir ~/mediapark-app
    
    navigate:
    - $ cd ~/mediapark-app
    
    clone Git repo:
    - $ git clone https://github.com/Arturas41/mediapark.git .
    
    change foler permissions to ur currently loged in user:
    - $ sudo chown -R $USER:$USER ~/mediapark-app
    
    start 3 containers defined in docker-compose.yml file, create volumes and network between containers
    - $ docker-compose up -d
    
    create MySql user defined in laravel .env file and give it permissions:
    - $ docker-compose exec db bash
    - root@???:/# mysql -u root -p (password is WLZPnCuwkWmlwRui)
    - mysql> CREATE USER 'mediapark_db_user'@'%' IDENTIFIED BY 'sBVIhJmICniACwua';
    - mysql> GRANT ALL PRIVILEGES ON mediapark_db_user.* TO 'mediapark'@'%' WITH GRANT OPTION;
    - mysql> FLUSH PRIVILEGES;
    - mysql> EXIT;
    - root@???:/# exit
    
    run artisan migrate:
    - $ docker-compose exec mediapark-app bin/console make:migration
    - $ docker-compose exec mediapark-app php bin/console doctrine:migrations:migrate
    - $ docker-compose exec mediapark-app php bin/console doctrine:fixtures:load
    - $ docker-compose exec mediapark-app php bin/console app:fetch-supported-countries

