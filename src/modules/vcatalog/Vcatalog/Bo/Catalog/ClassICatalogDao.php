<?php
interface Vcatalog_Bo_Catalog_ICatalogDao extends Ddth_Dao_IDao {

    /**
     * Counts number of current categories.
     *
     * @return int
     */
    public function countNumCategories();

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
     * Deletes a category.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $category
     */
    public function deleteCategory($category);

    /**
     * Gets a category by id.
     *
     * @param int $id
     * @return Vcatalog_Bo_Catalog_BoCategory
     */
    public function getCategoryById($id);

    /**
     * Gets all children of a category.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $category
     * @return Array() index array of Vcatalog_Bo_Catalog_BoCategory
     */
    public function getCategoryChildren($category);

    /**
     * Gets all categories as a tree.
     *
     * @return Array
     */
    public function getCategoryTree();

    /**
     * Updates a category.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $category
     */
    public function updateCategory($category);
}