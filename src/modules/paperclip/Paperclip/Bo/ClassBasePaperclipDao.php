<?php
abstract class Paperclip_Bo_BasePaperclipDao extends Commons_Bo_BaseDao implements
        Paperclip_Bo_IPaperclipDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    const CACHE_KEY_PREFIX = 'PAPERCLIP_';

    /**
     * Invalidates the cache due to change.
     *
     * @param Paperclip_Bo_BoPaperclip $attachment
     */
    protected function invalidateCache($attachment = NULL) {
        if ($attachment !== NULL) {
            $attachmentId = $attachment->getId();
            $cacheKey = self::CACHE_KEY_PREFIX . $attachmentId;
            $this->deleteFromCache($cacheKey);
        }
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::createAttachment()
     */
    public function createAttachment($pathToFileContent, $filename, $mimeType, $isDraft = FALSE, $thumbnail = NULL) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $id = uniqid('', TRUE);
        $timestamp = time();
        $filesize = filesize($pathToFileContent);
        $imgSource = Commons_Utils_ImageUtils::createImageSource($pathToFileContent);
        $filecontent = Commons_Utils_FileUtils::getFileContent($pathToFileContent);

        $params = Array('id' => $id,
                'filename' => $filename,
                'filesize' => $filesize,
                'filecontent' => $filecontent,
                'imgWidth' => $imgSource != NULL ? $imgSource[0] : 0,
                'imgHeight' => $imgSource != NULL ? $imgSource[1] : 0,
                'thumbnail' => $thumbnail,
                'mimetype' => $mimeType,
                'timestamp' => $timestamp,
                'isDraft' => $isDraft ? 1 : 0);
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();

        return $this->getAttachment($id);
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::deleteAttachment()
     */
    public function deleteAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $attachment->getId());
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
        $this->invalidateCache($attachment);
    }

    /**
     * @see Paperclip_Bo_IPaperclipDao::getAttachment()
     */
    public function getAttachment($id) {
        if ($id === NULL) {
            return NULL;
        }
        $cacheKey = self::CACHE_KEY_PREFIX . $id;
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {

            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $sqlConn = $this->getConnection();

            $params = Array('id' => $id);
            $rs = $sqlStm->execute($sqlConn->getConn(), $params);
            $rs = $this->fetchResultAssoc($rs);
            $result = NULL;
            if ($rs !== NULL && $rs !== FALSE) {
                $result = new Paperclip_Bo_BoPaperclip();
                $result->populate($rs);
                $this->putToCache($cacheKey, $result);
            }
            $this->closeConnection();
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
        $sqlConn = $this->getConnection();

        $params = Array('id' => $attachment->getId(),
                'filename' => $attachment->getFilename(),
                'filesize' => $attachment->getFilesize(),
                'filecontent' => $attachment->getFilecontent(),
                'imgWidth' => $attachment->getImgWidth(),
                'imgHeight' => $attachment->getImgHeight(),
                'thumbnail' => $attachment->getThumbnail(),
                'mimetype' => $attachment->getMimetype(),
                'timestamp' => $attachment->getTimestamp(),
                'isDraft' => $attachment->isDraft() ? 1 : 0);
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
        $this->invalidateCache($attachment);
    }
}
