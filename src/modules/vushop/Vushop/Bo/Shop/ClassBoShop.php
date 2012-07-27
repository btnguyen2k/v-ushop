<?php
class Vushop_Bo_Shop_BoShop extends Quack_Bo_BaseBo {

    /* Database table columns: virtual columns */
    const COL_OWNER_ID = 'owner_id';
    const COL_POSITION = 'shop_position';
    const COL_TITLE = 'shop_title';
    const COL_DESC = 'shop_description';
    const COL_IMAGE_ID = 'image_id';

    private $ownerId, $position, $title, $description, $imageId;

    /*
     * (non-PHPdoc) @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_OWNER_ID => Array('ownerId', self::TYPE_INT),
                self::COL_POSITION => Array('position', self::TYPE_INT),
                self::COL_TITLE => Array('title'),
                self::COL_DESC => Array('description'),
                self::COL_IMAGE_ID => Array('imageId'));
    }

    /**
     * Getter for $ownerId.
     *
     * @return field_type
     */
    public function getOwnerId() {
        return $this->ownerId;
    }

    /**
     * Getter for $position.
     *
     * @return field_type
     */
    public function getPosition() {
        return $this->position;
    }

    /**
     * Getter for $title.
     *
     * @return field_type
     */
    public function getTitle() {
        return $this->title;
    }

    /**
     * Getter for $description.
     *
     * @return field_type
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Getter for $imageId.
     *
     * @return field_type
     */
    public function getImageId() {
        return $this->imageId;
    }

    /**
     * Setter for $ownerId.
     *
     * @param field_type $ownerId
     */
    public function setOwnerId($ownerId) {
        $this->ownerId = $ownerId;
    }

    /**
     * Setter for $position.
     *
     * @param field_type $position
     */
    public function setPosition($position) {
        $this->position = $position;
    }

    /**
     * Setter for $title.
     *
     * @param field_type $title
     */
    public function setTitle($title) {
        $this->title = $title;
    }

    /**
     * Setter for $description.
     *
     * @param field_type $description
     */
    public function setDescription($description) {
        $this->description = $description;
    }

    /**
     * Setter for $imageId.
     *
     * @param field_type $imageId
     */
    public function setImageId($imageId) {
        $this->imageId = $imageId;
    }

}
