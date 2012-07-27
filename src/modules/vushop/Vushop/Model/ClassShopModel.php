<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: Shop.
 *
 * LICENSE: See the included license.txt file for detail.
 *
 * COPYRIGHT: See the included copyright.txt file for detail.
 *
 * @package Vushop
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @version $Id: ClassICache.php 251 2010-12-25 19:21:35Z btnguyen2k@gmail.com $
 * @since File available since v0.1
 */

/**
 * Model object: Shop.
 *
 * @package Vushop
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vushop_Model_ShopModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($shopObj) {
        if ($shopObj instanceof Vushop_Bo_Shop_BoShop) {
            return new Vushop_Model_ShopModel($shopObj);
        }
        if (is_array($shopObj)) {
            $result = Array();
            foreach ($shopObj as $obj) {
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
    private $displayName = NULL;
    private $urlProfile = NULL;

    /**
     * Gets the URL to access shop control panel.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
             $vparams = Array('shop', $this->getTargetObject()->getOwnerId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }
    


    /**
     * Gets the URL to access shop's profile control panel.
     *
     * @return string
     */
    public function getUrlProfile() {
        if ($this->urlProfile === NULL) {
            $this->urlProfile = $_SERVER['SCRIPT_NAME'] . '/shopprofile';
        }
        return $this->urlProfile;
    }

    public function getDisplayName() {
        if ($this->displayName === NULL) {
            $fullname = $this->getTargetObject()->getgetTitle();
            $username = $this->getTargetObject()->getUsername();
            if ($fullname === NULL || trim($fullname) === '') {
                $this->displayName = $username;
            } else {
                $this->displayName = trim($fullname);
            }
        }
        return $this->displayName;
    }

    
}
