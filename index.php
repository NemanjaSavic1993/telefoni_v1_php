<?php
    require 'load.php';

    $allModels = $model->getAll();

    $number = ceil(count($allModels) / 5);

    $result = pagination($number);

    $models = $model->paginate(5, $result['offset']);

    $sliders = $slider->getActiveSliders();

    if(isset($_POST['btnPretrazi'])){
        $models = $model->filter();
    }

    if(isset($_POST['btnSearch'])){
        $models = $model->search();
    }

    require_once 'views/index.html';