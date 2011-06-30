<?php
interface Vcatalog_Bo_Page_IPageDao extends Ddth_Dao_IDao {

    /**
     * Counts number of current pages.
     *
     * @return int
     */
    public function countNumPages();

    /**
     * Creates a new page.
     *
     * @param string $id
     * @param int $position
     * @param string $title
     * @param string $content
     * @param string $onMenu
     */
    public function createPage($id, $position, $title, $content, $onMenu);

    /**
     * Deletes a page.
     *
     * @param Vcatalog_Bo_Page_BoPage $page
     */
    public function deletePage($page);

    /**
     * Gets a page by id.
     *
     * @param string $id
     * @return Vcatalog_Bo_Page_BoPage
     */
    public function getPageById($id);

    /**
     * Gets all pages as a list.
     *
     * @return Array
     */
    public function getAllPages();

    /**
     * Gets all "on-menu" pages as a list.
     *
     * @return Array
     */
    public function getOnMenuPages();

    /**
     * Updates a page.
     *
     * @param Vcatalog_Bo_Page_BoPage $page
     */
    public function updatePage($page);
}