<?php
     header("Access-Control-Allow_Origin: http://localhost/jwt_auth/");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Methods: POST");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
     include_once 'config/database.php';
     include_once 'objects/user.php';
 
     $database = new Database();
     $db = $database -> getConnection();
 
     $user = new User($db);

     $data = json_decode(file_get_contents("php://input"));
     $user->email = $data->email;
     $email_exists = $user->emailExists();

     if(!$email_exists){
         
     }
?>