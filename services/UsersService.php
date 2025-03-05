<?php
require_once 'models/UsersModel.php';
class UsersService
{
    protected $UsersModel;

    public function __construct($UsersModel)
    {
        $this->UsersModel = $UsersModel;
    }

    public function store_user($role_id, $username, $email, $password, $token, $security_question, $security_answer, $created_at, $updated_at)
    {
        try {
            $hashedpassword = password_hash($password, PASSWORD_BCRYPT);
            $hashedanswer = password_hash($security_answer, PASSWORD_BCRYPT);
            return $this->UsersModel->store($role_id, $username, $email, $token, $security_question, $hashedpassword, $hashedanswer, $created_at, $updated_at);
        } catch (Exception $e) {
            echo json_encode(['status' => "error in UserService store" . $e->getMessage()]);
        }
    }


    public function show()
    {

        try {
            return $this->UsersModel->show();
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in UserService Show ' . $e->getMessage()]);
        }
    }

    public function put($user_id, $data)
    {
        try {
            return $this->UsersModel->put($user_id, $data);
        } catch (Exception $e) {

            echo json_encode(['status' => 'Error in UserService Put' . $e->getMessage()]);
        }
    }

    public function destroy($user_id)
    {
        try {
            return $this->UsersModel->destroy($user_id);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in UserService Destroy' . $e->getMessage()]);
        }
    }
    public function search($query)
    {
        try {
            return $this->UsersModel->search($query);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in UserService search' . $e->getMessage()]);
        }
    }
}
