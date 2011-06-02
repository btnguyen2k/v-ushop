<?php
/** if the IOC_CONTAINER PATH has not been found */
if(is_null(IOC_CONTAINER_PATH)) {
	trigger_error("IOC Container file handler not found.");
}

// included path
include_once IOC_CONTAINER_PATH."\objectfactory\helper\ObjectHelper.php";
include_once IOC_CONTAINER_PATH."\objectfactory\helper\DirectoryHelper.php";


/**
 * Generic Helper class
 * This class can be overriden: find()
 * to provide a new form of Helper object
 * This Class is a factory class for generating and instantiating
 * helper objects
 *
 * @version 1.0
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @package Core.Helper
 * @filesource core/helper/Helper.php
 * 
 * @created 08-Apr-2006 9:51:28 AM
 */
class Helper
{
	/**
	 * The derived helper object
	 *
	 * @var factory object
	 * */
	var $__factoryHelper;


	/**
	 * This Class serves as a helper factory
	 * this imporves the manageability in accessing resources
	 * inside the system
	 *
	 * The helper factory
	 * @var __HelperType the Helper object to generate
	 * */
	function Helper($__HelperType)
	{
		// factory helper
		$this->__factoryHelper = new $__HelperType();
	}


	/**
	 * Perform search base on the type of helper to be used
	 *
	 * @param __findWhat
	 * @return {mixed} The defined output of the object factory
	 */
	function find($__findWhat)
	{
		return $this->__factoryHelper->find($__findWhat);
	}

	/**
	 * Get a helper
	 *
	 * @param __type
	 * @return {Helper} Defined Factory Helper object
	 */
	function getHelper($__type)
	{
		return $this->__factoryHelper;
	}

}
?>