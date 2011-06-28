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
     * @param int $position
     * @param string $title
     * @param string $content
     */
    public function createPage($position, $title, $content);

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
     * Updates a page.
     *
     * @param Vcatalog_Bo_Page_BoPage $page
     */
    public function updatePage($page);
}