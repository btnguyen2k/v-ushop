<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Dzit's constants.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassConstants.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since       File available since v0.2
 */

/**
 * Dzit's constants.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_Constants {
    /**
     * Url parameter (GET method): module name.
     *
     * @var string
     */
    const URL_PARAM_MODULE = 'm';

    /**
     * Url parameter (GET method): action name.
     *
     * @var string
     */
    const URL_PARAM_ACTION = 'a';
    
    /**
     * Name of the session that holds name of the language pack.
     * 
     * @var string
     */
    const SESSION_LANGUAGE_NAME = 'Dzit_Language';
    
    /**
     * Name of the session that holds name of the template pack.
     * 
     * @var string
     */
    const SESSION_TEMPLATE_PACK = 'Dzit_Template';
}
?>
