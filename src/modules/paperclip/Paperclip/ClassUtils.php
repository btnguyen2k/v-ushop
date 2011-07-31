<?php
class Paperclip_Utils {

    private static function getDao($name) {
        return Ddth_Dao_BaseDaoFactory::getInstance()->getDao($name);
    }

    /**
     * Gets an attached image's dimensions (width and height).
     *
     * @param string $id
     * @param Array first element is image's width, second image is image's height
     */
    public static function getImageDemensions($id) {
        $dao = self::getDao(DAO_PAPERCLIP);
        $item = $dao->getAttachment($id);
        return $item !== NULL ? Array($item->getImgWidth(), $item->getImgheight()) : Array(0, 0);
    }

    /**
     * Gets an attached image's width.
     *
     * @param string $id
     * @param int
     */
    public static function getImageWidth($id) {
        $dim = self::getImageDemensions($id);
        return $dim[0];
    }

    /**
     * Gets an attached image's height.
     *
     * @param string $id
     * @param int
     */
    public static function getImageHeight($id) {
        $dim = self::getImageDemensions($id);
        return $dim[1];
    }

    /**
     * Creates a URL to view a paperclip item as thumbnail.
     *
     * @param string $id
     * @param boolean $onetimeView set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlThumbnail($id, $onetimeView = FALSE) {
        $dao = self::getDao(DAO_PAPERCLIP);
        $item = $dao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView);
        $viewKey = md5("thumbnail$id");
        $_SESSION["PAPERCLIP_$viewKey"] = new Commons_Utils_SessionWrapper($viewEntry);
        return $_SERVER['SCRIPT_NAME'] . '/paperclip/thumbnail/' . $viewKey;
    }

    /**
     * Creates a URL to view a paperclip item.
     *
     * @param string $id
     * @param boolean $onetimeView set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlView($id, $onetimeView = FALSE) {
        $dao = self::getDao(DAO_PAPERCLIP);
        $item = $dao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView);
        $viewKey = md5("thumbnail$id");
        $_SESSION["PAPERCLIP_$viewKey"] = new Commons_Utils_SessionWrapper($viewEntry);
        return $_SERVER['SCRIPT_NAME'] . '/paperclip/view/' . $viewKey;
    }

    /**
     * Creates a URL to download a paperclip item.
     *
     * @param string $id
     * @param boolean $onetimeView set to TRUE to make the URL one-time-use
     * @return string the URL or NULL
     */
    public static function createUrlDownload($id, $onetimeView = FALSE) {
        $dao = self::getDao(DAO_PAPERCLIP);
        $item = $dao->getAttachment($id);
        if ($item === NULL) {
            return NULL;
        }
        $viewEntry = Array('id' => $id, 'onetime' => $onetimeView);
        $viewKey = md5("download$id");
        $_SESSION["PAPERCLIP_$viewKey"] = new Commons_Utils_SessionWrapper($viewEntry);
        return $_SERVER['SCRIPT_NAME'] . '/paperclip/download/' . $viewKey;
    }
}
