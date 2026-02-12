<?php

require_once './zerhouni_omar_module_c/app/Core/Model.php'; 

class AdminController { 
    public function ListAdmins(){
        $model = new Model();
        $db = $model->getDb(); 
        $db->query("SELECT username, registred, last_login FROM admin"); 
        return $db->resultSet();
    }

    public function ListUsers(){
        $model = new Model();
        $db = $model->getDb();
        $db->query("SELECT username, registred, last_login FROM user_plateform");
        return $db->resultSet();
    }

    public function blockUser($username, $reason){ 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("UPDATE user_plateform SET blocked = 1, block_reason = :reason WHERE username = :username"); 
        return $db->execute([':reason' => $reason, ':username' => $username]); 
    }

    public function unblockUser($username){ 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("UPDATE user_plateform SET blocked = 0, block_reason = NULL WHERE username = :username"); 
        return $db->execute([':username' => $username]); 
    }

    public function gamesList(){
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("SELECT title, description, thumbnail, author, created_at FROM games"); 
        return $db->resultSet();
    }

    public function resetHighscores($gameSlug){ 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("DELETE FROM scores WHERE game_slug = :slug"); 
        return $db->execute([':slug' => $gameSlug]); 
    }

    public function deletePlayerScore($gameSlug, $username){ 
        $model = new Model(); 
        $db = $model->getDb(); 
        $db->query("DELETE FROM scores WHERE game_slug = :slug AND username = :username"); 
        return $db->execute([':slug' => $gameSlug, ':username' => $username]); 
    }

}
?>