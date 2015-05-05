<?php
    $config = Config::singleton();

    $config->set('controllersFolder', 'Controllers/');
    $config->set('modelsFolder', 'Models/');
    $config->set('xmlFolder', 'Models/xml/');
    $config->set('wsFolder', 'Models/services/');
    $config->set('viewsFolder', 'Views/');
    $config->set('templatesFolder', 'Templates/');    
    $config->set('Template', 'default.php');
    $config->set('BaseUrl', 'http://habeats.altiviaot.com/');
    $config->set('driver', 'mysql');
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'altiviao_alexadb');
    $config->set('dbuser', 'altiviao_alexa');
    $config->set('dbpass', '1UnVhToQMJc6');