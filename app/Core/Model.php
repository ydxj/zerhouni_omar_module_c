<?php

require_once './zerhouni_omar_module_c/app/Core/Database.php';
class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = new Database();
        $this->db->connect();
    }
}
?>
