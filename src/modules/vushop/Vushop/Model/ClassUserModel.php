<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: User.
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
 * Model object: User.
 *
 * @package Vushop
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vushop_Model_UserModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($userObj) {
        if ($userObj instanceof Vushop_Bo_User_BoUser) {
            return new Vushop_Model_UserModel($userObj);
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

    private $displayName = NULL;
    private $urlProfile = NULL;

    /**
     * Gets the URL to access user's profile control panel.
     *
     * @return string
     */
    public function getUrlProfile() {
        if ($this->urlProfile === NULL) {
            $this->urlProfile = $_SERVER['SCRIPT_NAME'] . '/profile';
        }
        return $this->urlProfile;
    }

    public function getDisplayName() {
        if ($this->displayName === NULL) {
            $fullname = $this->getTargetObject()->getFullname();
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
