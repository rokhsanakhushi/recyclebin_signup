<?php

 class sign_up_model{
     private $conn;
     private $table = 'user_id';
     private $table1 = 'user_info';


     public function __construct($db){
         $this->conn = $db;
     }

     //get post
     public function xcute($query){

         $stmt = $this->conn->prepare($query);
         $stmt->execute();
         return $stmt;
     }

     private function insert_info($email){

        $query = "INSERT INTO "
                    .$this->table1." (email, address, description, phone_no, total_given_ad, profile_photo)"
                    ." VALUES ('$email', '', '', '', '0', '');";
        $stmt = $this->conn->prepare($query);

        if( $stmt->execute() ){
            return true;
        }else{
            return false;
        }

    }
     

     // Create Post
     public function signUp($email, $pass, $name)
     {
         $q = 'SELECT email FROM '
             .$this->table
             .' WHERE email= "'.$email.'" ';

         $stmt = $this->conn->prepare($q);
         $stmt->execute();
         if($stmt->rowCount()>0){return false;}


         $query =  'INSERT INTO '.$this->table.'(email, pass, name)
                    VALUES ("'.$email.'", "'.$pass.'", "'.$name.'")';

         // Prepare statement
         $stmt = $this->conn->prepare($query);

         if ($stmt->execute() && $this->insert_info($email)) {
             return true;
         }

         printf("Error: %s.\n", $stmt->error);
         return false;
     }
 }