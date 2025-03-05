<?php
require_once 'models/BaseModel.php';

class DashboardModel extends BaseModel
{

    public  function   total_profit()
    {
        try {
            $sql = "SELECT COALESCE(SUM(s.price),0) - COALESCE(SUM(s_t.item_price * s.quantity),0) AS total_profit FROM sales s 
            LEFT JOIN stock_items s_t ON s.stock_items_id = s_t.stock_items_id";
            return $this->fetchall($sql);
        } catch (Exception $e) {
            throw new Exception("Error in Dashboard model" . $e->getMessage());
        }
    }

    public function completed_sales()
    {
        try {
            $sql = "SELECT COALESCE(SUM(s.price),0) AS completed_sales FROM sales s WHERE s.status = 'completed'";
            return $this->fetchone($sql);
        } catch (Exception $e) {
            throw new Exception("Error in Dashboard model" . $e->getMessage());
        }
    }
}
