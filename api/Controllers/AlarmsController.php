<?php
	class AlarmsController extends ControllerBase {
		public function _Always(){
	        
	    }

	    public function get(){
	        $params = Partial::prefix($this->get, ':');

	        $response = Partial::arrayNames($this->getModel('alarms')->select(
                $params
            ), array('state'));

            HTTP::JSON(Partial::createResponse(HTTP::Value(200), $response));
	    }
	}