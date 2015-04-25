<?php
    $config = Config::singleton();

    //Folders' Direction
    $config->set('controllersFolder', 'Controllers/');
    $config->set('modelsFolder', 'Models/');
    //$config->set('xmlFolder', 'Models/xml/');
    //$config->set('wsFolder', 'Models/services/');
    $config->set('viewsFolder', 'Views/');
    $config->set('templatesFolder', 'Templates/');    
    $config->set('Template', 'default.php');
    $config->set('BaseUrl', 'http://heabeats.altiviaot.com/api');

    //Data Base Configuration
    $config->set('driver', 'mysql');
    $config->set('dbhost', 'localhost');
    $config->set('dbname', 'pilotos');
    $config->set('dbuser', 'root');
    $config->set('dbpass', 'q6td9.9fmq3');