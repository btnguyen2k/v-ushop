<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: UserBE.
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
 * Model object: UserBE.
 *
 * @package Vushop
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vushop_Model_UserBEModel extends Vushop_Model_UserModel {
    
    public static function createModelObj($userObj) {
        if ($userObj instanceof Vushop_Bo_User_BoUser) {
            return new Vushop_Model_UserBEModel($userObj);
        }
        if (is_array($userObj)) {
            $result = Array();
            foreach ($userObj as $obj) {
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
    private $urlView = NULL;
    private $urlChangePassword = NULL;
    
    /**
     * Gets the URL to delete the page.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $vparams = Array('deleteUser', $this->getTargetObject()->getId());
            $this->urlDelete = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlDelete;
    }
    
    /**
     * Gets the URL to edit the user.
     *
     * @return string
     */
    public function getUrlEdit() {
        if ($this->urlEdit === NULL) {
            $vparams = Array('editUser', $this->getTargetObject()->getId());
            $this->urlEdit = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlEdit;
    }
    
    /**
     * Gets the URL to edit the user.
     *
     * @return string
     */
    public function getUrlChangePassword() {
        if ($this->urlChangePassword === NULL) {
            $vparams = Array('changePassword', $this->getTargetObject()->getId());
            $this->urlChangePassword = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlChangePassword;
    }
}
