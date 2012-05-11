<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: Ads.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Vcatalog
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since File available since v0.1
 */

/**
 * Model object: Ads.
 *
 * @package Vcatalog
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vcatalog_Model_AdsModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($adsObj) {
        if ($adsObj instanceof Vcatalog_Bo_TextAds_BoAds) {
            return new Vcatalog_Model_AdsModel($adsObj);
        }
        if (is_array($adsObj)) {
            $result = Array();
            foreach ($adsObj as $obj) {
                $model = self::createModelObj($obj);
                if ($model !== NULL) {
                    $result[] = $model;
                }
            }
            return $result;
        }
        return NULL;
    }

    private $urlView = NULL;

    /**
     * Gets the URL to view the ads.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $vparams = Array('ads', $this->getTargetObject()->getId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }
}
