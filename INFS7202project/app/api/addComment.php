<?php
    require_once '../bootstrap.php';
    require_once '../models/ProductModel.php';

    $dbModel = new ProductModel();

    // Sanitize GET input 
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

    // Get comment data
    $input = [
        'pid' => $_GET['pid'],
        'comment' => $_GET['comment'],
        'rating' => $_GET['rating']
    ];

    // Get result of comment
    $result = $dbModel->addNewComment($input);

    // If result was false, PDO exception occurred
    if($result == false) {
        echo json_encode(array('success' => false));
        return;
    }

    $element = '<div class="card mb-3">
                    <div class="card-body">
                        <div class="stars-outer"><div class="stars-inner" style="width: '.($result->rating * 20).'%;"></div></div>
                        <p class="card-text">'.$result->comment_description.'</p>
                        <h6 class="card-title">Author: '.$result->username.'</h6>
                        <small class="card-subtitle text-muted">Date: '.$result->date.'</small>
                    </div>
                </div>';

    $jsonOutput = array(
        'success'=> true,
        'content'=> $element
    );

    echo json_encode($jsonOutput);
?>