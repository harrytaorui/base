<?php
    require_once '../bootstrap.php';
    require_once '../models/ProductModel.php';

    $dbModel = new ProductModel();

    // Sanitize GET input 
    $_GET = filter_input_array(INPUT_GET, FILTER_SANITIZE_STRING);

    // Input user entered from search bar
    $input = $_GET['queryString'];

    //if empty query dont give any suggestions
    if ($input == '') {
        $jsonOutput = array(
            'topSuggestions'=> ''
        );
        echo json_encode($jsonOutput);
        return;
    }

    // Get recipes with title matching query
    $result = $dbModel->searchProductName($input);
    $elements = [];
    for ($i = 0; $i < count($result) && $i < 5; $i++) {
        $elements[$i] = $result[$i]->short_des;
    }

    $jsonOutput = array(
        'topSuggestions'=> $elements
    );

    echo json_encode($jsonOutput);
    return;
?>