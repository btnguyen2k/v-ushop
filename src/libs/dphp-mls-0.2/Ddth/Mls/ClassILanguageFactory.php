<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Factory to create language packs (objects of type {@link Ddth_Mls_ILanguage}).
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassILanguageFactory.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Factory to create language packs (objects of type {@link Ddth_Mls_ILanguage}).
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Mls_ILanguageFactory {

    /**
     * Gets a language pack.
     *
     * @param string $name name of the language pack to get
     * @return Ddth_Mls_ILanguage
     */
    public function getLanguage($name);

    /**
     * Gets names of available language packs as an array.
     *
     * @return Array
     */
    public function getLanguageNames();

    /**
     * Initializes the factory.
     *
     * @param Array $config see {@link Ddth_Mls_AbstractLanguageFactory::getInstance()}
     */
    public function init($config);
}
?>
