<?php
require './zerhouni_omar_module_c/app/Config/config.php';

class Database
{
    private $host = DB_HOST;
    private $db_name = DB_NAME;
    private $user = DB_USER;
    private $password = DB_PASS;
    private $dbh;
    private $stmt;

    public function connect()
    {
        $db = 'mysql:host='.$this->host.';dbname='.$this->db_name;

        try {
            $this->dbh = new PDO($db, $this->user, $this->password);
            return $this->dbh;
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
            return false;
        }
    }

    public function query($sql)
    {
        $this->stmt = $this->dbh->prepare($sql);
    }

    public function execute()
    {
        return $this->stmt->execute();
    }

    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll();
    }

    public function single()
    {
        $this->execute();
        return $this->stmt->fetch();
    }

    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
?>
