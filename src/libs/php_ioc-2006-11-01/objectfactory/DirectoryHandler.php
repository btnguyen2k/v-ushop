<?
/**
 * Directory Traversal Functions
 * this sets of functions are used to control directory structure and directory
 * traversal.
 * This function works down the file system starting from the location where
 * the search originates and then traverse down one directory at a time.
 * if the file is not found, then the directory goes one directory down.
 * this traversal function displays relative path from the orginal path specified.
 *
 * this function is used in traversing down the file system for includes and resource
 * allocation.
 *
 * @author John Paul de Guzman <jpdguzman@gmail.com>
 * @package functions_directory
 * @version 1.0
 */

/**#@+
 * Directory Traversal Function List
 * this function are used in determining the location of the file inside the file system
 * 
 * @return string
 */

/**
 * Add traversal header
 * This adds one directory down (../) header to the current directory.
 *
 * @param string $curDir - put a header to go down one directory lower.
 * @access private
 */
function addHeaderTraversal($curDir)
{
	return '../'.$curDir;
}

/**
 * Traverse Directory
 * this function is the public function that traverses donw the file system searching for files
 * this function uses the traversal header to search trough the file system.
 *
 * @param string $filename - filename to search.
 */
function traverseDir($filename)
{
	// traverse through filesystem
	while(!file_exists($filename)){
		$filename = addHeaderTraversal($filename);
	}
	//return the file name path.
	return $filename;
}
/**#@-*/


?>
