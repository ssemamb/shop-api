<?php
require_once 'controllers/BaseController.php';

require_once 'services/StockItemsService.php';

class StockItemsController extends BaseController
{
    protected $StockItemsService;
    public function __construct($StockItemsModel)
    {
        $this->StockItemsService = new StockItemsService($StockItemsModel);
    }

    public function store()
    {

        try {
            $data = json_decode(file_get_contents('php://input'), true);
            if (empty($input['name']) || empty($input['item_price']) || empty($input['quantity'])) {
                throw new Exception("Required fields are missing");
            }
            $stock_id = $data['stock_id'];
            $name = $data['name'];
            $item_price = $data['item_price'];
            $quantity = $data['quantity'];
            $stock_items = $this->StockItemsService->store($stock_id, $name, $item_price, $quantity);
            return $this->respond(['stock_items' => $stock_items, 'message' => 'stock_item stored successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to record stock_item' . $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            $stock_items = $this->StockItemsService->show();
            echo json_encode(['stock_items' => $stock_items]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to fetch stock_items' . $e->getMessage()]);
        }
    }
    public function put($stock_items_id)
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            if (empty($input['name']) || empty($input['item_price']) || empty($input['quantity'])) {
                throw new Exception("Require fields are missing");
            }
            $stock_items = $this->StockItemsService->put($stock_items_id, $input);
            return $this->respond(['stock_items' => $stock_items, 'message' => 'Stock_item updated successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to update stock_items' . $e->getMessage()]);
        }
    }
    public function destroy($stock_items_id)
    {

        try {
            $stock_items = $this->StockItemsService->destroy($stock_items_id);
            echo json_encode(['stock_items' => $stock_items, 'message' => 'Stock_item deleted successfully']);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to delete stock_items' . $e->getMessage()]);
        }
    }
    public function search()
    {
        try {
            $query = isset($_GET['query']) ? trim($_GET['query']) : '';
            if (empty($query)) {
                throw new Exception("Search field is empty");
            }
            if (!$query) {
                echo json_encode(['Error' => 'Stock_item is not found']);
            }

            $stock_items = $this->StockItemsService->search($query);
            return $this->respond(['stock_items' => $stock_items]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Unable to fetch the required search' . $e->getMessage()]);
        }
    }
}
