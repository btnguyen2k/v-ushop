<?php
include_once dirname(__FILE__)."\util\lite\xml_domit_lite_include.php";

/**
 * Parser
 * This class parses the xml configuration file
 * it handles interpretation (not validation) of the said configuration file
 * the _parse method will output an xml array populated with values
 * and parsed configuration file.
 * 
 * It uses DOMIT Lite class package for its xml parser
 *  
 * @version 1.0
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @package Parser
 * */
class Parser {
	
	/**
	 * XML filename to be parsed
	 * Xml configuration file
	 * 
	 * @var {String} Path of the xml path configuration
	 * */
	var $fileName;
	
	/**
	 * XML array result
	 * 
	 * @var {String} The result of xml parsed
	 * */
	var $xmlArray;
	
	
	/**
	 * Constructor for parsing configuration file
	 * 
	 * @param {String} file name of the xml file
	 * */
	function Parser($fileName) {
		$this->fileName = $fileName;
		
		// perform xml parsing
		$this->_parse();
		//dump($this->xmlArray);
	}
	
	
	/**
	 * Parse operation
	 * this function parses the xml and then return an array
	 * 
	 * This is an interal operation
	 * */
	function _parse() {
		$iocContainer = &new DOMIT_Lite_Document();
		$success = $iocContainer->loadXML($this->fileName, false);
		
		if($success) {
			// array of objects
			$aObjects = array();
		
			// get object collection
			$iocConfig = &$iocContainer->getElementsByTagName("object");
			// object collection count
			$total = $iocConfig->getLength();
			
			// loop through the node list
			for($i=0; $i<$total; $i++) {
				$aObject = array();
				
				$object = &$iocConfig->item($i);
				
				$aObject['name'] = $object->getAttribute("name");
				$aObject['classname'] = $object->getAttribute("classname");
				$aObject['globals'] = $object->getAttribute("globals");
				
				// get properties
				$properties = &$object->getElementsByPath("properties/property");
					
				// get constructor
				$constructor = &$object->getElementsByTagName("constructor");
				
				// invoke methods
				$invokeMethod = &$object->getElementsByTagName("method-invoke");			
				
				$propertyCount = $properties->getLength();
				$constructorCount = $constructor->getLength();
				$invokeMethodCount = $invokeMethod->getLength();
				
				// if properties are defined
				if($propertyCount > 0) {
					$aProp = array();
					
					// get property definition
					for($a=0; $a<$propertyCount; $a++) {
						$prop = $this->_setProperty($properties->item($a));
						
						array_push($aProp, $prop);
					}
					
					$aObject['property'] = $aProp;
				}
				
				// if method invoke was defined
				if($invokeMethodCount > 0) {
					$methods = array();
					 				
					// loop through the method invokation definition
					for($a=0; $a<$invokeMethodCount; $a++) {
		
						$methodParams = $invokeMethod->item($a)->getElementsByTagName("params");
						
						$methodParameters = array();
						for($b=0; $b<$methodParams->getLength(); $b++) {
							array_push($methodParameters,$this->_paramValue($methodParams->item($b)));
						}
						
						$method['method-name'] = $invokeMethod->item($a)->getAttribute("name");
						$method['params'] = $methodParameters; 
						
						array_push($methods, $method);
					}
					
					$aObject['method-invoke'] = $methods;
				}
				
				// if constructor are defined 
				if($constructorCount > 0) {
					$aConst = array();
					
					$constructorParams = $constructor->item(0)->getElementsByTagName("params");
					$totalParams = $constructorParams->getLength();
					
					// loop through the constructor parameters
					for($a=0; $a<$totalParams; $a++) {
						
						$params = $this->_setConstructor($constructorParams->item($a));
						array_push($aConst, $params);
					}
					
					$aObject['constructor'] = $aConst;
				}
				
				
				
				
				$aObjects[$aObject['name']] = $aObject;
			}
			
			
			
			$this->xmlArray['config']['object'] = $aObjects;
		}
	}
	
	/**
	 * set Constructor parameters
	 * parses the <constructor><params type=""><value></value></params></constructor>
	 * 
	 * @param {Object} Element link
	 * @return {Array} Constructor Parameter 
	 * */
	function _setConstructor(&$parameterObject) {
		// parameter array
		$param = array();
		
		return $this->_paramValue($parameterObject);
			
	}
	
	function _setMethodInvocation(&$parameterObject) {
		$method = array();
		
		return $this->_paramValue($parameterObject);	
	}
	
	/**
	 * Set the property tag for the object
	 * <property field=""></property>
	 * 
	 * @param {Object} Node link
	 * @return {Array} Property object
	 * */
	function _setProperty(&$propertyObject) {
		// property array
		$prop = array();
		
		// parameter value
		$prop = $this->_paramValue($propertyObject);
		// field name
		$prop['field'] = $propertyObject->getAttribute("field");
		
		
		return $prop;
	}
	
	/**
	 * Parses the <param type=""><value></value></param>
	 * 
	 * @param {Object} the Element Link to the node list
	 * @return {Array} Property Array
	 * */
	function _paramValue(&$paramValue) {
		$value = $paramValue->firstChild->getText();
		
		// if type is define
		if($paramValue->getAttribute("type") != "") {
			$prop['type'] = $paramValue->getAttribute("type");
			
			// if type is set to enumeration
			if($prop['type'] == "enum") {
				$value = $this->_setEnum($paramValue);
			} elseif($prop['type'] == "hash") {	// if type is set to hash
				$value = $this->_setHash($paramValue);	
			}
			
		} 
			
		// value
		$prop['value'] = $value; 
		
		return $prop;
	}
	
	function _setHash(&$paramValue) {
		$hashObj = array();
		
		$hashObjects = $paramValue->getElementsByPath("hash/map");
		
		// list the map tags
		for($i=0; $i<$hashObjects->getLength(); $i++) {
			$key = $hashObjects->item($i)->getAttribute("key");
			$type = $hashObjects->item($i)->getAttribute("type");
			$value = $hashObjects->item($i)->firstChild->getText();
			
			if($type == "enum") {
				$value = $this->_setEnum($hashObjects->item($i));
			} elseif($type == "object") {
				$value = "ref:".$hashObjects->item($i)->firstChild->getText();
			} elseif($type == "hash") {
				$value = $this->_setHash($hashObjects->item($i));
			}
			
			$hashObj[$key] = $value;
		}	
		
		return $hashObj;
	}
	
	/**
	 * Parses the Enum tag
	 * if the the type is set to enum
	 * 
	 * @param {Object} Enumeration tag
	 * */
	function _setEnum(&$paramValue) {
		$enum = array();
		
		$enumObject = $paramValue->getElementsByTagName("list");
		
		// list the enumeration object
		for($i=0; $i<$enumObject->getLength(); $i++) {
			
			// if reference is set
			if($enumObject->item($i)->getAttribute("ref") != "") {
				$enumValue = "ref:".$enumObject->item($i)->getAttribute("ref");
			} else {
				$enumValue = $enumObject->item($i)->firstChild->getText();	
			}
			
			array_push($enum, $enumValue);
		}
		
		return $enum;
	}
	/**
	 * Return the resulting array
	 * 
	 * @return {Array} associative array
	 * */
	function getArray() {
		return $this->xmlArray;
	}
}
?>
