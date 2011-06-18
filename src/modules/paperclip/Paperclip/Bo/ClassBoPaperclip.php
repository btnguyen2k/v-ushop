<?php
class Paperclip_Bo_BoPaperclip extends Commons_Bo_BaseBo {

    const COL_ID = 'pid';
    const COL_FILENAME = 'pfilename';
    const COL_FILESIZE = 'pfilesize';
    const COL_FILECONTENT = 'pfilecontent';
    const COL_THUMBNAIL = 'pthumbnail';
    const COL_MIMETYPE = 'pmimetype';
    const COL_TIMESTAMP = 'ptimestamp';

    private $id;
    private $filename;
    private $filesize;
    private $filecontent;
    private $thumbnail;
    private $mimetype;
    private $timestamp;

    /* (non-PHPdoc)
     * @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_FILENAME => Array('filename'),
                self::COL_FILESIZE => Array('filesize', self::TYPE_INT),
                self::COL_FILECONTENT => Array('filecontent'),
                self::COL_THUMBNAIL => Array('thumbnail'),
                self::COL_MIMETYPE => Array('mimetype'),
                self::COL_TIMESTAMP => Array('timestamp', self::TYPE_INT));
    }

    /**
     * Getter for $id.
     *
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Setter for $id.
     *
     * @param string $id
     */
    public function setId($id) {
        $this->id = $id;
    }

    /**
     * Getter for $filename.
     *
     * @return string
     */
    public function getFilename() {
        return $this->filename;
    }

    /**
     * Setter for $filename.
     *
     * @param string $filename
     */
    public function setFilename($filename) {
        $this->filename = $filename;
    }

    /**
     * Getter for $filesize.
     *
     * @return int
     */
    public function getFilesize() {
        return $this->filesize;
    }

    /**
     * Setter for $filesize.
     *
     * @param int $filesize
     */
    public function setFilesize($filesize) {
        $this->filesize = $filesize;
    }

    /**
     * Getter for $filecontent.
     *
     * @return string
     */
    public function getFilecontent() {
        return $this->filecontent;
    }

    /**
     * Setter for $filecontent.
     *
     * @param string $filecontent
     */
    public function setFilecontent($filecontent) {
        $this->filecontent = $filecontent;
    }

    /**
     * Getter for $thumbnail.
     *
     * @return string
     */
    public function getThumbnail() {
        return $this->thumbnail;
    }

    /**
     * Setter for $thumbnail.
     *
     * @param string $thumbnail
     */
    public function setThumbnail($thumbnail) {
        $this->thumbnail = $thumbnail;
    }

    /**
     * Getter for $mimetype.
     *
     * @return string
     */
    public function getMimetype() {
        return $this->mimetype;
    }

    /**
     * Setter for $mimetype.
     *
     * @param string $mimetype
     */
    public function setMimetype($mimetype) {
        $this->mimetype = $mimetype;
    }

    /**
     * Getter for $timestamp.
     *
     * @return int
     */
    public function getTimestamp() {
        return $this->timestamp;
    }

    /**
     * Setter for $timestamp.
     *
     * @param int $timestamp
     */
    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }

}
