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
class Log {
    
    public static function save ($error, $message = "", $where = "", $email = "soporte@soluntech.com") {
        $message = $message . ": "; 
    	$html = "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"0\" style=\"border:2px solid #9b9b9b\">
                    <tbody>
                        <tr>
                            <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b; text-align: center;\">
                                <p><b>Error en Pilotos</b></p>
                            </td>
                        </tr>
                        <tr>
                            <td align=\"center\" style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b\">
                                <strong>Donde</strong>
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
                                ". $where ."
                            </td>
                            <td style=\"border-bottom:1px solid #9b9b9b;border-right:1px solid #9b9b9b;text-align:center\">
                                ". date("d F, Y") ."
                            </td>
                            <td style=\"border-bottom:1px solid #9b9b9b;text-align:center\">
                                ". date("h:i:s A") ."
                            </td>
                        </tr>
                        <tr>
                            <td colspan=\"3\" style=\"border-bottom:1px solid #9b9b9b\">
                                <center><strong>Detalle</strong></center>
                            </td>
                        </tr>
                        <tr bgcolor=\"#e7ecf1\">
                            <td colspan=\"3\">". $message . $error ."</td>
                        </tr>
                    </tbody>
                </table>";

        Log::sendmail($email, $html);
    }

    private static function sendmail ($email, $html) {
    	$headers = "From: " . strip_tags('no-reply@example.com') . "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($email, "Error en Pilotos", $html, $headers);
        HTTP::JSON(500);
    }
}