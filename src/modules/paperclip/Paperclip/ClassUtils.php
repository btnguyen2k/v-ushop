<?php
class Paperclip_Utils {

    private static function getDao($name) {
        return Ddth_Dao_BaseDaoFactory::getInstance()->getDao($name);
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
        $viewKey = uniqid('', TRUE);
        $_SESSION["PAPERCLIP_$viewKey"] = new Commons_Utils_SessionWrapper($viewEntry);
        return $_SERVER['SCRIPT_NAME'] . '/paperclip/thumbnail/' . $viewKey;
    }
}
