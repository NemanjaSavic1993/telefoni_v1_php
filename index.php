<?php
    require 'load.php';

    $allModels = $model->getAll();

    $number = ceil(count($allModels) / 5);

    $result = pagination($number);

    $models = $model->paginate(5, $result['offset']);

    require_once 'views/index.html';