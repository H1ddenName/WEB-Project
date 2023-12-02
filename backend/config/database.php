<?php 

class Database {
    //Database properties
    private $host = 'localhost';
    private $db_name = 'db_crud_api';
    private $username = 'root';
    private $password = 'root';
    private $connection = 'root';

    // Fungsi untuk membuat koneksi ke database
    public function connect()
    {
        try {
            $this->connection = new PDO('mysql:host='.$this->host.';dbname='.$this->db_name,
                                    $this->username,
                                    $this->password,
        );
        } catch (PDOException $e) {
            echo $e->getMessage();
        }

        return $this->connection;
    }
}
