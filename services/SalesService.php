<?php
require_once 'models/SalesModel.php';

class SalesService
{

    protected $SalesModel;

    public function __construct($SalesModel)
    {
        $this->SalesModel = $SalesModel;
    }

    public function store($data)
    {
        try {
            return $this->SalesModel->store($data);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in SalesService store' . $e->getMessage()]);
        }
    }
    public function show()
    {

        try {
            return $this->SalesModel->show();
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in SalesService show' . $e->getMessage()]);
        }
    }
    public function put($sales_id, $data)
    {

        try {
            return $this->SalesModel->put($sales_id, $data);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in SalesService put' . $e->getMessage()]);
        }
    }
    public function destroy($sales_id)
    {

        try {
            return $this->SalesModel->store($sales_id);
        } catch (Exception $e) {
            echo json_encode(['status' => 'Error in SalesService destroy' . $e->getMessage()]);
        }
    }
}
