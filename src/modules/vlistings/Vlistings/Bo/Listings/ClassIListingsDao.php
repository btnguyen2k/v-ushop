<?php
interface Vlistings_Bo_Listings_IListingsDao extends Ddth_Dao_IDao {
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