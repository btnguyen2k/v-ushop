<?php
/**
 * List of Factory methods that can be used in 
 * object factory  this class is an Interface substitute
 * used for PHP4
 * 
 * THIS IS A FAKE INTERFACE
 * 
 * @version 1.0
 * @package Core.ObjectFactory
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * 
 * @filesource core/objectfacotry/IFactory.php
 * */
class IFactory {
	/**
	 * Get All Factory Objects
	 * 
	 * @return {Array} factory objects
	 * */
	function getFactoryObjects() {}
	
	/**
	 * Get Objectname using the defined object name as pointer
	 * 
	 * @param {String} Object name
	 * @return {Object} resulting object
	 * */
	function getObject($objectname) {}
}
?>
