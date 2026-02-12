<?php

class GameController {

    public function getGameBySlug($slug) {
        $model = new Model();
        $db = $model->getDb();
        $db->query("SELECT * FROM game WHERE slug = ?");
        return $db->execute([$slug]);
    }

    public function updateGameBySlug($slug, $title, $description, $authorId) {
        $model = new Model();
        $db = $model->getDb();
        
        $db->query("SELECT author_id FROM game WHERE slug = ?");
        $game = $db->execute([$slug]);
        
        if ($game[0]['author_id'] != $authorId) {
            http_response_code(403);
            return [
                'status' => 'forbidden', 
                'message' => 'You are not the game author'
            ];
        }
        
        $db->query("UPDATE game SET title = ?, description = ? WHERE slug = ?");
        $responce = $db->execute([$title, $description, $slug]);
        if($responce) {
            http_response_code(200);
            return [
                'status' => 'success', 
                'message' => 'Game updated succesfully'
            ];
        }
        
        http_response_code(500);
        return [
            'status' => 'error', 
            'message' => 'An error occurred while updating the game'
        ];
    }

    public function getAllGames() { 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("SELECT * FROM game"); 
        return $db->resultSet(); 
    }
} 

?>