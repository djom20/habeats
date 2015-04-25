<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UserController
 *
 * @author edinson
 */

class UserController extends ControllerBase {
    public function _Always() {
        if (in_array(ActionName, array(
                // 'update',
                'get',
                // 'cpw',
                // 'restore',
                'active',
                'logout'
            ))) {
            if (!isset($_SESSION['usuario'])) {
                HTTP::JSON(401);
            }
        }
    }

    function active () {
        try{
            $result = $this->getModel('users_active')->select(array(
                ':idusuario' => $_SESSION['usuario']['idusuario']
            ));

            if (count($result) == 1) {
                $response = Partial::arrayNames($result, array('clave', 'creation'));
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response[0]));
            }
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - active", "Linea 40");
        }
    }

    function getListUsers(){
        try{
            $result = $this->getModel('all_users')->select();
            $response = Partial::arrayNames($result, array('clave', 'creation'));
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - getListUsers", "Linea 50");
        }
    }

    function getRoles(){
        try{
            $result = $this->getModel('list_roles')->select();
            $response = Partial::arrayNames($result, array('estado'));
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - getRoles", "Linea 60");
        }
    }

    function login() {
        try{
            if (Partial::_filled($this->post, array ('correo', 'clave'))) {
                $result = $this->getModel('users_active')->select(array(
                    ':correo'   => $this->post['correo'],
                    ':clave'    => md5($this->post['clave'])
                ));

                if (count($result) == 1) {
                    $response = Partial::arrayNames($result, array('clave', 'creation', 'estado'));
                    $_SESSION['usuario'] = $response[0];
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $_SESSION['usuario']));
                }

                HTTP::JSON(401);
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - login", "Linea 83");
        }
    }

    function logout() {
        try{
            session_destroy();

            HTTP::JSON(200);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - logout", "Linea 93");
        }
    }

    function add() {
        try{
            $empty = Partial::_empty($this->post, array ('idusuario', 'creation'));
            $filled = Partial::_filled($this->post, array ('nombre', 'apellido', 'correo', 'idagencia', 'clave', 'idrol', 'notify'));
            if ($filled && $empty) {
                $usuario = $this->getModel('usuario');
                
                $params = Partial::prefix($this->post, ':');
                $params[':clave'] = md5($this->post['clave']);

                $usuario->insert($params);

                if ($usuario->lastID() > 0) {
                    $headers = "From: " . strip_tags('no-reply@pilotos.com') . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
                    
                    $mail = "<html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                            <style>
                                * {
                                    font-family: 'Roboto', sans-serif;
                                    outline: none;
                                }
                                td {
                                    width: 900px;
                                }
                            </style>
                        </head>
                        <body>
                            <table style=\"background-color: #043264; color: #fff; width: 100%;\">
                                <tr>
                                    <td style=\"text-align: center; padding-top: 30px;\">
                                        <img width=\"135\" height=\"131\" src=\"http://pilotos.soluntech.com/css/imgs/logo.png\" alt=\"header\" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 30px; padding-top: 0;\">
                                        <h2>Bienvenido a Pilotos Barranquilla</h2>

                                        <p>
                                            Estos son los datos de su registro:
                                        </p>

                                        <ul>
                                            <li><b>Nombre:</b> {$this->post['nombre']}</li>
                                            <li><b>Correo:</b> {$this->post['correo']}</li>
                                            <li><b>Clave:</b> {$this->post['clave']}</li>
                                        </ul>

                                        <p>
                                            Por favor, asegure muy bien estos datos.
                                        </p>

                                        <p>&nbsp;</p>
                                        <p>&nbsp;</p>
                                        <p>Gracias.</p>
                                        <p>&nbsp;</p>
                                        <p>El equipo de Pilotos Barranquilla.</p>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>";
                    $sw = mail(strtoupper($this->post['correo']), 'Bienvenido a Pilotos', $mail, $headers);
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $sw));
                }

                HTTP::JSON(404);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - add", "Linea 172");
        }
    }

    function send(){
        try{
            $result =  Partial::arrayNames($this->getModel('lista_proceso')->select(array(
                ':idproceso' => $this->post['idproceso']
            )));

            if(count($result) == 1){
                $headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                $table = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:2px solid #9b9b9b\">
                            <tbody>
                                <tr>
                                    <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b; text-align: center;\">
                                        <img width=\"135\" height=\"131\" src=\"http://pilotos.soluntech.com/css/imgs/logo.png\" alt=\"header\" />
                                    </td>
                                </tr>
                                <tr bgcolor=\"#e7ecf1\">
                                    <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                        <span style=\"float:left\">
                                            <strong>:nombre</strong>
                                        </span>
                                        <span style=\"float:right\">
                                            <strong> Proceso: :idproceso</strong>
                                        </span>
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
                                        <strong>Creacion</strong>
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
                                        :inicio
                                    </td>
                                </tr>
                                <tr>
                                    <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                        <strong>Eventos</strong>
                                    </td>
                                    <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                        <strong>Estado</strong>
                                    </td>
                                    <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b\">
                                        <strong>Finalizacion</strong>
                                    </td>
                                </tr>
                                <tr bgcolor=\"#e7ecf1\">
                                    <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                        :eventos
                                    </td>
                                    <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                        :estado
                                    </td>
                                    <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                        :fin
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

                $table = Partial::fetchRows($result, $table);

                $html = "<html>
                            <head>
                                <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                                <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                                <style>
                                    * {
                                        font-family: 'Roboto', sans-serif;
                                        outline: none;
                                    }
                                    td {
                                        width: 900px;
                                    }
                                </style>
                            </head>
                            <body>". $table ."</body>
                        </html>";

                $result = Partial::arrayNames(
                    $this->getModel('subscribed_users')->select()
                );

                $user_list = '';

                foreach ($result as $key => $value) {
                    $user_list .= $value["correo"].", ";
                }

                $user_list = (strlen($user_list) > 0) ? substr($user_list, 0, -2) : $user_list;

                mail(strtoupper($user_list), 'Creado Proceso '.$this->post['idproceso'].' - Pilotos', $html, $headers);
                HTTP::JSON(200);
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - send", "Linea 296");
        }
    }

    function remainder($idproceso){
        try{
            $result =  Partial::arrayNames($this->getModel('list_processes')->select(array(
                ':idproceso' => $idproceso
            )));

            $headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

            $table = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:2px solid #9b9b9b\">
                        <tbody>
                            <tr>
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b; text-align: center;\">
                                    <img width=\"135\" height=\"131\" src=\"http://pilotos.soluntech.com/css/imgs/logo.png\" alt=\"header\" />
                                </td>
                            </tr>
                            <tr bgcolor=\"#e7ecf1\">
                                <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                    <span style=\"float:left\">
                                        <strong>:proceso</strong>
                                    </span>
                                    <span style=\"float:right\">
                                        <strong> Proceso: :idproceso</strong>
                                    </span>
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

            $table = Partial::fetchRows($result, $table);

            $html = "<html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                            <style>
                                * {
                                    font-family: 'Roboto', sans-serif;
                                    outline: none;
                                }
                                td {
                                    width: 900px;
                                }
                            </style>
                        </head>
                        <body>". $table ."</body>
                    </html>";

            $result = Partial::arrayNames(
                $this->getModel('subscribed_users')->select()
            );

            $user_list = '';

            foreach ($result as $key => $value) {
                $user_list .= $value["correo"].", ";
            }

            $user_list = (strlen($user_list) > 0) ? substr($user_list, 0, -2) : $user_list;

            mail(strtoupper($user_list), 'Proceso '.$idproceso.' - Pilotos', $html, $headers);
            HTTP::JSON(200);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - remainder", "Linea 482");
        }
    }
    
    function restore () {
        try{
            if(!empty ($this->post['correo'])) {
                $user = $this->getModel('usuario');
                $result = $user->select(array(
                    ':correo' => $this->post['correo']
                ));
                
                if(count($result) == 1) {
                    $pass = substr(md5(time()), 0, 8);
                    $user->update($result[0]['idusuario'], array (
                        ':clave' => md5($pass)
                    ));
                    $headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
                    $headers .= "MIME-Version: 1.0\r\n";
                    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                    $mail = "<html>
                        <head>
                            <link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
                            <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\">
                            <style>
                                * {
                                    font-family: 'Roboto', sans-serif;
                                    outline: none;
                                }
                                td {
                                    width: 900px;
                                }
                            </style>
                        </head>
                        <body>
                            <table style=\"background-color: #043264; color: #fff; width: 100%;\">
                                <tr>
                                    <td style=\"text-align: center; padding-top: 30px;\">
                                        <img width=\"135\" height=\"131\" src=\"http://pilotos.soluntech.com/css/imgs/logo.png\" alt=\"header\" />
                                    </td>
                                </tr>
                                <tr>
                                    <td style=\"padding: 30px; padding-top: 0;\">
                                        <h2>Restaurar clave - Pilotos Barranquilla</h2>
                                        <p>
                                            Ha tomado la opcion de restaurar clave. La próxima vez
                                            que inicie sesión debe tener presente la siguiente informacion:
                                        </p>

                                        <ul>
                                            <li><b>Usuario:</b> {$result[0]['correo']}</li>
                                            <li><b>Clave:</b> {$pass}</li>
                                        </ul>

                                        <p>&nbsp;</p>

                                        <p>Te recordamos nuestro link <a href=\"https://pilotosbarranquilla.com/#/login\">Pilotos Barranquilla.</a></p>

                                        <p>&nbsp;</p>


                                        <p>
                                            Por favor, asegure muy bien estos datos.
                                        </p>

                                        <p>&nbsp;</p>
                                        <p>Gracias.</p>
                                        <p>El equipo Pilotos Barranquilla.</p>
                                    </td>
                                </tr>
                            </table>
                        </body>
                    </html>";

                    mail(strtoupper($this->post['correo']), 'Restaurar clave - Pilotos', $mail, $headers);
                        
                    HTTP::JSON(200);
                }
                HTTP::JSON(404);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - restore", "Linea 566");
        }
    }
    
    function update() {
        try{
            $filled = Partial::_filled($this->put, array ('idusuario', 'correo', 'estado', 'notify', 'idagencia', 'idrol', 'apellido', 'nombre'));
            if ($filled) {
                $usuario = $this->getModel('usuario');            
                $params = Partial::prefix($this->put, ':');
                $usuario->update($this->put['idusuario'], $params);
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $params));
                // HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - update", "Linea 583");
        }
    }

    function changeState() {
        try{
            if($_SESSION['usuario']['idusuario'] != $this->post['idusuario']){
                $usuario = $this->getModel('usuario');
                $params = Partial::prefix($this->post, ':');
                $usuario->updateWithOutCode($this->post['idusuario'], $params);
                HTTP::JSON(200);
            }
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - changeState", "Linea 597");
        }
    }

    function cpw() {
        try{
            if (Partial::_filled($this->post, array ('idusuario', 'new'))) {
                $usuario = $this->getModel('usuario');
                $usuario->update($this->post['idusuario'], array(
                    ':clave' => md5($this->post['new'])
                ));

                HTTP::JSON(200);
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - cpw", "Linea 614");
        }
    }

    function changeStateNotify() {
        try{
            if (Partial::_filled($this->post, array('idusuario', 'state'))) {
                $usuario = $this->getModel('usuario');
                $usuario->update($this->post['idusuario'], array(
                    ':notify' => $this->post['state']
                ));

                HTTP::JSON(200);
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "UserController - changeStateNotify", "Linea 631");
        }
    }

}