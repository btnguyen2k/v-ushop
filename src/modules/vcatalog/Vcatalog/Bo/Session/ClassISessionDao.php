<?php
interface Vcatalog_Bo_Session_ISessionDao extends Ddth_Dao_IDao {

    /**
     * Deletes expired sessions.
     * @param int $expiry
     */
    public function deleteExpiredSessions($expiry);

    /**
     * Deletes a session by id.
     * @param string $id
     */
    public function deleteSessionData($id);

    /**
     * Gets a session data by id.
     * @param string $id
     * @param string session data, or NULL if not exists
     */
    public function readSessionData($id);

    /**
     * Writes session data.
     * @param string $id
     * @param string $data
     */
    public function writeSessionData($id, $data);
}