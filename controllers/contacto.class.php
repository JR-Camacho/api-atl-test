<?php

require "connection/connection.class.php";
require "response.class.php";

class Contacto extends Connection {

    private $table_contactos = "contactos";
    private $contacto_id = "";
    private $nombre = "";
    private $apellidos = "";
    private $correo = "";
   
    public function getContactos(){
        $query = "SELECT * FROM " . $this->table_contactos;
        return parent::getData($query);
    }

    public function getContactoId($id){
        $query = "SELECT * FROM " . $this->table_contactos . " WHERE id = $id";
        return parent::getData($query);
    }

    public function post($json){
        $_response = new Response;
        $data = json_decode($json,true);

        if(!isset($data['nombre']) || !isset($data['apellidos']) || !isset($data['correo'])){
            return $_response->error_400();
        }else{
            $this->nombre = $data['nombre'];
            $this->apellidos = $data['apellidos'];
            $this->correo = $data['correo'];

            $resp = $this->newContacto();
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

    private function newContacto(){
        $query = "INSERT INTO " . $this->table_contactos . " (nombre, apellidos, correo)
        values ('" . $this->nombre . "','" . $this->apellidos . "','" . $this->correo ."')"; 
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
            $this->contacto_id = $data['id'];
            if(isset($data['nombre'])) $this->nombre = $data['nombre'];
            if(isset($data['apellidos'])) $this->apellidos = $data['apellidos'];
            if(isset($data['correo'])) $this->correo = $data['correo'];
                   
            $resp = $this->updateContacto();
            if($resp){
                $respt = $_response->response;
                $respt["result"] = array(
                    "pacienteId" => $this->contacto_id
                );
                return $respt;
            }else{
                return $_response->error_500();
            }
        }
    }

    private function updateContacto(){
        $query = "UPDATE " . $this->table_contactos . " SET nombre ='" . $this->nombre . "', apellidos = '" . $this->apellidos . "', correo = '" . $this->correo . "'WHERE id = '" . $this->contacto_id . "'"; 
        $resp = parent::nonQuery($query);
        if($resp >= 1) return $resp;
        else return false;
    }

    public function delete($id){
        $_response = new response;
        if(!isset($id)){
            return $_response->error_400();
        }else{
            $this->contacto_id = $id;
            $resp = $this->deleteContacto();
            if($resp){
                $respt = $_response->response;
                $response["result"] = array(
                    "contactoId" => $this->contacto_id
                );
                return $respt;
            }else{
                return $_response->error_500();
            }
        }

    }

    private function deleteContacto(){
        $query = "DELETE FROM " . $this->table_contactos . " WHERE id= '" . $this->contacto_id . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1 ) return $resp;
        else return false;
    }

}