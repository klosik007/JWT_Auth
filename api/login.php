<?php
     header("Access-Control-Allow_Origin: http://localhost/jwt_auth/");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Methods: POST");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
     include_once 'config/database.php';
     include_once 'objects/user.php';
     //JWT
     include_once 'config/core.php';
     include_once 'libs/php-jwt/src/BeforeValidException.php';
     include_once 'libs/php-jwt/src/ExpiredException.php';
     include_once 'libs/php-jwt/src/SignatureInvalidException.php';
     include_once 'libs/php-jwt/src/JWT.php';
     use \Firebase\JWT\JWT;
 
     $database = new Database();
     $db = $database -> getConnection();
 
     $user = new User($db);

     $data = json_decode(file_get_contents("php://input"));
     $user->email = $data->email;
     $email_exists = $user->emailExists();
     $hashed_password = password_hash($user->password, PASSWORD_DEFAULT);
     $pass_verified = password_verify($data->password, $hashed_password);

     if($email_exists && $pass_verified){ 
         $token = array(
            "iat" => $issued_at,
            "exp" => $expiration_time,
            "iss" => $issuer,
            "data" => array(
                 "id" => $user->id,
                 "firstname" => $user->firstname,
                 "lastname" => $user->lastname,
                 "email" => $user->email
            )   
         );

         http_response_code(200);

         //JWT generate
         $jwt = JWT::encode($token, $key);
         echo json_encode(array(
              "message" => "Succesful login",
              "JWT" => $jwt
         ));
     }else{
          http_response_code(401);

          echo json_encode(array(
               "message" => "Login failed"
          ));
     }

?>