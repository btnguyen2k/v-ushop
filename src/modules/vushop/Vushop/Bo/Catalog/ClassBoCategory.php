<?php
class Vushop_Bo_Catalog_BoCategory extends Quack_Bo_BaseBo {

    /* Database table columns */
    const COL_ID = 'cat_id';
    const COL_POSITION = 'cat_position';
    const COL_PARENT_ID = 'cat_parent_id';
    const COL_TITLE = 'cat_title';
    const COL_DESCRIPTION = 'cat_desc';
    const COL_IMAGE_ID = 'cat_image_id';

    private $id, $position, $parentId, $title, $description, $imageId;
    private $children = Array();

    private $urlDelete = NULL;
    private $urlEdit = NULL;
    private $urlMoveUp = NULL;
    private $urlMoveDown = NULL;
    private $urlView = NULL;
    private $urlThumbnail = NULL;

    /**
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id', self::TYPE_INT),
                self::COL_POSITION => Array('position', self::TYPE_INT),
                self::COL_PARENT_ID => Array('parentId', self::TYPE_INT),
                self::COL_TITLE => Array('title'),
                self::COL_DESCRIPTION => Array('description'),
                self::COL_IMAGE_ID => Array('imageId'));
    }

    /**
     * Gets the URL to delete the category.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $this->urlDelete = $_SERVER['SCRIPT_NAME'] . '/deleteCategory/' . $this->id . '/';
        }
        return $this->urlDelete;
    }

    /**
     * Gets the URL to edit the category.
     *
     * @return string
     */
    public function getUrlEdit() {
        if ($this->urlEdit === NULL) {
            $this->urlEdit = $_SERVER['SCRIPT_NAME'] . '/editCategory/' . $this->id . '/';
        }
        return $this->urlEdit;
    }

    /**
     * Gets the URL to move the category down.
     *
     * @return string
     */
    public function getUrlMoveDown() {
        if ($this->urlMoveDown === NULL) {
            $this->urlMoveDown = $_SERVER['SCRIPT_NAME'] . '/moveCategoryDown/' . $this->id . '/';
        }
        return $this->urlMoveDown;
    }

    /**
     * Gets the URL to move the category up.
     *
     * @return string
     */
    public function getUrlMoveUp() {
        if ($this->urlMoveUp === NULL) {
            $this->urlMoveUp = $_SERVER['SCRIPT_NAME'] . '/moveCategoryUp/' . $this->id . '/';
        }
        return $this->urlMoveUp;
    }

    /**
     * Gets the URL to view the category.
     *
     * @return string
     */
    public function getUrlView() {
        if ($this->urlView === NULL) {
            $this->urlView = $_SERVER['SCRIPT_NAME'] . '/category/' . $this->id . '/';
        }
        return $this->urlView;
    }

    /**
     * Gets the URL to view the category's image as thumbnail.
     *
     * @return string
     */
    public function getUrlThumbnail() {
        if ($this->urlThumbnail === NULL) {
            $this->urlThumbnail = Paperclip_Utils::createUrlThumbnail($this->imageId);
            if ($this->urlThumbnail === NULL) {
                $this->urlThumbnail = '';
            }
        }
        return $this->urlThumbnail;
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

    public function getParentId() {
        return $this->parentId;
    }

    public function setParentId($parentId) {
        $this->parentId = $parentId;
    }

    public function getTitle() {
        return $this->title;
    }

    public function getTitleForDisplay($maxLength = 20) {
        if ($maxLength < 10) {
            $maxLength = 10;
        }
        if (mb_strlen($this->title) <= $maxLength) {
            return $this->title;
        }
        return mb_substr($this->title, 0, $maxLength - 3) . '...';
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getImageId() {
        return $this->imageId;
    }

    public function setImageId($imageId) {
        $this->imageId = $imageId;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
        if (!is_array($this->children)) {
            $this->children = Array();
        }
    }

    /**
     * Adds a child category.
     *
     * @param Vushop_Bo_Catalog_BoCategory $child
     */
    public function addChild($child) {
        $this->children[] = $child;
    }
}