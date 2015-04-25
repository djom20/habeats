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
class RemolqueController extends ControllerBase {

    function get () {
        try{
            $result = $this->getModel('remolque')->select();        
            $response = Partial::arrayNames($result);        
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "RemolqueController - get", "Linea 22");
        }
    }
    
    function add () {
        try{
            $_filled = Partial::_filled($this->post, array ('nombre', 'imo', 'bollard_pull'));
            $_empty = Partial::_empty($this->post, array ('idremolque'));
            
            if($_filled && $_empty) {
                $params = Partial::prefix($this->post, ':');
                
                $remolque = $this->getModel('remolque');
                $remolque->insert($params);
                
                if($remolque->lastID() > 0) {
                    $this->post['idremolque'] = $remolque->lastID();
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
                }
                
                HTTP::JSON(403);
            }
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(400)));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "RemolqueController - add", "Linea 47");
        }
    }
    
    function edit () {
        try{
            $_filled = Partial::_filled($this->put, array ('idremolque'));        
            if($_filled) {
                $params = Partial::prefix($this->put, ':');
                $this->getModel('remolque')->update($this->put['idremolque'], $params);            
                HTTP::JSON(200);
            }
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "RemolqueController - edit", "Linea 61");
        }
    }
    
    function delete () {
        try{
            $_filled = Partial::_filled($this->delete, array ('idremolque'));
            $_get = Partial::_filled($this->get, array ('idremolque'));
            
            if($_filled) {
                $this->getModel('remolque')->delete($this->delete['idremolque']);            
                HTTP::JSON(200);
            } elseif($_get) {
                $this->getModel('remolque')->delete($this->get['idremolque']);            
                HTTP::JSON(200);
            }
            
            HTTP::JSON(200);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "RemolqueController - delete", "Linea 80");
        }
    }
}
