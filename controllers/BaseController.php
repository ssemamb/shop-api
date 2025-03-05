<?php

class BaseController
{
    protected $baseUrl;
    public function __construct()
    {
        $this->baseUrl = '/shop-api/v1';
    }

    public function respond($data = [], $message = 'operation successfull', $statuscode = 200)
    {

        http_response_code($statuscode);
        echo json_encode([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ]);
    }
    public function badmessage($message = 'something went wrong', $statuscode = 403)
    {
        http_response_code($statuscode);
        echo json_encode([
            'status' => 'Error',
            'message' => $message
        ]);
    }
    public function notfound($message = 'Resource not found', $statuscode = 404)
    {
        http_response_code($statuscode);
        echo json_encode([
            'status' => 'Error',
            'message' => $message
        ]);
    }
}
