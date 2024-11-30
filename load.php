<?php
    session_start();
    $config = require 'config.php';

    require 'classes/Connection.php';

    $db = Connection::connect($config['database']);

    require 'classes/QueryBuilder.php';
    require 'classes/User.php';
    require 'classes/Producer.php';
    require 'classes/Image.php';
    require 'classes/Model.php';
    require 'classes/Slider.php';

    $query = new QueryBuilder($db);
    $user = new User($db);
    $producer = new Producer($db);
    $image = new Image($db);
    $model = new Model($db);
    $slider = new Slider($db);

    
    function pagination($number){
        if(isset($_GET['page'])){
            $offset = 5 * $_GET['page'] - 5;
            $page = $_GET['page'];
            if($page == $number){
                $next = 0;
            }else{
                $next = $_GET['page']+1;
            }
            
        }else{
            $page = 1;
            $next = $page + 1;
            $offset = 0;
        }

        return array('next' => $next, 'offset' => $offset, 'page' => $page);
    }
