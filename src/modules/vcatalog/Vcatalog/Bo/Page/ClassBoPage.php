<?php
class Vcatalog_Bo_Page_BoPage extends Commons_Bo_BaseBo {

    const COL_ID = 'pid';
    const COL_POSITION = 'pposition';
    const COL_TITLE = 'ptitle';
    const COL_CONTENT = 'pcontent';
    const COL_ONMENU = 'ponmenu';

    private $id, $position, $title, $content, $onMenu;

    private $urlDelete = NULL;
    private $urlEdit = NULL;
    private $urlMoveUp = NULL;
    private $urlMoveDown = NULL;
    private $urlView = NULL;
    private $urlPin = NULL;
    private $urlUnpin = NULL;

    /* (non-PHPdoc)
     * @see Commons_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id'),
                self::COL_POSITION => Array('position', self::TYPE_INT),
                self::COL_TITLE => Array('title'),
                self::COL_CONTENT => Array('content'),
                self::COL_ONMENU => Array('onMenu', self::TYPE_BOOLEAN));
    }

    /**
     * Gets the URL to delete the page.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $this->urlDelete = $_SERVER['SCRIPT_NAME'] . '/admin/deletePage/' . $this->id;
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
            $this->urlEdit = $_SERVER['SCRIPT_NAME'] . '/admin/editPage/' . $this->id;
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
            $this->urlMoveDown = $_SERVER['SCRIPT_NAME'] . '/admin/movePageDown/' . $this->id;
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
            $this->urlMoveUp = $_SERVER['SCRIPT_NAME'] . '/admin/movePageUp/' . $this->id;
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
            $this->urlView = $_SERVER['SCRIPT_NAME'] . '/page/' . $this->id;
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
            $this->urlPin = $_SERVER['SCRIPT_NAME'] . '/admin/pinPage/' . $this->id;
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
            $this->urlUnpin = $_SERVER['SCRIPT_NAME'] . '/admin/unpinPage/' . $this->id;
        }
        return $this->urlUnpin;
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getPosition() {
        return $this->position;
    }

    public function setPosition($position) {
        $this->position = $position;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getContent() {
        return $this->content;
    }

    public function setContent($content) {
        $this->content = $content;
    }

    public function getOnMenu() {
        return $this->onMenu;
    }

    public function setOnMenu($onMenu) {
        $this->onMenu = $onMenu;
    }
}