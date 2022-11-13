<?php
include 'controllers/contacto.class.php';
include 'controllers/numero.class.php';

$_contacto = new Contacto();
$_numero = new Numero();

if ($_GET['url']) {
    $url = $_GET['url'];
    $id = intval(preg_replace('/[^0-9]+/', '', $url));

    if ($_SERVER['REQUEST_METHOD'] == "GET") {

        switch ($url) {
            case 'contactos';
                $listContactos = $_contacto->getContactos();
                header("Content-Type: application/json");
                echo json_encode($listContactos);
                http_response_code(200);
                break;
            case 'contactos/' . $id;
                $contactoId = $id;
                $dataContacto = $_contacto->getContactoId($contactoId);
                header("Content-Type: application/json");
                echo json_encode($dataContacto);
                http_response_code(200);
                break;
            case 'numeros';
                $listNumeros = $_numero->getNumeros();
                header("Content-Type: application/json");
                echo json_encode($listNumeros);
                http_response_code(200);
                break;
            case 'numeros/' . $id;
                $numeroId = $id;
                $dataNumero = $_numero->getNumeroId($numeroId);
                header("Content-Type: application/json");
                echo json_encode($dataNumero);
                http_response_code(200);
                break;
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "POST") {

        switch ($url) {
            case 'contactos';
                //Recibimos los datos enviados
                $postBody = file_get_contents("php://input");
                //Enviamos los datos al manejador
                $dataArray = $_contacto->post($postBody);
                //Delvovemos una respuesta 
                header('Content-Type: application/json');
                if (isset($dataArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;

            case 'numeros';
                //Recibimos los datos enviados
                $postBody = file_get_contents("php://input");
                //Enviamos los datos al manejador
                $dataArray = $_numero->post($postBody);
                //Delvovemos una respuesta 
                header('Content-Type: application/json');
                if (isset($dataArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "PUT") {

        switch ($url) {
            case 'contactos';
                //Recibimos los datos enviados
                $postBody = file_get_contents("php://input");
                //Enviamos datos al manejador
                $dataArray = $_contacto->put($postBody);
                //Delvovemos una respuesta
                header('Content-Type: application/json');
                if (isset($dataArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;
            case 'numeros';
                //Recibimos los datos enviados
                $postBody = file_get_contents("php://input");
                //Enviamos datos al manejador
                $dataArray = $_numero->put($postBody);
                //Delvovemos una respuesta
                header('Content-Type: application/json');
                if (isset($dataArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;
        }
    } else if ($_SERVER['REQUEST_METHOD'] == "DELETE") {

        switch ($url) {
            case 'contactos/' . $id;
                $contactoId = $id;

                $dataArray = $_contacto->delete($contactoId);

                header('Content-Type: application/json');
                if (isset($datosArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;
            case 'numeros/' . $id;
                $numeroId = $id;

                $dataArray = $_numero->delete($numeroId);

                header('Content-Type: application/json');
                if (isset($datosArray["result"]["error_id"])) {
                    $responseCode = $dataArray["result"]["error_id"];
                    http_response_code($responseCode);
                } else {
                    http_response_code(200);
                }
                echo json_encode($dataArray);
                break;
        }
    }
}
