<?php
ini_set('max_execution_time', 30000);
ini_set("default_socket_timeout", 30000);
 define('ARTICLE_URL',site_url() . '/article');
 // $prefix = $_SERVER['REQUEST_URI'];
 define('ROOTPATH', dirname(__FILE__));
 define('ROOTPATH', __DIR__);
 $prefixArray= explode('/',ROOTPATH);
 
 
 
ini_set("include_path", '/home/'.$prefixArray[2].'/php:' . ini_get("include_path") );


 ?>
