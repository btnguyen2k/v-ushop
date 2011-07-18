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

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Session_ISessionDao::getUserById()
     */
    public function getUserById($id) {
        $id = (int)$id; //to make sure it's integer
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array('id' => $id);
        return $this->getUser($sqlStm, $params);
    }

    /* (non-PHPdoc)
     * @see Vcatalog_Bo_Session_ISessionDao::getUserByEmail()
     */
    public function getUserByEmail($email) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $params = Array('email' => $email);
        return $this->getUser($sqlStm, $params);
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
