<?php
abstract class Vushop_Bo_User_BaseUserDao extends Quack_Bo_BaseDao implements
        Vushop_Bo_User_IUserDao {

    /**
     *
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Quack_Bo_BaseDao::getCacheName()
     */
    public function getCacheName() {
        return 'IUserDao';
    }

    protected function createCacheKeyUserId($userId) {
        return $userId;
    }

    protected function createCacheKeyUserUsername($username) {
        return "USERNAME_$username";
    }

    protected function createCacheKeyUserEmail($email) {
        return "EMAIL_$email";
    }

    /**
     * Invalidates the user cache due to change.
     *
     * @param Vushop_Bo_User_BoUser $user
     */
    protected function invalidateCache($user = NULL) {
        if ($user !== NULL) {
            $id = $user->getId();
            $email = $user->getEmail();
            $loginname = $user->getLoginname();
            $this->deleteFromCache($this->createCacheKeyUserId($id));
            $this->deleteFromCache($this->createCacheKeyUserEmail($email));
            $this->deleteFromCache($this->createCacheKeyUserLoginname($loginname));
        }
    }

    /**
     *
     * @see Vushop_Bo_User_IUserDao::getUserById()
     */
    public function getUserById($id) {
        $id = (int)$id;
        $cacheKey = $this->createCacheKeyUserId($id);
        $user = $this->getFromCache($cacheKey);
        if ($user === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_User_BoUser::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $user = new Vushop_Bo_User_BoUser();
                $user->populate($rows[0]);
                $this->putToCache($cacheKey, $user);
            }
        }
        return $user;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::getUserByEmail()
     */
    public function getUserByEmail($email) {
        if ($email === NULL) {
            return NULL;
        }
        $email = strtolower($email);
        $cacheKey = $this->createCacheKeyUserEmail($email);
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_User_BoUser::COL_EMAIL => $email);
        $rows = $this->execSelect($sqlStm, $params, NULL, $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            $userId = $rows[0][Vushop_Bo_User_BoUser::COL_ID];
            return $this->getUserById($userId);
        }
        return NULL;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::getUserByUsername()
     */
    public function getUserByUsername($username) {
        if ($username === NULL) {
            return NULL;
        }
        $username = strtolower($username);
        $cacheKey = $this->createCacheKeyUserUsername($username);
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_User_BoUser::COL_USERNAME => $username);
        $rows = $this->execSelect($sqlStm, $params, NULL, $cacheKey);
        if ($rows !== NULL && count($rows) > 0) {
            $userId = $rows[0][Vushop_Bo_User_BoUser::COL_ID];
            return $this->getUserById($userId);
        }
        return NULL;
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::createUser()
     */
    public function createUser($user) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_User_BoUser::COL_USERNAME => $user->getUsername(),
                Vushop_Bo_User_BoUser::COL_EMAIL => $user->getEmail(),
                Vushop_Bo_User_BoUser::COL_PASSWORD => $user->getPassword(),
                Vushop_Bo_User_BoUser::COL_GROUP_ID => (int)$user->getGroupId(),
                Vushop_Bo_User_BoUser::COL_TITLE => $user->getTitle(),
                Vushop_Bo_User_BoUser::COL_FULLNAME => $user->getFullname(),
                Vushop_Bo_User_BoUser::COL_LOCATION => $user->getLocation());
        $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache();
    }

    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::updateUser()
     */
    public function updateUser($user) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array(Vushop_Bo_User_BoUser::COL_ID => (int)$user->getId(),
                Vushop_Bo_User_BoUser::COL_USERNAME => $user->getUsername(),
                Vushop_Bo_User_BoUser::COL_EMAIL => $user->getEmail(),
                Vushop_Bo_User_BoUser::COL_TITLE => $user->getTitle(),
                Vushop_Bo_User_BoUser::COL_FULLNAME => $user->getFullname(),
                Vushop_Bo_User_BoUser::COL_LOCATION => $user->getLocation(),
                Vushop_Bo_User_BoUser::COL_PASSWORD => $user->getPassword(),
                Vushop_Bo_User_BoUser::COL_GROUP_ID => (int)$user->getGroupId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($user);
        return $result;
    }
}
