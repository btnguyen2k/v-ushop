<?php
/**
 * DirectoryHelper
 * Handles directory management and control
 * This function traverse all the directory from the given current working
 * directory
 * 
 * This Class extends the Helper class and overrides its method
 *
 * @version 1.0
 * @package Core.Helper
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @filesource core/helper/DirectoryHelper.php
 * @created 08-Apr-2006 9:51:27 AM
 */
class DirectoryHelper extends Helper
{
	/**
	 * Default Constructor
	 * */	
	function DirectoryHelper() {}
	
	/**
	 * Checks the directory using the current working directory as a
	 * basis for traversal.  
	 * This uses an absolute path to recover the directory
	 * being searched 
	 *
	 * @param __dir
	 */
	function find($__dir)
	{
		// get the application path
		$__dir = traverseDir($__dir);
		
		// checks if the directory to find exists
		if(is_dir($__dir)) {
			return $__dir;
		}
		
		// if directory does not exists
		// return -1;
		return -1;
	}
}
?>