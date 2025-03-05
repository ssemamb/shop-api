<?php

require_once 'services/StockService.php';

class StockController extends BaseController
{

    protected $StockService;
    public function __construct($StockModel)
    {

        $this->StockService = new StockService($StockModel);
    }

    public function store($user_id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['name']) || empty($data['quantity']) || empty($data['stock_price'])) {
                throw new Exception("Required fields are missing");
            }

            $user_id = $data['user_id'];
            $name  = $data['name'];
            $quantity = $data['quantity'];
            $stock_price = $data['stock_price'];

            if (!$user_id) {
                echo json_encode(['user_id is required']);
            }
            $user = $this->StockService->store($user_id, $name, $quantity, $stock_price);
            return $this->respond(['stock' => $user, 'message' => 'stock recorded successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to record Stock', 'details' =>  $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            $stock = $this->StockService->show();
            echo json_encode(['stock' => $stock]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'failed to fetch Stock' . $e->getMessage()]);
        }
    }
    public function put($stock_id)
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['name']) || empty($input['quantity']) || empty($input['stock_price'])) {
                echo json_encode(['Error' => 'some fields are required']);
            }
            if (!$stock_id) {
                echo json_encode(['stock_id is required']);
            }
            $stock = $this->StockService->put($stock_id, $input);

            return $this->respond(['stock' => $stock, 'message' => 'Stock updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to stock' . $e->getMessage()]);
        }
    }
    public function destroy($stock_id)
    {

        try {
            if (!$stock_id) {
                throw new Exception("stock record was not found");
            }
            $stock = $this->StockService->destroy($stock_id);
            echo json_encode(['stock' => $stock, 'message' => 'Stock deleted successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to delete stock' . $e->getMessage()]);
        }
    }
    public function search($query)
    {

        try {
            $query = isset($_GET['query']) ? trim($_GET['query']) : '';
            if (empty($query)) {
                throw new Exception(" search field is empty");
            }
            $stock = $this->StockService->search($query);

            return $this->respond(['stock' => $stock]);
        } catch (Exception $e) {
            echo json_encode(["Error" => "Unable to search stock", 'details' => $e->getMessage()]);
        }
    }
}
