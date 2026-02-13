<?php

class GameController {

    public function getGameBySlug($slug) {
        $model = new Model();
        $db = $model->getDb();
        $db->query("SELECT * FROM game WHERE slug = ?");
        return json_encode($db->execute([$slug]));
    }

    public function updateGameBySlug($slug, $title, $description, $authorId) {
        $model = new Model();
        $db = $model->getDb();
        
        $db->query("SELECT author_id FROM game WHERE slug = ?");
        $game = $db->execute([$slug]);
        
        if ($game[0]['author_id'] != $authorId) {
            http_response_code(403);
            return json_encode([
                'status' => 'forbidden', 
                'message' => 'You are not the game author'
            ]);
        }
        
        $db->query("UPDATE game SET title = ?, description = ? WHERE slug = ?");
        $responce = $db->execute([$title, $description, $slug]);
        if($responce) {
            http_response_code(200);
            return json_encode([
                'status' => 'success', 
                'message' => 'Game updated succesfully'
            ]);
        }
        
        http_response_code(500);
        return json_encode([
            'status' => 'error', 
            'message' => 'An error occurred while updating the game'
        ]);
    }

    public function deleteGameBySlug($slug, $authorId) {
        $model = new Model();
        $db = $model->getDb();
        
        $db->query("SELECT author_id FROM game WHERE slug = ?");
        $game = $db->execute([$slug]);
        
        if (empty($game) || $game[0]['author_id'] != $authorId) {
            http_response_code(403);
            return json_encode([]);
        }

        $db->query("DELETE FROM game WHERE slug = ?");
        $response = $db->execute([$slug]);
        
        if ($response) {
            http_response_code(204);
            return json_encode([]);
        }
        
        http_response_code(500);
        return json_encode([]);
    }

    public function getGameScoresBySlug($slug) {
        $model = new Model();
        $db = $model->getDb();
        
        $db->query("SELECT u.username, MAX(s.score) as score, s.timestamp
            FROM game g
            JOIN score s ON g.id = s.game_id
            JOIN user u ON s.user_id = u.id
            WHERE g.slug = ?
            GROUP BY u.id
            ORDER BY score DESC
        ");
        
        $scores = $db->execute([$slug]);
        
        return json_encode([
            'scores' => $scores
        ]);
    }


    public function getAllGames() { 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("SELECT * FROM game"); 
        return json_encode($db->resultSet()); 
    }
} 

?>