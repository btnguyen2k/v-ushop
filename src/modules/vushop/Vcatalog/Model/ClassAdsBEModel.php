<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: AdsBE.
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
 * Model object: AdsBE.
 *
 * @package Vcatalog
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vcatalog_Model_AdsBEModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($adsObj) {
        if ($adsObj instanceof Vcatalog_Bo_TextAds_BoAds) {
            return new Vcatalog_Model_AdsBEModel($adsObj);
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

    private $urlDelete = NULL;
    private $urlEdit = NULL;
    private $urlMoveUp = NULL;
    private $urlMoveDown = NULL;
    private $urlView = NULL;

    /**
     * Gets the URL to delete the ads.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $vparams = Array('deleteAds', $this->getTargetObject()->getId());
            $this->urlDelete = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlDelete;
    }

    /**
     * Gets the URL to edit the ads.
     *
     * @return string
     */
    public function getUrlEdit() {
        if ($this->urlEdit === NULL) {
            $vparams = Array('editAds', $this->getTargetObject()->getId());
            $this->urlEdit = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlEdit;
    }

    /**
     * Gets the URL to move the ads down.
     *
     * @return string
     */
    public function getUrlMoveDown() {
        if ($this->urlMoveDown === NULL) {
            $vparams = Array('moveAdsDown', $this->getTargetObject()->getId());
            $this->urlMoveDown = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlMoveDown;
    }

    /**
     * Gets the URL to move the ads up.
     *
     * @return string
     */
    public function getUrlMoveUp() {
        if ($this->urlMoveUp === NULL) {
            $vparams = Array('moveAdsUp', $this->getTargetObject()->getId());
            $this->urlMoveUp = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlMoveUp;
    }

    /**
     * Gets the URL to view the ads.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $vparams = Array('..', '..', 'index.php', 'ads', $this->getTargetObject()->getId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }
}
