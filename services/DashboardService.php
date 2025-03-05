<?php

require_once 'models/DashboardModel.php';

class DashboardService
{
    protected $DashboardModel;

    public function __construct($DashboardModel)
    {
        $this->DashboardModel = $DashboardModel;
    }

    public function completed_sales()
    {
        try {
            return $this->DashboardModel->completed_sales();
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Error in dashboardService', 'details' => $e->getMessage()]);
            throw $e;
        }
    }

    public function total_profit()
    {

        try {
            return $this->DashboardModel->total_profit();
        } catch (Exception $e) {
            echo json_encode(['Error' => 'Error in dashboardService', 'details' => $e->getMessage()]);
            throw $e;
        }
    }

    public function DasboardMetrics()
    {
        return [
            'completed_sales' => $this->completed_sales(),
            'total_profit' => $this->total_profit()
        ];
    }
}
