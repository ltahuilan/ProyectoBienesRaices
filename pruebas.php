<?php 
   
    session_start();

    $err = [
        'err_mail' => '',
        'err_psw' => '',
        'psw_inc' => '',
        'usr_unr' => ''
    ];

    // echo '<pre>';
    // var_dump($err);
    // echo '</pre>';

    echo '<pre>';
    var_dump($_SESSION);
    $json = json_encode($_SESSION, JSON_UNESCAPED_UNICODE);
    var_dump($json);
    echo '</pre>';