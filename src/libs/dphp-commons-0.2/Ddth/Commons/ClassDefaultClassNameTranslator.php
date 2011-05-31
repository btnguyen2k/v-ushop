<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default implementation of {@link Ddth_Commons_IClassNameTranslator}.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDefaultClassNameTranslator.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/** */
require_once 'ClassIClassNameTranslator.php';

/**
 * Default implementation of {@link Ddth_Commons_IClassNameTranslator}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * This class implements interface {@link Ddth_Commons_IClassNameTranslator} with the
 * following translating rule:
 *
 * <ul>
 * 	<li>Class name format: <i>Package1_Package2_Package3_ClazzName</i>.
 * 	<li>Translated file name: <i>Package1/Package2/Package3/ClassClazzName.php</i>
 * 	<li>Example: class <i>Ddth_Commons_DefaultClassNameTranslator</i> will be
 * 		translated to file <i>Ddth/Commons/ClassDefaultClassNameTranslator.php</i>
 * </ul>
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
final class Ddth_Commons_DefaultClassNameTranslator implements Ddth_Commons_IClassNameTranslator {
    private static $instance;

    private function __construct() {
        //singleton
    }

    /**
     * Gets an instance of Ddth_Commons_DefaultClassNameTranslator class.
     *
     * @return Ddth_Commons_DefaultClassNameTranslator
     */
    public static function getInstance() {
        if ( !is_object(Ddth_Commons_DefaultClassNameTranslator::$instance) ) {
            Ddth_Commons_DefaultClassNameTranslator::$instance =
            new Ddth_Commons_DefaultClassNameTranslator();
        }
        return Ddth_Commons_DefaultClassNameTranslator::$instance;
    }

    /**
     * @see Ddth_Commons_IClassNameTranslator::translateClassNameToFileName()
     */
    public function translateClassNameToFileName($className) {
        $tokens = explode("_", $className);
        $fileName = "";
        $n = count($tokens);
        for ( $i = 0 ; $i < $n-1; $i++ ) {
            $fileName .= $tokens[$i] . '/';
        }
        $fileName .= "Class" . $tokens[$n-1] . '.php';
        return $fileName;
    }
}
?>
