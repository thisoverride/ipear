<?php 

    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    error_reporting(E_ALL);
    $term = isset($_POST['term']) ? trim($_POST['term']) : '15 rue des champs';

    $ch = curl_init("https://api-adresse.data.gouv.fr/search/?q=".urlencode($term));

    curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);

    $restmp = curl_exec($ch);

    if(curl_error($ch)) {
        $res= Array("error" => curl_error($ch));
        var_dump($res);
    
    }
    curl_close($ch);

    if(!empty($restmp)){
        $jsonres=json_decode($restmp,TRUE);
        $response=[];
        foreach ($jsonres['features'] as $elem) {
            $response[]=array('label' => $elem['properties']['label'],'address' => $elem['properties']['name'],'city' => $elem['properties']['city'],'postal_code' => $elem['properties']['postcode']);
        }
        echo json_encode($response);
    }
    exit;
?>