<?php
abstract class Paperclip_Bo_BasePaperclipDao extends Quack_Bo_BaseDao implements
        Paperclip_Bo_IPaperclipDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IPaperclipDao';
    }

    protected function createCacheKeyPcId($pcId) {
        return $pcId;
    }

    /**
     * Invalidates the cache due to change.
     *
     * @param Paperclip_Bo_BoPaperclip $user
     */
    protected function invalidateCache($pc = NULL) {
        if ($pc !== NULL) {
            $pcId = $pc->getId();
            $this->deleteFromCache($this->createCacheKeyPcId($pcId));
        }
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::createAttachment()
     */
    public function createAttachment($pathToFileContent, $filename, $mimeType, $isDraft = FALSE, $thumbnail = NULL) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);

        $id = uniqid('', TRUE);
        $timestamp = time();
        $filesize = filesize($pathToFileContent);
        $imgSource = Commons_Utils_ImageUtils::createImageSource($pathToFileContent);
        $filecontent = Commons_Utils_FileUtils::getFileContent($pathToFileContent);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $id,
                Paperclip_Bo_BoPaperclip::COL_FILENAME => $filename,
                Paperclip_Bo_BoPaperclip::COL_FILESIZE => $filesize,
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT => $filecontent,
                Paperclip_Bo_BoPaperclip::COL_IMG_WIDTH => $imgSource != NULL ? $imgSource[0] : 0,
                Paperclip_Bo_BoPaperclip::COL_IMG_HEIGHT => $imgSource != NULL ? $imgSource[1] : 0,
                Paperclip_Bo_BoPaperclip::COL_THUMBNAIL => $thumbnail,
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE => $mimeType,
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP => $timestamp,
                Paperclip_Bo_BoPaperclip::COL_IS_DRAFT => $isDraft ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);

        return $this->getAttachment($id);
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::deleteAttachment()
     */
    public function deleteAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $attachment->getId());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::getAttachment()
     */
    public function getAttachment($id) {
        if ($id === NULL) {
            return NULL;
        }
        $cacheKey = $this->createCacheKeyPcId($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Paperclip_Bo_BoPaperclip();
                $result->populate($rows[0]);
                $this->putToCache($cacheKey, $result);
            }
        }
        $timestamp = time();
        if ($result !== NULL && $result->getTimestamp() + 24 * 3600 < $timestamp) {
            //update timestamp if needed
            $result->setTimestamp($timestamp);
            $this->updateAttachment($result);
            $this->putToCache($cacheKey, $result);
        }
        return $result;
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::updateAttachment()
     */
    public function updateAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Paperclip_Bo_BoPaperclip::COL_ID => $attachment->getId(),
                Paperclip_Bo_BoPaperclip::COL_FILENAME => $attachment->getFilename(),
                Paperclip_Bo_BoPaperclip::COL_FILESIZE => $attachment->getFilesize(),
                Paperclip_Bo_BoPaperclip::COL_FILECONTENT => $attachment->getFilecontent(),
                Paperclip_Bo_BoPaperclip::COL_IMG_WIDTH => $attachment->getImgWidth(),
                Paperclip_Bo_BoPaperclip::COL_IMG_HEIGHT => $attachment->getImgHeight(),
                Paperclip_Bo_BoPaperclip::COL_THUMBNAIL => $attachment->getThumbnail(),
                Paperclip_Bo_BoPaperclip::COL_MIMETYPE => $attachment->getMimetype(),
                Paperclip_Bo_BoPaperclip::COL_TIMESTAMP => $attachment->getTimestamp(),
                Paperclip_Bo_BoPaperclip::COL_IS_DRAFT => $attachment->isDraft() ? 1 : 0);
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($attachment);
    }
}
