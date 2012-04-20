<?php
class Vcatalog_Bo_TextAds_BoAds extends Quack_Bo_BaseBo {

    const COL_ID = 'adsId';
    const COL_TITLE = 'adsTitle';
    const COL_URL = 'adsUrl';
    const COL_CLICKS = 'adsClicks';
    const COL_TIMESTAMP = 'adsTimestamp';

    private $id, $title, $url, $clicks, $timestamp;

    /*
     * (non-PHPdoc) @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_TITLE => Array('title'),
                self::COL_URL => Array('url'),
                self::COL_CLICKS => Array('clicks', self::TYPE_INT),
                self::COL_TIMESTAMP => Array('timestamp'));
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getUrl() {
        return $this->url;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function getClicks() {
        return $this->clicks;
    }

    public function setClicks($clicks) {
        $this->clicks = $clicks;
    }

    public function getTimestamp() {
        return $this->timestamp;
    }

    public function setTimestamp($timestamp) {
        $this->timestamp = $timestamp;
    }
}