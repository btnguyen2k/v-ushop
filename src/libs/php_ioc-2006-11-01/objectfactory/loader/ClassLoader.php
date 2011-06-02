<?php
/** if the IOC_CONTAINER PATH has not been found */
if(is_null(IOC_CONTAINER_PATH)) {
	trigger_error("IOC Container file handler not found.");
}

include_once IOC_CONTAINER_PATH."\objectfactory\helper\Helper.php";

/**
 * Class Loader
 * This class loads the class definition dynamically @ runtime
 * This class can call class at any point in the application if needed
 * This class loaded uses dynamic instantiation of the class and can populate
 * the consturctor of the said class
 * 
 * @version 1.0
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @package Core.Loader
 * @filesource core/loader/ClassLoader
 * */
class ClassLoader {
	
	/**
	 * Load Class into the system dynamically
	 * it can be used to set the object constructor to the system
	 * and load it on runtime.
	 * 
	 * Taken from http://www.php.net/manual/en/function.eval.php
	 *
	 * @param {String} className
	 * @param {Mixed} dummy object passed by reference 
	 * @param contstructor Parameters
	 * */
   function loadClass($className, &$__obj='') {
	   
	  
	   // Call the ObjectHelper object to handle class call
	   $objHelper = new Helper("ObjectHelper");
	   
	   
	   // find the given class name if exists
	   $__classInfo = $objHelper->find($className);
		
		
	   // if Helper Result was not -1
	   // if class was found
	   if($__classInfo != -1) {
		   
		   // check the function arguments
		   // provided by the user
		   $numargs = func_num_args();

		  // if the arguements provided is greater than 2
	       if( $numargs > 2 ) {
	           // get all the arguments provided
	           $arg_list = func_get_args();
	           
	           // loop through the arguements to retrive the parameters
	           for($i=2;$i<count($arg_list);$i++) {
	               
	               // build the parameter list
	               $parameter .= "\$arg_list[$i]";
	               if($i != (count($arg_list)-1)) $parameter .= ",";
	           }
	       }
		  
		  
		   // include the specific file of the object to be loaded
		   include_once $__classInfo[0];
		   
		   // dummy object
		   $objectName = "";
		   
		   // instatiate the class
		   eval("\$objectName = new $__classInfo[1]($parameter);");
		
		   // return the object 		
		   $__obj = $objectName;

           return $objectName;
	   }

	}
}
?>
