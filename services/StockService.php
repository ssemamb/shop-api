<?php

require_once 'models/StockModel.php';

class StockService
{

    protected $StockModel;
    public function __construct($StockModel)
    {
        $this->StockModel = $StockModel;
    }

    public function store($user_id, $name, $quantity, $stock_price)
    {
        try {
            return $this->StockModel->store($user_id, $name, $quantity, $stock_price);
        } catch (Exception $e) {

            echo json_encode(['error' => "error in StockService store" . $e->getMessage()]);
        }
    }
    public function show()
    {
        try {
            return $this->StockModel->show();
        } catch (Exception $e) {

            echo json_encode(['error' => "error in StockService show" . $e->getMessage()]);
        }
    }
    public function put($stock_id, $data)
    {
        try {
            return $this->StockModel->put($stock_id, $data);
        } catch (Exception $e) {
            echo json_encode(['error' => "error in StockService put" . $e->getMessage()]);
        }
    }
    public function destroy($stock_id)
    {
        try {
            return $this->StockModel->destroy($stock_id);
        } catch (Exception $e) {
            echo json_encode(['error' => "error in StockService destroy" . $e->getMessage()]);
        }
    }
    public function search($query)
    {
        try {
            return $this->StockModel->search_stock($query);
        } catch (Exception $e) {
            throw new Exception("error in StockService search");
        }
    }
}
