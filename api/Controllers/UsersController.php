<?php
	class UsersController extends ControllerBase {
		public function _Always(){
	        
	    }

	    public function get(){
	        $params = Partial::prefix($this->get, ':');

	        $response = Partial::arrayNames($this->getModel('users')->select(
                $params
            ), array('password', 'state'));

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
	    }
	}