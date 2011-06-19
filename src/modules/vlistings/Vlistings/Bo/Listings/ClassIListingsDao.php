<?php
interface Vlistings_Bo_Listings_IListingsDao extends Ddth_Dao_IDao {

    /**
     * Creates a new category.
     *
     * @param int $position
     * @param int $parentId
     * @param string $title
     * @param string $description
     */
    public function createCategory($position, $parentId, $title, $description);

    /**
     * Gets a category by id.
     *
     * @param int $id
     */
    public function getCategoryById($id);

    /**
     * Gets all categories as a tree.
     *
     * @return Array
     */
    public function getCategoryTree();

    /**
     * Counts number of current categories.
     *
     * @return int
     */
    public function countNumCategories();
}