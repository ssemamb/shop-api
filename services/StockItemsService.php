<?php

require_once 'models/StockItemsModel.php';

class StockItemsService
{

    protected $StockItemsModel;
    public function __construct($StockItemsModel)
    {
        $this->StockItemsModel = $StockItemsModel;
    }

    public function store($stock_id, $name, $item_price, $quantity)
    {
        try {
            return $this->StockItemsModel->store($stock_id, $name, $item_price, $quantity);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in StockitemsService Store' . $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            return $this->StockItemsModel->show();
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in StockitemsService Show' . $e->getMessage()]);
        }
    }
    public function put($stock_items_id, $data)
    {
        try {
            return $this->StockItemsModel->put($stock_items_id, $data);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in StockitemsService put' . $e->getMessage()]);
        }
    }
    public function destroy($stock_items_id)
    {


        try {
            return $this->StockItemsModel->destroy($stock_items_id);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in StockitemsService destroy' . $e->getMessage()]);
        }
    }
    public function search($query)
    {



        try {
            return $this->StockItemsModel->search($query);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in StockitemsService search' . $e->getMessage()]);
        }
    }
}
