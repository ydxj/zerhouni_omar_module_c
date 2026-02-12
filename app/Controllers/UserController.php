<?php

class UserController {

    public function getUserByUsername($username) {
        $model = new Model();
        $db = $model->getDb();
        
        $db->query("SELECT username, registered_timestamp FROM user_plateform WHERE username = ?");
        $user = $db->execute([$username]);
        
        if (empty($user)) {
            http_response_code(404);
            return ;
        }
        
        $userData = $user[0];
        
        $db->query("SELECT DISTINCT g.slug, g.title, g.description 
                   FROM game g 
                   INNER JOIN user u ON g.author_id = u.id 
                   WHERE u.username = ?");
        $db->execute([$username]);
        $authoredGames = $db->resultSet();
        
        $db->query("SELECT g.slug, g.title, g.description, h.score, h.timestamp 
                   FROM highscore h
                   INNER JOIN game g ON h.game_id = g.id
                   INNER JOIN user u ON h.user_id = u.id
                   WHERE u.username = ?
                   ORDER BY g.id, h.score DESC");
        $db->execute([$username]);
        $allScores = $db->resultSet();
        
        $highscores = null;
        if (!empty($allScores)) {
            $maxScore = $allScores[0];
            foreach ($allScores as $score) {
                if ($score['score'] > $maxScore['score']) {
                    $maxScore = $score;
                }
            }
            $highscores = [
                'game' => [
                    'slug' => $maxScore['slug'],
                    'title' => $maxScore['title'],
                    'description' => $maxScore['description']
                ],
                'score' => $maxScore['score'],
                'timestamp' => $maxScore['timestamp']
            ];
        }
        
        http_response_code(200);
        return [
            'username' => $userData['username'],
            'registeredTimestamp' => $userData['registered_timestamp'],
            'authoredGames' => $authoredGames,
            'highscores' => $highscores
        ];
    }

}

?>