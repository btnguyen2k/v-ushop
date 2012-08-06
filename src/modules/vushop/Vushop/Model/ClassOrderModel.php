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
class Vushop_Model_OrderBEModel extends Quack_Model_BaseModelObj {
    
    public static function createModelObj($shopObj) {
        if ($shopObj instanceof Vushop_Bo_Order_BoOrder) {
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
    private $urlUpdateStatusCompleted = NULL;
    private $urlUpdateStausNotComplete = NULL;
    private $urlDelete = NULL;
    
    /**
     * Gets the URL to access shop control panel.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $vparams = Array('orderdetail', $this->getTargetObject()->getId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }
    
    /**
     * Gets the URL to update status completed.
     *
     * @return string
     */
    public function getUrlUpdateStatusCompleted() {
        if ($this->urlUpdateStatusCompleted === NULL) {
            $vparams = Array('orderdetail', $this->getTargetObject()->getId(), 'status', true);
            $this->urlUpdateStatusCompleted = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlUpdateStatusCompleted;
    }
    
    /**
     * Gets the URL to update status completed.
     *
     * @return string
     */
    
    public function getUrlUpdateStatusNotComplete() {
        if ($this->urlUpdateStausNotComplete === NULL) {
            $vparams = Array('orderdetail', $this->getTargetObject()->getId(), 'status', false);
            $this->urlUpdateStausNotComplete = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlUpdateStausNotComplete;
    }
   

}
