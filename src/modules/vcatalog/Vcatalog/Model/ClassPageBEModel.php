<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */
/**
 * Model object: PageBE.
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
 * Model object: PageBE.
 *
 * @package Vcatalog
 * @subpackage Model
 * @author Thanh Ba Nguyen <btnguyen2k@gmail.com>
 * @since Class available since v0.1
 */
class Vcatalog_Model_PageBEModel extends Quack_Model_BaseModelObj {

    public static function createModelObj($pageObj) {
        if ($pageObj instanceof Quack_Bo_Page_BoPage) {
            return new Vcatalog_Model_PageBEModel($pageObj);
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

    private $urlDelete = NULL;
    private $urlEdit = NULL;
    private $urlMoveUp = NULL;
    private $urlMoveDown = NULL;
    private $urlView = NULL;
    private $urlPin = NULL;
    private $urlUnpin = NULL;

    public function getOnMenu() {
        return PAGE_ATTR_ONMENU == ($this->getTargetObject()->getAttr() & PAGE_ATTR_ONMENU);
    }

    public function isOnMenu() {
        return PAGE_ATTR_ONMENU == ($this->getTargetObject()->getAttr() & PAGE_ATTR_ONMENU);
    }

    /**
     * Gets the URL to delete the page.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $vparams = Array('deletePage', $this->getTargetObject()->getId());
            $this->urlDelete = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlDelete;
    }

    /**
     * Gets the URL to edit the page.
     *
     * @return string
     */
    public function getUrlEdit() {
        if ($this->urlEdit === NULL) {
            $vparams = Array('editPage', $this->getTargetObject()->getId());
            $this->urlEdit = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlEdit;
    }

    /**
     * Gets the URL to move the page down.
     *
     * @return string
     */
    public function getUrlMoveDown() {
        if ($this->urlMoveDown === NULL) {
            $vparams = Array('movePageDown', $this->getTargetObject()->getId());
            $this->urlMoveDown = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlMoveDown;
    }

    /**
     * Gets the URL to move the page up.
     *
     * @return string
     */
    public function getUrlMoveUp() {
        if ($this->urlMoveUp === NULL) {
            $vparams = Array('movePageUp', $this->getTargetObject()->getId());
            $this->urlMoveUp = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlMoveUp;
    }

    /**
     * Gets the URL to view the page.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $vparams = Array('..', '..', 'index.php', 'page', $this->getTargetObject()->getId());
            $this->urlView = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlView;
    }

    /**
     * Gets the URL to "pin" the page.
     *
     * @return string
     */
    public function getUrlPin() {
        if ($this->urlPin === NULL) {
            $vparams = Array('pinPage', $this->getTargetObject()->getId());
            $this->urlPin = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlPin;
    }

    /**
     * Gets the URL to "unpin" the page.
     *
     * @return string
     */
    public function getUrlUnpin() {
        if ($this->urlUnpin === NULL) {
            $vparams = Array('unpinPage', $this->getTargetObject()->getId());
            $this->urlUnpin = Quack_Util_UrlCreator::createUri($_SERVER['SCRIPT_NAME'], $vparams);
        }
        return $this->urlUnpin;
    }
}
