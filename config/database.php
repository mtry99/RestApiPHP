<?php

    class Database {
        //DB Params
        private $host = 'localhost';
        private $db_name = 'blogsql';
        private $username = 'root';
        private $password = '1234';
        
        //represents connection
        private $conn;

        //To connect to DB
        public function connect(){
            $this->conn = null;

            //connect through PDO

            try {

                //pass in all necessary connection requirements to PDO
                $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
                
                //get Query exceptions
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


            } catch (PDOException $exception) {      //PDO object created 
    
                echo 'Connection Failed:' . $exception->getMessage();   //PDO method getMessage to get exact error
            }


            return $this->conn;
        }
 
    }