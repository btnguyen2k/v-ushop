<?php
/** if the IOC_CONTAINER PATH has not been found */
if(is_null(IOC_CONTAINER_PATH)) {
	trigger_error("IOC Container file handler not found.");
}

include_once IOC_CONTAINER_PATH."\objectfactory\IFactory.php";
include_once IOC_CONTAINER_PATH."\objectfactory\parser\Parser.php";
include_once IOC_CONTAINER_PATH."\objectfactory\loader\ClassLoader.php";
include_once IOC_CONTAINER_PATH."\objectfactory\InvokeConstructor.php";
include_once IOC_CONTAINER_PATH."\objectfactory\InvokeMethod.php";
include_once IOC_CONTAINER_PATH."\objectfactory\DirectoryHandler.php";

/**
 * Object Factory
 * This class handles the whole wiring, instantiation, interpretation of the
 * whole IOC framework.  This object factory handles the hardwork done
 * from the configuration down to the useable objects.  This factory
 * handles the inversion of control and dependecy injection on any targeted class or
 * object.
 * 
 * The object factory extends the IFactory (it should be an interface)
 * that overrides the method getObject and get Objects
 * 
 * Change Log
 * 1.0 Core Functions for Object factory
 * 
 * 1.1 Added __getCacheObjects()
 * 	   Added __cacheObjects()
 * These functions are added due to performance issues.  These methods
 * provides caching for defined class for easy pointing and accessing of these
 * classes.
 * 
 * @version 1.2
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @filesource core/objectfactory/ObjectFactory.php
 * @package Core.ObjectFactory 
 * */
class ObjectFactory extends IFactory {
	
	/**
	 * Associative Array containing the parsed XML file
	 * translated into an array that will be used in the creation of
	 * the object it self.  The factory object array
	 * handles the descriptive information of the object to be instantiated
	 * 
	 * @var {Mixed Array} Factory objects 
	 * */
	var $factoryObjects;
	
	/**
	 * The path for the Configuration file (XML)
	 * 
	 * @var {String} Configuration file
	 * */
	var $configFile;
	
	/**
	 * Class Loader instance to be used in creating the object
	 * 
	 * @var {ObjectHelper} Class loader object
	 * @filesource core/loader/ClassLoader.php
	 * */
	var $classLoader;
	
	/**
	 * Default Constructor of the Object Factory
	 * this object factory will parse the configuration file
	 * to be later use for calling any of the defined objects.
	 * 
	 * @param {String} configuration file
	 * */
	function ObjectFactory($configFile) {
		// Clall the Class loader object
		$this->classLoader = new ClassLoader();
				
		// if the configuration file exists
		if(file_exists($configFile)) {
			// Create a new parser object
			// this would parse the given configuration file
			// this would also perform the parsing method itself
			$parser = new Parser($configFile);
			
			// get the resulting array of the parsed XML file
			$this->factoryObjects = $parser->getArray();
			
			// Perform array formating for objects found
			$this->_formatArray($this->factoryObjects);
			
		} else {	// if configuration file does not exists
			trigger_error("Configuration File Does not exists: ");
		}
					
	}
	
	
	/**
	 * Override IFactory::getFactoryObjects
	 * 
	 * Returns all objects defined in the factory
	 * @return {Array} Collection of Objects
	 * */
	function getFactoryObjects() {
		return $this->factoryObjects['config']['object'];
	}
	
	
	/**
	 * Override IFactory::getObject
	 * This method handles the instantiation of the class to an object
	 * This uses the object name defined in the configuration file
	 * and then use the definition provided for the class itself.
	 * 
	 * This method uses the factory object parsed array.
	 * 
	 * Get Object Name
	 * @param {String} Object Name
	 * */
	function getObject($objectname) {
		
		// if object has been cached already
		if($this->__getCacheObjects($objectname) != null)
			return $this->__getCacheObjects($objectname);
		
		// get factory objects
		$factoryObjects = $this->getFactoryObjects();
		
		// get the defined factory objects
		$object = $factoryObjects[$objectname];
		if(is_null($object)) {
			trigger_error("Error: Object definition does not exists");
		}
		
		// object name derrived from the factory object arrayu
		$objectName = $object['name'];
		// class name
		$className = $object['classname'];
		
		// the dummy object that would contain the resulting object
		$obj = "";
		// load the class
		// using the class name provided and assigned it to the dummy object
				
		// if constructor is defined
		if(count($object['constructor']) > 0) {
			// get the constructor definition
			$constructorParams = $object['constructor'];
			
			// constructor parameters array
			// this would handle the constructor definition
			// based on the given Xml definition
			$parameters = array();
			
			// constructor parameters
			// loop through the consturctor parameters provided
			// by the definition of the constuctor
			foreach($constructorParams as $param) {
				
				// perform evaluation of the consturctor
				// if there are object definition needed by the constructor
				// it would provide an auto wiring mechanism to build the requirements
				// of the object
				$value = $this->evaluate($param['type'], $param['value']);
				
				// collection of the derived objects and parameters
				array_push($parameters, $value);
			}
			
			// invoke constructor object
			// to create the class via constructor method
			$obj = InvokeConstructor::invoke($className, $parameters);
			
		} else {
			$this->classLoader->loadClass($className, $obj);
		}
			
		// if there are properties defined
		if(count($object['property']) > 0) {
			// using the property definition
			// loop through the properties array
			// and then assign the values to the said object
			foreach($object['property'] as $property) {
				
				// call the assignFieldValue method
				$this->assignFieldValue($obj, $property);	
			}
		}
		
		
		// if there are method invocation defined
		if(count($object['method-invoke']) > 0) {
			
			
			// loop through all the defined method invokation provided
			foreach($object['method-invoke'] as $method) {
				
				// method parameters array
				$parameters = array();
				
				// loop through the parameters
				foreach($method['params'] as $param) {
					$value = $this->evaluate($param['type'], $param['value']);
					array_push($parameters, $value);	
				}
				
				
				// invoke the method to perform
				// using the parameters and the method name to be executed
				InvokeMethod::invoke($obj, $method['method-name'], $parameters);
			}
		}
		
		// if globals is set to true
		// then make the object accessible to globals array
		if($object['globals'] == "true") $GLOBALS[$object['name']] = $obj;
		
		// cache the object to a global temp array for easy
		// object referencing 
		$this->__cacheObjects($objectname, $obj); 
		
		// return the resulting object
		return $obj;
			
	}


// ------------------------------------------ INTERNAL METHODS ------------------------------------------//
// the following methods are used to evalute the items in the array
	
