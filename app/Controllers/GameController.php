<?php

class GameController {

    public function getGameBySlug($slug) {
        $model = new Model();
        $db = $model->getDb();
        $db->query("SELECT * FROM game WHERE slug = ?");
        return $db->execute([$slug]);
    }

    public function getAllGames() { 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("SELECT * FROM game"); 
        return $db->resultSet(); 
    }
} 

?>