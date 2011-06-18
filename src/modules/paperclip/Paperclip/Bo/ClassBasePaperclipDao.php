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

    private function makeThumbnail() {
        return NULL;
    }

    /* (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::createAttachment()
     */
    public function createAttachment($pathToFileContent, $filename, $mimeType) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $id = uniqid('', TRUE);
        $timestamp = time();
        $filesize = filesize($pathToFileContent);
        $fp = fopen($pathToFileContent, 'rb');
        $filecontent = fread($fp, $filesize);
        fclose($fp);
        $thumbnail = $this->makeThumbnail($pathToFileContent, $mimeType);

        $params = Array('id' => $id,
                'filename' => $filename,
                'filesize' => $filesize,
                'filecontent' => $filecontent,
                'thumbnail' => $thumbnail,
                'mimetype' => $mimeType,
                'timestamp' => $timestamp);
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();

        return $this->getAttachment($id);
    }

    /* (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::deleteAttachment()
     */
    public function deleteAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $attachment->getId());
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
    }

    /* (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::getAttachment()
     */
    public function getAttachment($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $rs = $this->fetchResultAssoc($rs);
        $result = NULL;
        if ($rs !== NULL && $rs !== FALSE) {
            $result = new Paperclip_Bo_BoPaperclip();
            $result->populate($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /* (non-PHPdoc)
     * @see Paperclip_Bo_IPaperclipDao::updateAttachment()
     */
    public function updateAttachment($attachment) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $attachment->getId(),
                'filename' => $attachment->getFilename(),
                'filesize' => $attachment->getFilesize(),
                'filecontent' => $attachment->getFilecontent(),
                'thumbnail' => $attachment->getThumbnail(),
                'mimetype' => $attachment->getMimetype(),
                'timestamp' => $attachment->getTimestamp());
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
    }
}
