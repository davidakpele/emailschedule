<?php

function redirect($url=''){
	
   if (!defined('ROOT')) {
        define('ROOT', '/'); 
    }

    if (!empty($url)) {
        header('Location: ' . ROOT . $url);
        exit(); 
    }
}
