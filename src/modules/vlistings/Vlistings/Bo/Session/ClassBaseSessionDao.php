<?php
abstract class Vlistings_Bo_Session_BaseSessionDao extends Ddth_Dao_AbstractSqlStatementDao implements
        Vlistings_Bo_Session_ISessionDao {

    /**
     * Fetches result from the result set and returns as an associative array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultAssoc($rs);

    /**
     * Fetches result from the result set and returns as an index array.
     *
     * @param resource $rs
     */
    protected abstract function fetchResultArr($rs);

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Session_ISessionDao::deleteExpiredSessions()
     */
    public function deleteExpiredSessions($expiry) {
        $sqlStm = $this->getSqlStatement('sql.deleteExpiredSessions');
        $wrappedConn = $this->getConnection();

        $sqlStm->execute($wrappedConn->getConn());
        $this->closeConnection();
    }

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Session_ISessionDao::deleteSessionData()
     */
    public function deleteSessionData($id) {
        $sqlStm = $this->getSqlStatement('sql.deleteSessionById');
        $wrappedConn = $this->getConnection();

        $params = Array('sid' => $id);
        $sqlStm->execute($wrappedConn->getConn(), $params);
        $this->closeConnection();
    }

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Session_ISessionDao::readSessionData()
     */
    public function readSessionData($id) {
        $sqlStm = $this->getSqlStatement('sql.readSession');
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $result = $this->fetchResultAssoc($rs);

        $this->closeConnection();
        return $result !== FALSE ? $result['data'] : NULL;
    }

    /* (non-PHPdoc)
     * @see Vlistings_Bo_Session_ISessionDao::writeSessionData()
     */
    public function writeSessionData($id, $data) {
        $data = $this->readSessionData($id);
        if ($data === NULL) {
            $sqlStm = $this->getSqlStatement('sql.createSession');
        } else {
            $sqlStm = $this->getSqlStatement('sql.updateSession');
        }
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id, 'data' => $data);
        $sqlStm->execute($sqlConn->getConn(), $params);
        $this->closeConnection();
    }
}
