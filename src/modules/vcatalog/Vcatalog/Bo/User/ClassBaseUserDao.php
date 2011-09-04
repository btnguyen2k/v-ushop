<?php
abstract class Vcatalog_Bo_User_BaseUserDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_User_IUserDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    private function getUser($stm, $params) {
        $sqlConn = $this->getConnection();
        $rs = $stm->execute($sqlConn->getConn(), $params);
        $result = $this->fetchResultAssoc($rs);
        $this->closeConnection();
        if ($result === FALSE) {
            return NULL;
        }
        $result['id'] = (int)$result['id'];
        $result['groupId'] = (int)$result['groupId'];
        return $result;
    }

    /**
     * @see Vcatalog_Bo_User_IUserDao::getUserById()
     */
    public function getUserById($id) {
        $id = (int)$id; //to make sure it's integer
        $cacheKey = 'USER_' . $id;
        $result = $this->getFromCache($cacheKey, FALSE);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array('id' => $id);
            $result = $this->getUser($sqlStm, $params);
            $this->putToCache($cacheKey, $result, FALSE);
        }
        return $result;
    }

    /**
     * (non-PHPdoc)
     * @see Vcatalog_Bo_User_IUserDao::getUserByEmail()
     */
    public function getUserByEmail($email) {
        $cacheKey = 'USER_' . $email;
        $result = $this->getFromCache($cacheKey, FALSE);
        if ($result === NULL) {
            $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
            $params = Array('email' => $email);
            $result = $this->getUser($sqlStm, $params);
            $this->putToCache($cacheKey, $result, FALSE);
        }
        return $result;
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
