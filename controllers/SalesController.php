<?php

require_once 'services/SalesService.php';
class SalesController extends BaseController
{
    protected $SalesService;

    public function __construct($SalesModel)
    {
        $this->SalesService = new SalesService($SalesModel);
    }

    public function store()
    {
        try {
            $data  = json_decode(file_get_contents('php://input'), true);
            if (empty($data['stock_items_id']) || empty($data['user_id']) || empty($data['name']) || empty($data['quantity']) || empty($data['price'])) {
                throw new Exception("Required fields are missing");
            }
            $sales = $this->SalesService->store($data);
            return $this->respond(['sales' => $sales, 'message' => 'sale saved successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to  save sale' . $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            $sales = $this->SalesService->show();
            echo json_encode(['sales' => $sales]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to  fetch sales' . $e->getMessage()]);
        }
    }
    public function put($sales_id)
    {
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($data['stock_items_id']) || empty($data['user_id']) || empty($data['name']) || empty($data['quantity']) || empty($data['price'])) {
                throw new Exception("Required fields are missing");
            }
            $sales = $this->SalesService->put($sales_id, $data);
            return $this->respond(['sales' => $sales, ',message' => 'Sale updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to  update sale' . $e->getMessage()]);
        }
    }
    public function destroy($sales_id)
    {
        try {
            $sales = $this->SalesService->destroy($sales_id);
            echo json_encode(['sales' => $sales, 'message' => 'sale deleted successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to  delete sale' . $e->getMessage()]);
        }
    }
}
