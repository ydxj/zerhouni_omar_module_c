<?php

class GameController { 
    public function getAllGames() { 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("SELECT * FROM game"); 
        return $db->resultSet(); 
    }
} 

?>