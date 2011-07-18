<?php
interface Vcatalog_Bo_User_IUserDao extends Ddth_Dao_IDao {

    /**
     * Gets a user account by user id.
     *
     * @param int $id
     * @return Array
     */
    public function getUserById($id);

    /**
     * Gets a user account by email address.
     *
     * @param string $email
     * @return Array
     */
    public function getUserByEmail($email);

    /**
     * Updates an existing user account.
     *
     * @param Array $user
     */
    public function updateUser($user);
}
