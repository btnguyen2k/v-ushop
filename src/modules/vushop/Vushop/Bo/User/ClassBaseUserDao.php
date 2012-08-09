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
            $username = $user->getUsername();
            $this->deleteFromCache($this->createCacheKeyUserId($id));
            $this->deleteFromCache($this->createCacheKeyUserEmail($email));
            $this->deleteFromCache($this->createCacheKeyUserUsername($username));
        }
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::getUsers()
     */
    public function getUsers() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array();
        $result = Array();
        $rows = $this->execSelect($sqlStm, $params);
        if ($rows !== NULL && count($rows) > 0) {
            foreach ($rows as $row) {
                $userId = $row[Vushop_Bo_User_BoUser::COL_ID];
                $user = $this->getUserById($userId);
                $result[] = $user;
            }
        }
        return $result;
    }
    
    /**
     * (non-PHPdoc)
     *
     * @see Vushop_Bo_User_IUserDao::getUsers()
     */
    public function getUserByGroup($groupId) {
        $groupId = (int)$groupId;
        $cacheKey = $this->createCacheKeyUserId($groupId);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_User_BoUser::COL_GROUP_ID => $groupId);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                foreach ($rows as $row) {
                    $userId = $row[Vushop_Bo_User_BoUser::COL_ID];
                    $user = $this->getUserById($userId);
                    $result[] = $user;
                }
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
    }
    
    /**
     *
     * @see Vushop_Bo_User_IUserDao::getUserById()
     */
    public function getUserById($id) {
        $id = (int)$id;
        $cacheKey = $this->createCacheKeyUserId($id);
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_User_BoUser::COL_ID => $id);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $result = new Vushop_Bo_User_BoUser();
                $result->populate($rows[0]);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
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
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_User_BoUser::COL_EMAIL => $email);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $userId = $rows[0][Vushop_Bo_User_BoUser::COL_ID];
                $result = $this->getUserById($userId);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
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
        $result = $this->getFromCache($cacheKey);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array(Vushop_Bo_User_BoUser::COL_USERNAME => $username);
            $rows = $this->execSelect($sqlStm, $params);
            if ($rows !== NULL && count($rows) > 0) {
                $userId = $rows[0][Vushop_Bo_User_BoUser::COL_ID];
                $result = $this->getUserById($userId);
            }
        }
        return $this->returnCachedResult($result, $cacheKey);
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
                Vushop_Bo_User_BoUser::COL_ADDRESS => $user->getAddress(), 
                Vushop_Bo_User_BoUser::COL_PHONE => $user->getPhone(), 
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
                Vushop_Bo_User_BoUser::COL_ADDRESS => $user->getAddress(), 
                Vushop_Bo_User_BoUser::COL_PHONE => $user->getPhone(), 
                Vushop_Bo_User_BoUser::COL_GROUP_ID => (int)$user->getGroupId());
        $result = $this->execNonSelect($sqlStm, $params);
        $this->invalidateCache($user);
        return $result;
    }
}
