<?php
class Response2{
    public $response = [
        'status' => 'ok',
        'result' => array()
    ];

    public function error_405(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "405",
            "error_msg" => "Method not Allow"
        );
        return $this->response;
    }

    public function error_200($response = 'Incorrect data'){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "200",
            "error_msg" => $response
        );
        return $this->response;
    }

    public function error_400(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "400",
            "error_msg" => "Incomplete data"
        );
        return $this->response;
    }

    public function error_500(){
        $this->response['status'] = 'error';
        $this->response['result'] = array(
            "error_id" => "500",
            "error_msg" => "Internal server error"
        );
        return $this->response;
    }
}