<?php
class Paperclip_Controller_ViewThumbnailController implements Dzit_IController {
    /**
     * @see Dzit_IController::execute()
     */
    public function execute($module, $action) {
        $dao = Ddth_Dao_BaseDaoFactory::getInstance()->getDao(DAO_PAPERCLIP);
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $viewKey = $requestParser->getPathInfoParam(2);
        $viewValue = Commons_Utils_SessionUtils::getSessionEntry("PAPERCLIP_$viewKey");
        $id = $viewValue !== NULL ? $viewValue['id'] : NULL;
        $item = $dao->getAttachment($id);
        if ($item !== NULL) {
            header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
            header("Expires: Sat, 1 Jan 2011 00:00:00 GMT"); // Date in the past
            header('Content-type: image/jpeg');
            echo $item->getThumbnail();
        }
    }
}