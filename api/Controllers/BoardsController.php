<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of BoardsController
 *
 * @author edinson
 */
class BoardsController extends ControllerBase {
    //put your code here
    function getProfundidadRio () {        
        try{
            $result = $this->getModel('profundidad_rio')->select(array(), ' ORDER BY sector');
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - getProfundidadRio", "Linea 22");
        }
    }

    function getMovPortuarios () {
        try{
            $params = Partial::prefix($this->get, ':');
            $result = $this->getModel('movportuario')->select(
                $params
            );
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - getMovPortuarios", "Linea 35");
        }
    }

    function getMovPortuariosToCsv () {
        try{
            $params = Partial::prefix($this->get, ':');
            $result = $this->getModel('movportuario')->select(
                $params
            );

            $response = Partial::arrayNames($result, array('idproceso', 'proceso', 'idagencia', 'ultimo_eventoid', 'observacion'));
            $file = Partial::toCsv($response);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - getMovPortuariosToCsv", "Linea 49");
        }
    }

    function getSitTerminales () {
        try{
            $params = Partial::prefix($this->get, ':');
            $result = $this->getModel('terminal')->select(
                $params
            );
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - getSitTerminales", "Linea 62");
        }
    }

    function getStatusSitTerminales () {
        try{
            $params = Partial::prefix($this->get, ':');
            $result = $this->getModel('sit_terminales')->select(
                $params
            );
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - getStatusSitTerminales", "Linea 75");
        }
    }

    function postSitTerminales () {
        try{
            $_filled = Partial::_filled($this->post, array('idterminal'));

            if($_filled) {
                // Delete all Rows of this terminal
                $sitTerminales = $this->getModel('sit_terminales');
                $sitTerminales->deleteWhere($this->post['idterminal'], 'idterminal');

                // Save all components of this terminal
                $i = 1;
                foreach ($this->post as $key => $value) {
                    if($key === "idterminal"){ $idterminal = $value; }
                    else{
                        foreach ($value as $key2 => $value2) {
                            $params = Partial::prefix(array('idterminal'=> $idterminal, 'muelle'=> $i, 'valor'=> $value2['name']), ':');
                            $response = $sitTerminales->insert($params);
                            $i++;
                        }
                    }
                }
                HTTP::JSON(200);
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - postSitTerminales", "Linea 105");
        }
    }
    
    function updateProfundidadRio () {
        try{
            $_filled = Partial::_filled($this->put, array('idprofundidad_rio', 'sector'));
        
            if($_filled) {
                $params = Partial::prefix($this->put, ':');
                $this->getModel('profundidad_rio')->updateWithNull($this->put['idprofundidad_rio'], $params);
                HTTP::JSON(Partial::createResponse(HTTP::Value(200), $params));
            }

            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "BoardsController - updateProfundidadRio", "Linea 121");
        }
    }
}
