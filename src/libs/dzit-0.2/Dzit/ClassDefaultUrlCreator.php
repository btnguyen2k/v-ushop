<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Default implementation of {@link Dzit_IUrlCreator}.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package     Dzit
 * @author      Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version     $Id: ClassDefaultUrlCreator.php 53 2011-01-06 15:47:22Z btnguyen2k $
 * @since      	File available since v0.2
 */

/**
 * Default implementation of {@link Dzit_IUrlCreator}.
 *
 * @package    	Dzit
 * @author     	Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since      	Class available since v0.2
 */
class Dzit_DefaultUrlCreator implements Dzit_IUrlCreator {
    /**
     * {@see Dzit_IUrlCreator::createUrl()}
     */
    public function createUrl($params) {
        $script = isset($params[self::PARAM_SCRIPT_NAME]) ? $params[self::PARAM_SCRIPT_NAME] : NULL;
        if ($script === NULL || trim($script) === '') {
            $script = $_SERVER['SCRIPT_NAME'];
        } else {
            $script = trim($script);
        }
        $url = $script;

        $module = isset($params[self::PARAM_MODULE]) ? $params[self::PARAM_MODULE] : NULL;
        if ($module !== NULL && trim($module) !== '') {
            $url .= "/$module";
            $action = isset($params[self::PARAM_ACTION]) ? $params[self::PARAM_ACTION] : NULL;
            if ($action !== NULL && trim($action) !== '') {
                $url .= "/$action";
            }
        }

        $pathInfoParams = isset($params[self::PARAM_PATH_INFO_PARAMS]) ? $params[self::PARAM_PATH_INFO_PARAMS] : Array();
        if (!is_array($pathInfoParams)) {
            $pathInfoParams = Array();
        }

        $queryStrParams = isset($params[self::PARAM_QUERY_STRING_PARAMS]) ? $params[self::PARAM_QUERY_STRING_PARAMS] : Array();
        if (!is_array($queryStrParams)) {
            $queryStrParams = Array();
        }

        if (count($pathInfoParams) > 0) {
            foreach ($pathInfoParams as $param) {
                $url .= "/$param";
            }
        }

        if (count($queryStrParams) > 0) {
            $url .= '?';
            foreach ($queryStrParams as $name => $value) {
                $url .= "$name=$value&";
            }
            //remove the trailing character &
            $url = substr($url, 0, -1);
        }

        $fullUrl = isset($params[self::PARAM_FULL_URL]) ? TRUE : FALSE;
        $forceHttps = isset($params[self::PARAM_FORCE_HTTPS]) ? TRUE : FALSE;

        if ($fullUrl || $forceHttps) {
            $httpHost = $_SERVER["HTTP_HOST"];
            if ($forceHttps && !isset($_SERVER['HTTPS'])) {
                //the current request is not https!
                $tokens = explode(':', $httpHost);
                $httpHost = $tokens[0];
                if (isset($params[self::PARAM_HTTPS_PORT]) && is_numeric(self::PARAM_HTTPS_PORT)) {
                    $httpHost .= ':' . $params[self::PARAM_HTTPS_PORT];
                }
            }
            if ($url[0] !== '/') {
                $url = "/$url";
            }
            $url = $httpHost . $url;
            if ($forceHttps) {
                $url = "https://$url";
            } else {
                $url = isset($_SERVER['HTTPS']) ? "https://$url" : "http://$url";
            }
        }
        return $url;
    }
}
?>