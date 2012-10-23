Welcome to Blackbird
=========

Blackbird is a lightweight PHP MVC framework, origionally created with inspiration from Ruby on Rails back in 2006.

## Requirements
- As this framework is very slim and no guides is provided, its expected that you have decent knowledge of PHP.
- PHP 5.3
- MySQL (You can switch to another database if you want to)

## Getting started
In either your Apache virtual-host or in your .htaccess file, specify which environment to run:


    <VirtualHost *:80>

        ServerName blackbird
        DocumentRoot /path-to-blackbird/public

        SetEnv ENVIRONMENT development

        <Directory />
                Order allow,deny
                AllowOverride All
                Allow from all
        </Directory>

    </VirtualHost>


## Conventions

Blackbird expects a strict relationship between your controllers and your views. This is done to make it easier to setup new controllers and actions, rather than worrying about configuring it.

- A controller is declared with uppercase-first as such: **WelcomeController**
- An action is defined within the controller as a public mehtod with the name of the action.
- A view file is created in the folder /app/views/[controller]/[action].[format].php - /app/views/welcome/index.html.php


Example welcome controller

    <?php

    class WelcomeController extends ApplicationController {

        public function index() {
          
        }

    }

    ?>
