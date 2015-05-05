<?php
	class RecipesController extends ControllerBase {
		public function _Always(){
	        
	    }

	    public function get(){
	        $params = Partial::prefix($this->get, ':');

	        $response = Partial::arrayNames($this->getModel('recipes')->select(
                $params
            ), array('state'));

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
	    }
	}