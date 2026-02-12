<?php

require_once './zerhouni_omar_module_c/app/Core/Model.php';

class AuthController{

    public function adminLogin($username, $password){ 
        if(empty($username) || empty($password)) {
            return false;
        }
        
        $model = new Model(); 
        $db = $model->getDb();
        $db->query("SELECT * FROM admin WHERE username = :username"); 
        $result = $db->execute([':username' => $username]);
        
        if($result && count($result) > 0) {
            $admin = $result[0];
            if($password === $admin['password']) {
                $db->query("UPDATE admin SET last_login = {now()} WHERE id = :id");
                $db->execute([':id' => $admin['id']]);
                return $admin;
            }
        }
        
        return false;
    }

    public function addAdmin($username, $password){ 
        if(empty($username) || empty($password)) {
            return false;
        }
        
        $model = new Model(); 
        $db = $model->getDb();
        $db->query("INSERT INTO admin (username, password,registred,last_login) VALUES (:username, :password,{now()},{now()})"); 
        return $db->execute([':username' => $username, ':password' => $password]);
    }

    public function login($username, $password){ 
        if(empty($username) || empty($password)) {
            http_response_code(401);
            return ['status' => 'invalid', 'message' => 'Wrong username or password'];
        }

        // validators
        if(strlen($username) < 4 || strlen($username) > 60) { 
            http_response_code(401);
            return ['status' => 'invalid', 'message' => 'Wrong username or password'];
        } 
        if(strlen($password) < 8) { 
            http_response_code(401);
            return ['status' => 'invalid', 'message' => 'Wrong username or password'];
        }
        
        $model = new Model(); 
        $db = $model->getDb();
        $db->query("SELECT * FROM user_plateform WHERE username = :username"); 
        $result = $db->execute([':username' => $username]);
        
        if($result && count($result) > 0) {
            $user = $result[0];
            if($password === $user['password']) {
                if($user['blocked']) { 
                    http_response_code(401);
                    return ['status' => 'invalid', 'message' => 'Wrong username or password'];
                }
                $db->query('UPDATE user_plateform SET last_login = {now()} WHERE id = :id');
                $db->execute([':id' => $user['id']]);
                http_response_code(200);
                return ['status' => 'success', 'token' => 'xxx'];
            }
        }
        
        http_response_code(401);
        return ['status' => 'invalid', 'message' => 'Wrong username or password'];
    }

    public function register($username, $password){ 
        if(empty($username) || empty($password)) {
            http_response_code(400);
            return false;
        }

        // validators
        if(strlen($username) < 4 || strlen($username) > 60) {
            http_response_code(400);
            return false; 
        }
        if(strlen($password) < 8) { 
            http_response_code(400);
            return false;
        }
        
        $model = new Model(); 
        $db = $model->getDb();
        $db->query("INSERT INTO user_plateform (username, password,registred,last_login) VALUES (:username, :password,{now()},{now()})"); 
        $result = $db->execute([':username' => $username, ':password' => $password]);
        
        if($result) {
            http_response_code(201);
            return [
                'status' => 'success',
                'token' => 'xxx'
            ];
        }
        
        http_response_code(500);
        return false;
    }

    public function logout(){ 
        // session_destroy(); 
    }

}
