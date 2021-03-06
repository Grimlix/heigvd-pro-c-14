© PointRéponse 2020

A web application which makes real-time polls.

This software was developed as semester project (PRO) at HEIG-VD,
academic year 2019/2020.

## Dependencies

This software has been tested with following dependencies:

* PHP 7.3.12
* MySql 8.0.18
* Apache 2.4.41
* Mercure 0.9.0 (https://github.com/dunglas/mercure)
* Symfony 4.4

## Build and install

1. Install Web services (i.e. php,mysql and apache). Can be achieved simply with Wamp

2. Set-up Symfony project (https://symfony.com/doc/4.4/setup.html#setting-up-an-existing-symfony-project)

3. Get Mercure (https://github.com/dunglas/mercure) and run it with following command  
   ./mercure --jwt-key='pro' --addr='localhost:3000' --allow-anonymous --cors-allowed-origins='*'
   
4. Set public folder of the symfony project as root URL of your website

## Run

1. Go to root folder of website you exposed it through http and a browser  

## Documentation

User manual: yourwebsiteURL/info
