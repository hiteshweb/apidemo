<?php 
        class database{
               private $host = DB_HOST;
               private $user = DB_USERSNAME;
               private $password = DB_PASSWORD;
               private $database = DB_NAME; 
               public $error;  
               public function __construct()  
               {  
               } 
               
               public function connect(){
                    $connection  = new mysqli(DB_HOST, DB_USERSNAME, DB_PASSWORD, DB_NAME);  
                    if( $connection->connect_error)  
                    {  
                         echo 'Database Connection Error ' .  $connection->connect_error;  
                    } else{
                         return $connection ;
                    }
               }
               public function executeQuery($table_name, $query)  
               {  
                    $con = $this->connect();
                    if($con->query($query))  
                    {  
                         return true;  
                    }  
                    else  
                    {  
                         return $con->error;  
                    }  
               }
       } 
?>