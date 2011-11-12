<?php
abstract class Vcatalog_Bo_User_BaseUserDao extends Quack_Bo_BaseDao implements
        Vcatalog_Bo_User_IUserDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    /* Virtual columns */
    const COL_ID = 'userId';
    const COL_EMAIL = 'userEmail';
    const COL_CATEGORY = 'userPassword';
    const COL_GROUP_UD = 'userGroupId';

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * @see Vcatalog_Bo_User_IUserDao::getUserById()
     */
    public function getUserById($id) {
        $id = (int)$id;
        $cacheKey = "USER_$id";
        $user = $this->getFromCache($cacheKey);
        if ($user === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(self::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $user = new Vcatalog_Bo_User_BoUser();
                $user->populate($rows[0]);
                $this->putToCache($cacheKey, $user);
            }
        }
        return $user;
    }

    /**
     * (non-PHPdoc)
     * @see Vcatalog_Bo_User_IUserDao::getUserByEmail()
     */
    public function getUserByEmail($email) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(self::COL_EMAIL => $email);
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            $userId = $rows[0][self::COL_ID];
            return $this->getUserById($userId);
        }
        return NULL;
    }

    /**
     * (non-PHPdoc)
     * @see Vcatalog_Bo_User_IUserDao::updateUser()
     */
    public function updateUser($user) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => (int)$user['id'],
                'email' => $user['email'],
                'password' => $user['password'],
                'groupId' => (int)$user['groupId']);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }
}
