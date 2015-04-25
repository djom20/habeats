<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of EventoController
 *
 * @author edinson
 */
class TerminalController extends ControllerBase {
    //put your code here
    function get () {
        try{
            $params = Partial::prefix($this->get, ':');
            
            $result = $this->getModel('terminal')->select(
                $params
            );
            
            $response = Partial::arrayNames($result);
            
            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TerminalController - get", "Linea 28");
        }
    }
    
    function add () {
        try{
            $_filled = Partial::_filled($this->post, array ('nombre'));
            $_empty = Partial::_empty($this->post, array ('idterminal'));
            
            if($_filled && $_empty) {
                $params = Partial::prefix($this->post, ':');
                
                $terminal = $this->getModel('terminal');
                $terminal->insert($params);
                
                if($terminal->lastID() > 0) {
                    $this->post['idterminal'] = $terminal->lastID();
                    HTTP::JSON(Partial::createResponse(HTTP::Value(200), $this->post));
                }
                
                HTTP::JSON(403);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TerminalController - add", "Linea 53");
        }
    }
    
    function edit () {
        try{
            $_filled = Partial::_filled($this->put, array ('idterminal'));
            
            if($_filled) {
                $params = Partial::prefix($this->put, ':');

                if($this->put['idterminal'] == null){
                    $this->put['idterminal'] = 0;
                }
                
                $this->getModel('terminal')->update($this->put['idterminal'], $params);
                
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TerminalController - edit", "Linea 75");
        }
    }
    
    function delete () {
        try{
            $_filled = Partial::_filled($this->delete, array ('idterminal'));
            $_get = Partial::_filled($this->get, array ('idterminal'));
            
            if($_filled) {
                $this->getModel('terminal')->delete($this->delete['idterminal']);
                
                HTTP::JSON(200);
            } elseif($_get) {
                $this->getModel('terminal')->delete($this->get['idterminal']);
                
                HTTP::JSON(200);
            }
            
            HTTP::JSON(400);
        } catch (Exception $e) {
            Log::save($e->getMessage(), "TerminalController - delete", "Linea 96");
        }
    }
}