	/**
	 * Return any cache objects that has been defined by the system
	 * 
	 * @param {String} objectname
	 * */
	function __getCacheObjects($objectname) {
		return $GLOBALS['__TEMP'][$objectname];	
	}
	
	/**
	 * Return the cached objects that has been defined
	 * 
	 * @param {String} object name
	 * @param {Object} object to be cached
	 * */
	function __cacheObjects($objectname, $obj) {
		if($this->__getCacheObjects($objectname) == null) $GLOBALS['__TEMP'][$objectname] = $obj;
	}
	
	/**
	 * Evaluate object composition
	 * checks the type to perform evaluation
	 * 
	 * @param {String} Type
	 * @param {String} Parameter Value
	 * */
	function evaluate($type, $paramValue) {
		// if type is set to object
		if($type == "object") {
			
			if($this->__getCacheObjects($paramValue) == null) {
				// get the object definition
				// RECURSIVE DEFINITION FOR objects
				
				// WARNING: AVOID circular definition
				// MAY CAUSE unknown result
				$value = $this->getObject($paramValue);				
			} else {
				$value = $this->__getCacheObjects($paramValue);
			}

		} elseif($type == "enum") {	// if type is set to enumeration
			
			// perform evaluate array
			// for enumeration object
			$value = $this->evalArray($paramValue);
		} elseif($type == "hash") { // if the type is set to hash table
			
			// perform evalution of array
			$value = $this->evalArray($paramValue);
		}else {
			
			// use the original value of the item
			$value = $paramValue; 
		}
		
		
		// the resulting value of the evalutation
		return $value;
	}
	
	/**
	 * Evaluate Array definition
	 * This method is used by object type "HASH" and "ENUM"
	 * this method will evalute the array and check other type
	 * definitions along its evalution
	 * 
	 * This is a recursive method.  Refrain from circular definition.
	 * 
	 * @param {Array} the array to be evaluated
	 * */	
	function evalArray(&$array) {
		// enumeration array
		$aEnum = array();
		
		// loop through the enumeration 
		foreach($array as $key => $li) {
			// if the content of the item is array
			if(is_array($li)) {
				// if the item is an array
				// evalute the internal array
				$value = $this->evalArray($li);
			} else {
				
				// if the item is not an array
				// explode the stirng and check if the item is an object reference
				// ref:objectname
				$oList = explode(":", $li);
				// get the item at point 0
				$value = $oList[0];
				
				// if the item at point 0 is "ref" meaning the item is an object reference
				if($oList[0] == "ref") {
					// call the function getObject
					// get the object name
					
					// check if the object is in the cache container
					if($this->__getCacheObjects(trim($oList[1])) == null) {
						$value = $this->getObject(trim($oList[1]));				
					} else {
						$value = $this->__getCacheObjects(trim($oList[1]));
					}
				}	
			}
			
			// the final value of the evalutated item
			$array[$key] = $value;
		}
		
		// the evalutated array
		return $array;
	}
	
	
	/**
	 * This function assigned the field value to the object field
	 * defintition this function handles the property definition
	 * 
	 * @param {Object} Property being assigned to the object
	 * @param {Array} Property array
	 * */
	function assignFieldValue(&$object, $property) {
		
		// Perform evaluation
		// to check for its type
		$value = $this->evaluate($property['type'], $property['value']);
		
		// assign value to the property
		$object->$property['field'] = $value;
		
	}
	
	/**
	 * Format parsed XML the array result
	 * this function is used for reference purposes only.
	 * 
	 * @param {Array} the parsed XML array 
	 * */
	function _formatArray(&$array) {
		$objects = $array['config']['object'];
		
		// loop through the objects and format the array to make it an associative array
		// for refernce used only
		foreach($objects as $objectKey => $object) {
			 // change the key of the objects to objectname
			 // this will be use as pointer substitute
			 $objects[$object['name']] = $object;
			 
			 // remove the array
			 unset($objects[$objectKey]);
		}
		
	}	
}
?>
