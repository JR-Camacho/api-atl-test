<?php
class Connection {

    private $hostname;
    private $username;
    private $password;
    private $database;
    private $port;
    private $connection;

    public function __construct()
    {
        $listData = $this->getDataConnection();
        foreach ($listData as $value) {
            $this->hostname = $value['hostname'];
            $this->username = $value['username'];
            $this->password = $value['password'];
            $this->database = $value['database'];
            $this->port = $value['port'];
        }

        $this->connection = new mysqli($this->hostname, $this->username, $this->password, $this->database, $this->port);
        if($this->connection->connect_errno) die("Connection error");   
    }

    // Optenemos los datos de la conexion desde el archivo config
    private function getDataConnection(){
        $path = dirname(__FILE__);
        $jsonData = file_get_contents($path . "/" . "config");
        return json_decode($jsonData, true);
    }

    // Si recibimos un caracter raro lo convertimos a UTF-8
    private function convertUTF8($arr){
        array_walk_recursive($arr, function(&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)) $item = utf8_encode($item);
        });
        return $arr;
    }

    public function getData($sqlstr){
        $results = $this->connection->query($sqlstr);
        $arrResults = array();
        foreach($results as $value){
            $arrResults[] = $value;
        }
        return $this->convertUTF8($arrResults);
    }

    public function nonQuery($sqlstr){
        $this->connection->query($sqlstr);
        return $this->connection->affected_rows;
    }

    public function nonQueryId($sqlstr){
        $this->connection->query($sqlstr);
        $rows = $this->connection->affected_rows;
        if($rows >= 1) return $this->connection->insert_id;
        else return 0;
    }
}