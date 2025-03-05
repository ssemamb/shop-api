<?php

require_once 'services/DashboardService.php';

class DashboardController extends BaseController
{

    protected $DashboardService;

    public function __construct($DashboardModel)
    {
        $this->DashboardService = new DashboardService($DashboardModel);
    }

    public function DashboardMetrics()
    {
        try {
            $Metrics = $this->DashboardService->DasboardMetrics();
            return $this->respond(['Metrics' => $Metrics]);
        } catch (Exception $e) {
            echo json_encode(['Error' => 'unable to fetch metrics', 'details' => $e->getMessage()]);
            throw $e;
        }
    }
}
