<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: Page.
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
 * Model object: Page.
 *
 * @package Vushop
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vushop_Model_PageModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($pageObj) {
        if ($pageObj instanceof Quack_Bo_Page_BoPage) {
            return new Vushop_Model_PageModel($pageObj);
        }
        if (is_array($pageObj)) {
            $result = Array();
            foreach ($pageObj as $obj) {
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

    public function getOnMenu() {
        return PAGE_ATTR_ONMENU == ($this->getTargetObject()->getAttr() & PAGE_ATTR_ONMENU);
    }

    public function isOnMenu() {
        return PAGE_ATTR_ONMENU == ($this->getTargetObject()->getAttr() & PAGE_ATTR_ONMENU);
    }

    /**
     * Gets the URL to view the page.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $vparams = Array('page', $this->getTargetObject()->getId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }
}
