<?php

class db {
    private $dbHost = 'localhost';
    private $dbUser = 'root';
    private $dbPass = '123456789';
    private $dbName = 'precioaluminio';

    public function connectBD() {
        try {
            $mysqlC = "mysql:host=$this->dbHost;dbname=$this->dbName";
            $dbConecction = new PDO( $mysqlC, $this->dbUser, $this->dbPass );
            $dbConecction->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
            return $dbConecction;
        } catch( PDOException $e ) {
            echo 'Error: ' . $e->getMessage();

        }
    }

}