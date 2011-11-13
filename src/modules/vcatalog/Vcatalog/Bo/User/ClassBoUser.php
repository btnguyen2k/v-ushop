<?php
class Vcatalog_Bo_User_BoUser extends Commons_Bo_BaseBo {

    /* Database table columns: virtual columns */
    const COL_ID = 'userId';
    const COL_EMAIL = 'userEmail';
    const COL_PASSWORD = 'userPassword';
    const COL_GROUP_ID = 'userGroupId';

    private $id, $email, $password, $groupId;

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
        return Array(self::COL_ID => Array('id', self::TYPE_INT),
                self::COL_EMAIL => Array('email'),
                self::COL_PASSWORD => Array('password'),
                self::COL_GROUP_ID => Array('groupId', self::TYPE_INT));
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function getGroupId() {
        return $this->groupId;
    }

    public function setGroupId($groupId) {
        $this->groupId = $groupId;
    }
}