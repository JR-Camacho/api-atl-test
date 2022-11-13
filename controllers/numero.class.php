<?php
require "connection/connection2.class.php";
require "response2.class.php";

class Numero extends Connection2{
    private $table_numeros = "numeros";
    private $contacto_id = "";
    private $numero_id = "";
    private $numero = "";
   
    public function getNumeros(){
        $query = "SELECT * FROM " . $this->table_numeros;
        return parent::getData($query);
    }

    public function getNumeroId($id){
        $query = "SELECT * FROM " . $this->table_numeros . " WHERE id = $id";
        return parent::getData($query);
    }

    public function post($json){
        $_response = new Response;
        $data = json_decode($json,true);

        if(!isset($data['numero']) || !isset($data['contacto_id'])){
            return $_response->error_400();
        }else{
            $this->numero = $data['numero'];
            $this->contacto_id = $data['contacto_id'];

            $resp = $this->newNumero();
            if($resp){
                $respt = $_response->response;
                $respt["result"] = array(
                    "contactoId" => $resp
                );
                return $respt;
            }else{
                return $_response->error_500();
            }        
        }
    }

    private function newNumero(){
        $query = "INSERT INTO " . $this->table_numeros . " (numero, contacto_id)
        values ('" . $this->numero . "','" . $this->contacto_id . "')"; 
        $resp = parent::nonQueryId($query);
        if($resp)return $resp;
        else return false;
    }

    public function put($json){
        $_response = new response;
        $data = json_decode($json,true);

        if(!isset($data['id'])){
            return $_response->error_400();
        }else{
            $this->numero_id = $data['id'];
            if(isset($data['numero'])) $this->numero = $data['numero'];
            if(isset($data['contacto_id'])) $this->apellidos = $data['contacto_id'];
                   
            $resp = $this->updateNumero();
            if($resp){
                $respt = $_response->response;
                $respt["result"] = array(
                    "numeroId" => $this->numero_id
                );
                return $respt;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function updateNumero(){
        $query = "UPDATE " . $this->table_numeros . " SET numero ='" . $this->numero . "'WHERE id = '" . $this->numero_id . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1) return $resp;
        else return false;
    }

    public function delete($id){
        $_response = new response;
        if(!isset($id)){
            return $_response->error_400();
        }else{
            $this->numero_id = $id;
            $resp = $this->deleteNumero();
            if($resp){
                $respt = $_response->response;
                $response["result"] = array(
                    "numeroId" => $this->numero_id
                );
                return $respt;
            }else{
                return $_response->error_500();
            }
        }

    }

    private function deleteNumero(){
        $query = "DELETE FROM " . $this->table_numeros . " WHERE id= '" . $this->numero_id . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ) return $resp;
        else return false;
    }

}