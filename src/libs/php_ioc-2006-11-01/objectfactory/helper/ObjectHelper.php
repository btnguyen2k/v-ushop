<?php
/**
 * Object Helper
 * This class handles and checks if the object / class exists base
 * on the given path.
 * 
 * This Object helper is used throughout the whole framework
 * This class handles the parsing of the class name (similar to java syntax) to a php
 * recognizable format
 * 
 * Syntax: path.to.objects.ObjectName -> path/to/objects/ObjectName.php
 * This class search and uses the directory helper to check on the path of the file
 *
 * @version 1.0
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @package Core.Helper
 * @filesource core/helper/ObjectHeler.php
 * 
 * @created 08-Apr-2006 9:51:28 AM
 */
class ObjectHelper extends Helper
{
	/**
	 * Default Constructor
	 * */
	function ObjectHelper() {}

	/**
	 * Traverse an existing directory
	 * to find the defined class
	 *
	 * @param __dir
	 */
	function find($__classPath)
	{
		// transform the given class path
		$classPath = str_replace(".","/",$__classPath);
		// Calls the directory helper
		$dirHelper = new Helper("DirectoryHelper");

		// get the class path
		// explode the class path 
		$__classLocation = explode(".", $__classPath);
		
		
		// get the class path only not the class name itself
		// example:
		// path.object.ObjectName count = 3; index @ 2
		// this count only retirves the count = 2; index @ 1
		// path.object
		$counter = count($__classLocation) -1;

		// loop through the class path provided
		// rebuild the path
		for($i =0; $i<$counter; $i++) {
			$path .= $__classLocation[$i]."/";
		}

		// check if the directory exists.
		$dir = $dirHelper->find($path);
		
		// if the directory do exists
		if($dir != -1) {
			
			// class name
			$className = $__classLocation[count($__classLocation)-1];
			
			// checks if the file exists base on the path provided
			// the item will be appended with a .php extension
			// example: path/to/object/ObjectName.php
			if(file_exists($dirHelper->find($path).$className.".php")) {
				
				// include the filename of the path
				// dynamic inclusion of the file to the application at runtime.
				include_once $dirHelper->find($path).$className.".php";
				
				// Checks if the class exists
				// this follows the same concept that java uses to define its classes
				// filename: ObjectName.php  ->  class ObjectName 
				// if class exists
				if(class_exists($className)) {
					
					// class information
					$__classInfo[0] = $dirHelper->find($path).$className.".php";
					$__classInfo[1] = $className;

					// return class Information
					return $__classInfo;

				} else {	// if class does not exists
					trigger_error("Class Does not exists!");
					echo "<pre>ObjectHelper::Error:\nThe class does not exists\n   - $className on $classPath.php</pre>";
					
				}
			} else {	// if class file name can't be found
				trigger_error("Class file cant be found!");
				echo "<pre>ObjectHelper::Error:\nThe class can't be found. [$className] on $classPath.php</pre>";
			}
		} else {
			trigger_error("Class Path does not exists.");
			echo "<pre>ObjectHelper::Warning:\nClass path does not exists: check class path: $classPath.</pre>";
		}
		
		// return -1 for errors
		return -1;
	}
}



?>