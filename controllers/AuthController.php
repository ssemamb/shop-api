<?php
require_once 'controllers/BaseController.php';
require_once 'services/AuthService.php';

class AuthController extends BaseController
{

    protected $AuthService;


    public function __construct($AuthService)
    {
        $this->AuthService = $AuthService;
    }
    public function login()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!$data) {
                throw new Exception("data required to login ");
            }

            $username = $data['username'];
            $password = $data['password'];

            if (!$username || !$password) {
                throw new Exception("username or password is miissing");
            }
            $data = $this->AuthService->login($username, $password);
            return $this->respond(['token' => $data, 'message' => 'logged in successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['Error' => 'Failed to login', 'details' => $e->getMessage()]);
        }
    }

    public function logout()
    {

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (!isset($data['user_id'])) {
                throw new Exception("user_id is required");
            }
            $user_id = $data['user_id'];
            $data = $this->AuthService->logout($user_id);
            return $this->respond(['data' => $data, 'message' => 'logged out successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['Error' => 'Unable to log out', 'details' => $e->getMessage()]);
        }
    }

    public function securityquestion()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $user_id = $data['user_id'];
            $security_question = $data['security_question'];
            $security_answer = $data['security_answer'];
            $hashedanswer = password_hash($security_answer, PASSWORD_BCRYPT);
            $data = $this->AuthService->setsecurityquestion($user_id, $security_question, $hashedanswer);
            return $this->respond(['data' => $data, 'message' => 'security question updated successfully']);
        } catch (Exception $e) {

            http_response_code(400);
            echo json_encode(['Error' => 'Unable to update security question', 'details' => $e->getMessage()]);
        }
    }

    public function forgotpassword()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $username = $data['username'];
            $security_question = $data['security_question'];
            $security_answer = $data['security_answer'];
            $newpassword = $data['newpassword'];
            $data = $this->AuthService->resetpassword($username, $security_question, $security_answer, $newpassword);
            return $this->respond(['data' => $data, 'message' => 'password reset successfully']);
        } catch (Exception $e) {
            http_response_code(400);
            echo json_encode(['Error' => 'Unable to reset password', 'details' => $e->getMessage()]);
        }
    }
}
