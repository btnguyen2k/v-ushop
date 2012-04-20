<?php
class Vcatalog_Bo_User_BoUser extends Quack_Bo_BaseBo {

    /* Database table columns: virtual columns */
    const COL_ID = 'userId';
    const COL_EMAIL = 'userEmail';
    const COL_PASSWORD = 'userPassword';
    const COL_GROUP_ID = 'userGroupId';
    const COL_TITLE = 'userTitle';
    const COL_FULLNAME = 'userFullname';
    const COL_LOCATION = 'userLocation';

    private $id, $email, $password, $groupId, $title, $fullname, $location;

    private $urlProfileCp = NULL;

    /* (non-PHPdoc)
     * @see Quack_Bo_BaseBo::getFieldMap()
     */
    protected function getFieldMap() {
        return Array(self::COL_ID => Array('id', self::TYPE_INT),
                self::COL_EMAIL => Array('email'),
                self::COL_PASSWORD => Array('password'),
                self::COL_GROUP_ID => Array('groupId', self::TYPE_INT),
                self::COL_TITLE => Array('title'),
                self::COL_FULLNAME => Array('fullname'),
                self::COL_LOCATION => Array('location'));
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

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getFullname() {
        return $this->fullname;
    }

    public function setFullname($fullname) {
        $this->fullname = $fullname;
    }

    public function getLocation() {
        return $this->location;
    }

    public function setLocation($location) {
        $this->location = $location;
    }

    /**
     * Gets the URL to access user's profile control panel.
     *
     * @return string
     */
    public function getUrlProfileCp() {
        if ($this->urlProfileCp === NULL) {
            $this->urlProfileCp = $_SERVER['SCRIPT_NAME'] . '/profilecp';
        }
        return $this->urlProfileCp;
    }
}
