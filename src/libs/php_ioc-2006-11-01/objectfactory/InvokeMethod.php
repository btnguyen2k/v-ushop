<?php

/**
 * InvokeMethod
 * Method Invocator class that handles the execution of the method upon instantiation
 * after instantiating method can be called as a prelimenary routine of the object
 * 
 * This class handles method injection for the instantiated class
 * 
 * @version 1.0
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @filesource core/objectfactory/InvokeMethod.php
 * @package Core.ObjectFactory
 * 
 * */
class InvokeMethod {
	
	/**
	 * Invoke the method to be executed
	 * this invoke method uses method injection for the classes for
	 * any needed parameters for it to execute.
	 * 
	 * @param {Object} object instance
	 * @param {String} method name
	 * @param {Array} Parameter array
	 * */
	function invoke(&$objectInstance, $methodName, $param) {
		$parameters = "";
		for($i=0; $i<count($param); $i++){
			$parameters .= "\$param[$i]";
			
			if($i != (count($param)-1)) $parameters .= ",";
		}
		
		$code = "\$objectInstance->$methodName($parameters);";
		
		eval($code);
	}
}
?>
