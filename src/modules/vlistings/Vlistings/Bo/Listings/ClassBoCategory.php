<?php
class Vlistings_Bo_Listings_BoCategory {
    private $id, $position, $parentId, $title, $description;
    private $children = Array();

    private $urlDelete = NULL;
    private $urlEdit = NULL;
    private $urlMoveUp = NULL;
    private $urlMoveDown = NULL;
    private $urlView = NULL;

    /**
     * Gets the URL to delete the category.
     *
     * @return string
     */
    public function getUrlDelete() {
        if ($this->urlDelete === NULL) {
            $this->urlDelete = $_SERVER['SCRIPT_NAME'] . '/admin/deleteCategory/' . $this->id . '/';
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
            $this->urlEdit = $_SERVER['SCRIPT_NAME'] . '/admin/editCategory/' . $this->id . '/';
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
            $this->urlMoveDown = $_SERVER['SCRIPT_NAME'] . '/admin/moveCategoryDown/' . $this->id . '/';
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
            $this->urlMoveUp = $_SERVER['SCRIPT_NAME'] . '/admin/moveCategoryUp/' . $this->id . '/';
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
     * Populates the business object with a record set.
     *
     * @param Array $rs
     */
    public function populate($rs) {
        $id = $rs['id'];
        $position = $rs['position'];
        $parentId = $rs['parentId'];
        $title = $rs['title'];
        $desc = $rs['description'];
        $this->setId((int)$id);
        $this->setPosition((int)$position);
        $this->setParentId(isset($parentId) ? (int)$parentId : NULL);
        $this->setTitle($title);
        $this->setDescription($desc);
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

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    public function getChildren() {
        return $this->children;
    }

    public function setChildren($children) {
        $this->children = $children;
    }

    /**
     * Adds a child category.
     *
     * @param Vlistings_Bo_Listings_BoCategory $child
     */
    public function addChild($child) {
        $this->children[] = $child;
    }
}