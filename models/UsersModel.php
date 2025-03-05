<?php
require_once 'models/BaseModel.php';

class UsersModel extends BaseModel
{


    //regestering user

    public function store($role_id, $username, $email,  $token, $security_question, $hashedpassword, $hashedanswer, $created_at, $updated_at)
    {
        $sql = "INSERT INTO users(role_id,username,email,password,token,security_question,security_answer,created_at,updated_at)
        VALUES(:role_id,:username,:email,:password,:token,:security_question,:security_answer,:created_at,:updated_at)";
        return $this->execute($sql, [
            'role_id' => $role_id,
            'username' => $username,
            'email' => $email,
            'password' => $hashedpassword,
            'token' => $token,
            'security_question' => $security_question,
            'security_answer' => $hashedanswer,
            'created_at' => $created_at,
            'updated_at' => $updated_at


        ]);
    }


    //returning all users data
    public function show()
    {
        $sql = "SELECT * FROM users ";
        return $this->fetchall($sql);
    }

    //updating user
    public function put($user_id, $data)
    {
        $hashedpassword = password_hash($data['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET user_id =:user_id, username = :username,email = :email,password = :password WHERE user_id = :user_id";
        return $this->execute($sql, [
            'user_id' => $user_id,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => $hashedpassword
        ]);
    }

    //deleting user
    public function destroy($user_id)
    {
        $sql = "DELETE FROM users WHERE user_id = :user_id";
        return $this->execute($sql, ['user_id' => $user_id]);
    }

    //search user
    public function search($query)
    {
        $sql = "SELECT * FROM users WHERE username LIKE :username OR email LIKE :email";
        $params = [
            'username' => "%$query%",
            'email' => "%$query%"
        ];
        return $this->fetchall($sql, $params);
    }


    //get user by username
    public function getuserbyusername($username)
    {
        try {
            $sql = "SELECT * FROM users WHERE username = :username LIMIT 1";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute(['username' => $username]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$user) {
                throw new Exception("user was not regesterd");
            }
            return $user;
        } catch (Exception $e) {
            echo json_encode(['Error in usermodel', 'details' => $e->getMessage()]);
        }
    }

    //generate token for login
    public function store_token($user, $token)
    {
        try {
            $sql = "UPDATE users SET token = :token WHERE user_id =:user_id";
            return $this->execute($sql, [

                'token' => $token,
                'user_id' => $user['user_id']

            ]);
        } catch (Exception $e) {
            echo json_encode(['Error in storing token', 'details' => $e->getMessage()]);
        }
    }


    //delete token after logout
    public function clear_token($user_id)
    {
        $sql = "UPDATE users SET token   = NULL WHERE user_id = :user_id";
        return $this->execute($sql, ['user_id' => $user_id]);
    }


    //update password on forgrot password  action
    public function updatepassword($user_id, $hashedpassword)
    {
        $sql = "UPDATE users SET password = :password WHERE user_id = :user_id";
        return $this->execute($sql, [
            'password' => $hashedpassword,
            'user_id' => $user_id

        ]);
    }

    //update security_question on forgot password action
    public function updatesecurityquestion($user_id, $security_question, $hashedanswer)
    {
        $sql = "UPDATE users SET security_question = :security_question,security_answer = :security_answer WHERE user_id = :user_id";
        return $this->execute($sql, [
            'user_id' => $user_id,
            'security_question' => $security_question,
            'security_answer' => $hashedanswer
        ]);
    }
}
