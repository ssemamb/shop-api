<?php
require_once 'controllers/BaseController.php';
require_once 'services/UsersService.php';
class UsersController extends BaseController
{
    protected $UsersService;
    public function __construct($UsersModel)
    {
        $this->UsersService = new UsersService($UsersModel);
    }

    public function store()
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['username']) || empty($data['email']) || empty($data['password']) || empty($data['security_question'])) {
                throw new Exception("Required fields are missing");
            }
            $role_id = $data['role_id'];
            $username = $data['username'];
            $email = $data['email'];
            $password = $data['password'];
            $token = $data['token'];
            $security_question = $data['security_question'];
            $security_answer = $data['security_answer'];
            $created_at = $data['created_at'];
            $updated_at = $data['updated_at'];

            $user = $this->UsersService->store_user($role_id, $username, $email, $password, $token, $security_question, $security_answer, $created_at, $updated_at);

            return $this->respond(['user' => $user, 'message' => 'user regesterd successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to regester user' . $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            $user = $this->UsersService->show();
            return $this->respond(['user' => $user]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to show all users' . $e->getMessage()]);
        }
    }
    public function put($user_id)
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['username']) || empty($input['email']) || empty($input['password'])) {
                throw new Exception("Required fields are missing");
            }
            $user = $this->UsersService->put($user_id, $input);
            return $this->respond(['user' => $user, 'message' => 'user updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to update  user' . $e->getMessage()]);
        }
    }
    public function destroy($user_id)
    {
        try {
            $user = $this->UsersService->destroy($user_id);
            return $this->respond(['user' => $user, 'message' => 'user deleted successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to delete  user' . $e->getMessage()]);
        }
    }
    public function search()
    {
        try {
            $query = isset($_GET['query']) ? trim($_GET['query']) : '';
            if (empty($query)) {
                return $this->badmessage();
            }
            $user = $this->UsersService->search($query);
            return $this->respond(['user' => $user]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to fetch  records' . $e->getMessage()]);
        }
    }
}
