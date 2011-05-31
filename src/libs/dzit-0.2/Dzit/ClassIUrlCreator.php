<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * URL generator.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassIUrlCreator.php 40 2010-12-23 19:29:19Z btnguyen2k $
 * @since      	File available since v0.2
 */

/**
 * URL generator.
 *
 * This interface provides centralized APIs for Dzit-based application to generate
 * URLs. It is recommended that application uses this interface to generate URLs that
 * invokes server-side actions.
 *
 * @package    	Dzit
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
interface Dzit_IUrlCreator {

    const DEFAULT_HTTPS_PORT = 443;

    const PARAM_MODULE = 'module';
    const PARAM_ACTION = 'action';
    const PARAM_PATH_INFO_PARAMS = 'pathInfoParams';
    const PARAM_QUERY_STRING_PARAMS = 'queryStrParams';
    const PARAM_SCRIPT_NAME = 'scriptName';
    const PARAM_FULL_URL = 'fullUrl';
    const PARAM_FORCE_HTTPS = 'forceHttps';
    const PARAM_HTTPS_PORT = 'httpsPort';

    /**
     * Creates a URL. This method takes an associative array as its parameter. The array
     * contains the following base entries:
     * <ul>
     *     <li><b>module</b> (string): the server module to invoke.</li>
     *     <li><b>action</b> (string): the server action to invoke. Note: if "module" is not
     *     specified then "action" is ignored.</li>
     *     <li><b>pathInfoParams</b> (index array, i.e. [value1, value2, value2]): parameters
     *     to be passed via PATH_INFO.</li>
     *     <li><b>queryStrParams</b> (associative array, i.e ['name1'=>value1,
     *     'name2'=>value2, 'name3'=>value2]): parameters to be passed via query string.</li>
     *     <li><b>scriptName</b> (string): (optional) name of the server script, if different
     *     from the currently executing one.</li>
     *     <li><b>fullUrl</b> (bool): indicates whether the full URL (i.e. absolute URL that includes the
     *     schema and domain: http://domain) or just relative URL is created.</li>
     *     <li><b>forceHttps</b> (bool): indicates whether the created URL must be https. Note: "forceHttps"
     *     implies "fullUrl".</li>
     *     <li><b>httpsPort</b> (int): the server's port number for https. Note: usable only when
     *     "forceHttps" is true</li>
     *     <li>
     * </ul>
     */
    public function createUrl($params);
}
?>