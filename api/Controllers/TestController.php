<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Link
 *
 * @author djom202
 */
class TestController extends ControllerBase {
    public function log() {
        try {
		    echo inverse(5) . "\n";
		    echo inverse(0) . "\n";
		} catch (Exception $e) {
        	Log::save($e->getMessage(), "IndexController - testLog", "Linea 19");
		}
    }

    public function restructureDb(){ /* Cambio para el estado de las motonaves */
        $sw = false;

        /* Modelos */
        $motoModel = $this->getModel('motonave');
        $moto_ocupadaModel = $this->getModel('motonave_ocupada');

        /* Querys */
    	$motovanes = Partial::arrayNames($motoModel->select());
    	$moto_ocupadas = Partial::arrayNames($moto_ocupadaModel->select());

    	if($moto_ocupadas > 0){ /* Existen motonaves ocupadas */
    		foreach ($moto_ocupadas as $key => $value) {
                // echo $value["idmotonave"]."-".$value["motonave"]."<br>"; /* Id de cada motonave */

                if($motovanes > 0){ /* Existen motonaves */
        	    	$motoModel->update($value["idmotonave"], array (
        	            ':ocupada' => 'si'
        	        ));
                    $sw = true;
                    // echo 'Actualizada a SI.'."<br>";
                }
            }

            if($sw){
                HTTP::JSON(200);
            }else {
                HTTP::JSON(500);
            }
    	}

        HTTP::JSON(400);
    }

    public function found(){
        HTTP::JSON(200);
    }

    function remainder(){
        try{
            $param  = 5;
            $where  = 'proccess';
            $table2 = '';

            if($where == 'event'){
                $where = array(':ultimo_eventoid' => $param);
            }else if($where == 'proccess'){
                $where = array(':idproceso' => $param);
            }

            $result =  Partial::arrayNames($this->getModel('list_processes')->select($where));
            $table = $this->createTempTable($param, $where, 'Actual');

            $headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $html = "<html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                            <style>
                                * { font-family: 'Roboto', sans-serif; outline: none; }
                                td { width: 900px; }
                            </style>
                        </head>
                        <body>". $table2 . "<div style=\"padding:15px;\"></div> " . $table ."</body>
                    </html>";
            
            $result2 = Partial::arrayNames(
                $this->getModel('subscribed_users')->select()
            );

            $user_list = '';
            foreach ($result2 as $key => $value) {
                $user_list .= $value["correo"].", ";
            }

            $user_list = (strlen($user_list) > 0) ? substr($user_list, 0, -2) : $user_list;
            mail(strtoupper($user_list), $result[0]['proceso'].' - Pilotos', $html, $headers);


            $this->push($result[0]['idproceso'], '');
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TestController - remainder", "Linea 107");
        }
    }

    function createTempTable($param, $where = 'event', $title = ''){
        try{
            if($where == 'event'){
                $where = array(':ultimo_eventoid' => $param);
            }else if($where == 'proccess'){
                $where = array(':idproceso' => $param);
            }

            $result =  Partial::arrayNames($this->getModel('list_processes')->select($where));
            $table = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:2px solid #9b9b9b\">
                        <tbody>
                            <tr>
                                <td colspan=\"3\" style=\"text-align: center;\">
                                    <img width=\"135\" height=\"131\" src=\"https://pilotosbarranquilla.com/web/css/imgs/logo.png\" alt=\"header\" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b; text-align: center;\">
                                    <p>". $title ."</p>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <span style=\"float:left\">
                                        <strong>:proceso</strong>
                                    </span>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Provisional:</strong> :provisional
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Motonave</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Agencia</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Maniobra</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :motonave
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :agencia
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :maniobra
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Tiempo</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Fecha</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Hora</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :tiempo
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :fecha
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :hora
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Piloto</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Terminal</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Muelle</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :piloto
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :terminal
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :muelle
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Eslora</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Imo</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Manga</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :eslora
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :imo
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :manga
                                </td>
                            </tr>
                            <tr>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Trb</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                    <strong>Popa</strong>
                                </td>
                                <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <strong>Proa</strong>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :trb
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                    :popa
                                </td>
                                <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                    :proa
                                </td>
                            </tr>
                            <tr>
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <center><strong>Comentarios</strong></center>
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\">:observacion</td>
                            </tr>
                        </tbody>
                    </table>";
            $table = Partial::fetchRows3($result, $table);
            return $table;
        } catch (Exception $e) {
            Log::save($e->getMessage(), "EventoController - TestController", "Linea 267");
        }
    }

    function push($idproceso, $option){
        try{
            $result =  Partial::arrayNames($this->getModel('lista_proceso')->select(array(
                ':idproceso' => $idproceso
            )));

            if(count($result) == 1){
                $result2 = Partial::arrayNames(
                    $this->getModel('subscribed_users')->select()
                );

                $result             = $result[0];
                $result['eventos']  = (integer) $result['eventos'];

                if($option == "observacion"){
                    $finalize = " tiene una observacion";
                }else if($result['estado'] == "Creado" && $result['eventos'] == 0){
                    $finalize = " ha sido creado";
                }else if($result['estado'] == "Creado" && $result['eventos'] > 0){
                    $finalize = " ha sido actualizado";
                }else if($result['estado'] == "En Proceso"){
                    $finalize = " ha sido en proceso";
                }else if($result['estado'] == "Finalizado"){
                    $finalize = " ha sido finalizado";
                }

                $messagge = "El proceso " . $result['nombre'] . $finalize;
                foreach ($result2 as $key => $value) {
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        "Content-Type: application/x-www-form-urlencoded;charset=utf-8"
                    ));
                     
                    // definimos la URL a la que hacemos la petición
                    curl_setopt($ch, CURLOPT_URL,"http://pilotosbarranquilla.com/notifi3r/push/send");
                    // definimos el número de campos o parámetros que enviamos mediante POST
                    curl_setopt($ch, CURLOPT_POST, 1);
                    // definimos cada uno de los parámetros
                    $params = "user_id={$value["idusuario"]}&message={$messagge}";
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
                     
                    // recibimos la respuesta y la guardamos en una variable
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $remote_server_output = curl_exec ($ch);

                    // cerramos la sesión cURL
                    // var_dump($remote_server_output);
                    curl_close ($ch);
                }
            }else{
                HTTP::JSON(500);
            }

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $messagge));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TestController - push", "Linea 326");
        }
    }
}