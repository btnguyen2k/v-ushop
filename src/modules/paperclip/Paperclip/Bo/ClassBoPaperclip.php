<?php
class Paperclip_Bo_BoPaperclip extends Commons_Bo_BaseBo {

    const COL_ID = 'pcId';
    const COL_FILENAME = 'pcFilename';
    const COL_FILESIZE = 'pcFilesize';
    const COL_FILECONTENT = 'pcFilecontent';
    const COL_THUMBNAIL = 'pcThumbnail';
    const COL_MIMETYPE = 'pcMimeType';
    const COL_TIMESTAMP = 'pcTimestamp';
    const COL_IS_DRAFT = 'pcIsDraft';
    const COL_IMG_WIDTH = 'pcImgWidth';
    const COL_IMG_HEIGHT = 'pcImgHeight';

    private $id;
    private $filename;
    private $filesize;
    private $filecontent;
    private $thumbnail;
    private $mimetype;
    private $timestamp;
    private $isDraft;
    private $imgWidth;
    private $imgHeight;

    /**
     * @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_FILENAME => Array('filename'),
                self::COL_FILESIZE => Array('filesize', self::TYPE_INT),
                self::COL_FILECONTENT => Array('filecontent'),
                self::COL_THUMBNAIL => Array('thumbnail'),
                self::COL_MIMETYPE => Array('mimetype'),
                self::COL_TIMESTAMP => Array('timestamp', self::TYPE_INT),
                self::COL_IS_DRAFT => Array('isDraft', self::TYPE_BOOLEAN),
                self::COL_IMG_WIDTH => Array('imgWidth', self::TYPE_INT),
                self::COL_IMG_HEIGHT => Array('imgHeight', self::TYPE_INT));
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
     * Getter for $imgWidth.
     *
     * @return int
     */
    public function getImgWidth() {
        return $this->imgWidth;
    }

    /**
     * Setter for $imgWidth.
     *
     * @param int $imgWidth
     */
    public function setImgWidth($imgWidth) {
        $this->imgWidth = $imgWidth;
    }

    /**
     * Getter for $imgHeight.
     *
     * @return int
     */
    public function getImgHeight() {
        return $this->imgHeight;
    }

    /**
     * Setter for $imgHeight.
     *
     * @param int $imgHeight
     */
    public function setImgHeight($imgHeight) {
        $this->imgHeight = $imgHeight;
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

    /**
     * Getter for $isDraft.
     *
     * @return boolean
     */
    public function getIsDraft() {
        return $this->isDraft;
    }

    /**
     * Setter for $isDraft.
     *
     * @param boolean $isDraft
     */
    public function setIsDraft($isDraft) {
        $this->isDraft = $isDraft;
    }

    /**
     * Checks if the item is in "draft" state.
     *
     * @return boolean
     */
    public function isDraft() {
        return $this->isDraft;
    }
}
