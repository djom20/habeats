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
class PilotoController extends ControllerBase {
    //put your code here
    function get () {
        try{
            $params = Partial::prefix($this->get, ':');
            
            $result = $this->getModel('list_pilotos')->select(
                $params
            );
            
            $response = Partial::arrayNames($result);
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "PilotoController - get", "Linea 28");
        }
    }

    function getTypes () {
        try{
            $params = Partial::prefix($this->get, ':');
            $result = $this->getModel('tipo_piloto')->select(
                $params
            );
            $response = Partial::arrayNames($result);
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "PilotoController - getTypes", "Linea 41");
        }
    }
    
    function add () {
        try{
            $_filled = Partial::_filled($this->post, array ('nombre', 'correo'));
            $_empty = Partial::_empty($this->post, array ('idpiloto'));
            
            if($_filled && $_empty) {
                $params = Partial::prefix($this->post, ':');
                
                $pilot = $this->getModel('piloto');
                $pilot->insert($params);
                
                if($pilot->lastID() > 0) {
                    $this->post['idpiloto'] = $pilot->lastID();
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
                }
                
                HTTP::JSON(403);
            }
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(400)));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "PilotoController - add", "Linea 66");
        }
    }
    
    function edit () {
        try{
            $_filled = Partial::_filled($this->put, array ('idpiloto'));
            
            if($_filled) {
                $params = Partial::prefix($this->put, ':');
                
                $this->getModel('piloto')->update($this->put['idpiloto'], $params);
                
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "PilotoController - edit", "Linea 84");
        }
    }
    
    function delete () {
        try{
            $_filled = Partial::_filled($this->delete, array ('idpiloto'));
            $_get = Partial::_filled($this->get, array ('idpiloto'));
            
            if($_filled) {
                $this->getModel('piloto')->delete($this->delete['idpiloto']);
                HTTP::JSON(200);
            } elseif($_get) {
                $this->getModel('piloto')->delete($this->get['idpiloto']);
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "PilotoController - delete", "Linea 103");
        }
    }
}
