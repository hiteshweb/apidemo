<?php 
        include('config.php');
        spl_autoload_register(function($class){
            include($class.'.php');
        });
        // save product to database from API
        $product = new product();
        $product->saveProduct(148172);
?>