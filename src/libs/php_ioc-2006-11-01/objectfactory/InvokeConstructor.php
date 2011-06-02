<?php
/** if the IOC_CONTAINER PATH has not been found */
if(is_null(IOC_CONTAINER_PATH)) {
	trigger_error("IOC Container file handler not found.");
}

include_once IOC_CONTAINER_PATH."\objectfactory\loader\ClassLoader.php";

/**
 * This class handles object using Constructor
 * invocation definition
 * 
 * If the class call defined in the configuration xml
 * was set to constructor then this object will handle
 * the invokation of the class
 * 
 * @version 1.0
 * @author jpdguzman
 * */
class InvokeConstructor {
	
	/**
	 * Invoke Method
	 * this method performs the constructor invokation using
	 * dynamic parameters for class.
	 * 
	 * @param {String} className - Class Name
	 * @param {Mixed} params - Constructor Parameters
	 * */
	function invoke($className, $params = array()) {
		// Class loader object
		$loader = new ClassLoader();
		
		// dummy object that would contain the object instance
		$objectInstance = "";
		
		// parameter listing
		$parameters = "";
		
		// build the parameter list for the code to execute
		for($i=0; $i<count($params); $i++){
			$parameters .= "\$params[$i]";
			if($i != (count($params)-1)) $parameters .= ",";
		}
		
		// build the code to instantiate the class
		$code = "\$loader->loadClass('$className', &\$objectInstance, $parameters);";
		
		// execute contructor call
		eval($code);
		
		// return the object instance
		return $objectInstance;			
	}
	
	
}
?>
