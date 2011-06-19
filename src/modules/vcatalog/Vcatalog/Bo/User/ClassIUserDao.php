<?php
interface Vcatalog_Bo_User_IUserDao extends Ddth_Dao_IDao {

    /**
     * Gets a user account by user id.
     *
     * @param int $id
     */
    public function getUserById($id);

    /**
     * Gets a user account by email address.
     *
     * @param string $email
     */
    public function getUserByEmail($email);
}