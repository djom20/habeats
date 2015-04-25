<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AgenciaController
 *
 * @author edinson
 */
class AgenciaController extends ControllerBase {
    //put your code here
    function get () {
        try{
            $params = Partial::prefix($this->get, ':');
            
            $result = $this->getModel('list_agencias')->select(
                $params
            );
            
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "AgenciaController - get", "Linea 27");
        }
    }
    
    function add () {
        try{
            $_filled = Partial::_filled($this->post, array ('rut','nombre', 'correo'));
            $_empty = Partial::_empty($this->post, array ('idagencia'));
            
            if($_filled && $_empty) {
                $params = Partial::prefix($this->post, ':');
                $agency = $this->getModel('agencia');
                $agency->insert($params);
                
                if($agency->lastID() > 0) {
                    $this->post['idagencia'] = $agency->lastID();
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
                }
                
                HTTP::JSON(403);
            }
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(400)));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "AgenciaController - add", "Linea 51");
        }
    }
    
    function edit () {
        try{
            $_filled = Partial::_filled($this->put, array ('idagencia'));
            if($_filled) {
                $params = Partial::prefix($this->put, ':');
                $this->getModel('agencia')->update($this->put['idagencia'], $params);
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "AgenciaController - edit", "Linea 66");
        }
    }
    
    function delete () {
        try{
            $_filled = Partial::_filled($this->delete, array ('idagencia'));
            $_get = Partial::_filled($this->get, array ('idagencia'));
            
            if($_filled) {
                $this->getModel('agencia')->delete($this->delete['idagencia']);
                HTTP::JSON(200);
            } elseif($_get) {
                $this->getModel('agencia')->delete($this->get['idagencia']);
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "AgenciaController - delete", "Linea 85");
        }
    }
}
