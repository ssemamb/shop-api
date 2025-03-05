<?php

require_once 'models/UsersModel.php';

class AuthService
{
    protected $UsersModel;
    private $pdo;

    public function __construct($UsersModel, $pdo)
    {
        $this->UsersModel = $UsersModel;
        $this->pdo = $pdo;
    }

    public function login($username, $password)


    {
        //get user by username

        try {
            $user =  $this->UsersModel->getuserbyusername($username);
            //check if the user is there

            if (!$user) {
                throw new Exception("user was not found");
            }
            //check if password matches

            if (!password_verify($password, $user['password'])) {
                throw new Exception("invalid username or password");
            }

            //generate token

            $token = bin2hex(random_bytes(32));
            $this->UsersModel->store_token($user, $token);

            return $token;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function logout($user_id)
    {
        try {
            $this->UsersModel->clear_token($user_id);
        } catch (Exception $e) {
            echo json_encode(['Error in auth service', 'details' => $e->getMessage()]);
        }
    }

    public function setsecurityquestion($user_id, $security_question, $security_answer)
    {
        try {
            $hashedanswer = password_hash($security_answer, PASSWORD_BCRYPT);
            $this->UsersModel->updatesecurityquestion($user_id, $security_question, $hashedanswer);
        } catch (Exception $e) {
            echo json_encode(['Error in auth service', 'details' => $e->getMessage()]);
        }
    }

    public function resetpassword($username, $security_question, $security_answer, $newpassword)
    {
        try {
            $user =   $this->UsersModel->getuserbyusername($username);
            //check if the user exists 

            if (!$user) {
                throw new Exception("user is not found");
            }
            //check if security question matches the security question added

            if ($user['security_question'] != $security_question) {
                throw new Exception("security_question does not match the regesterd security_question");
            }
            //check if security_answer matches the security_answer added
            if (!password_verify($security_answer, $user['security_answer'])) {
                throw new Exception("security_answer does not match the regesterd security_answer");
            }
            $hashedpassword = password_hash($newpassword, PASSWORD_BCRYPT);
            $this->UsersModel->updatepassword($user['user_id'], $hashedpassword);
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
}
