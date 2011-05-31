<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Represents a language pack.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Mls
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassILanguage.php 260 2011-01-04 04:10:06Z btnguyen2k@gmail.com $
 * @since       File available since v0.1
 */

/**
 * Represents a language pack.
 *
 * This interface represents a single language pack.
 *
 * @package    	Mls
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.1
 */
interface Ddth_Mls_ILanguage {

    const CONF_DISPLAY_NAME = 'displayName';
    const CONF_LOCALE = 'locale';
    const CONF_DESCRIPTION = 'description';

    /**
     * Gets a text message from this language.
     *
     * Note: the official type of the argument $replacements is an array.
     * Implementations of this interface, however, can take advantage of PHP's
     * variable arguments support to take in any number of single replacement.
     *
     * @param string key of the text message to get
     * @param Array() replacements for place-holders within the text message
     * @return string
     */
    public function getMessage($key, $replacements = NULL);

    /**
     * Gets description of the language pack.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Gets display name of the language pack.
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Gets the locale associated with the language pack.
     *
     * @return string
     */
    public function getLocale();

    /**
     * Gets name of the language pack.
     *
     * @return string
     */
    public function getName();

    /**
     * Initializes the language pack.
     *
     * @param string $langName name of the language pack
     * @param Array $config
     */
    public function init($langName, $config);
}
?>
