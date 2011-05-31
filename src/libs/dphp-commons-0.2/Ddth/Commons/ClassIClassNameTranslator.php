<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Class-name to physical file name translator.
 *
 * LICENSE: See the included license.txt file for detail.
 * 
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * Provides a mechanism to translate class name to physical file name
 * on disk, available for use with {@link http://www.php.net/include/ include()},
 * {@link http://www.php.net/include_once/ include_once()},
 * {@link http://www.php.net/require/ require()}, and
 * {@link http://www.php.net/require_once/ require_once()} methods.
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIClassNameTranslator.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Class-name to physical file name translator.
 *
 * This interface provides a mechanism to translate class name to physical file name
 * on disk, available for use with {@link http://www.php.net/include/ include()},
 * {@link http://www.php.net/include_once/ include_once()},
 * {@link http://www.php.net/require/ require()}, and
 * {@link http://www.php.net/require_once/ require_once()} methods.
 *
 * @package     Commons
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since       Class available since v0.1
 */
interface Ddth_Commons_IClassNameTranslator {
    /**
     * Translates a class name to physical file name on disk.
     *
     * @param string $className
     * @return string file name on disk available for including.
     */
    public function translateClassNameToFileName($className);
}
?>
