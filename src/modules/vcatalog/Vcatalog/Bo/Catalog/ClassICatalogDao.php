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
     * @param string $imageId
     */
    public function createCategory($position, $parentId, $title, $description, $imageId);

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

    /**
     * Counts number of current items.
     *
     * @return int
     */
    public function countNumItems();

    /**
     * Counts number of current items within a category.
     *
     * @return int
     */
    public function countNumItemsForCategory($cat);

    /**
     * Creates a new item.
     *
     * @param int $categoryId
     * @param string $title
     * @param string $description
     * @param string $vendor
     * @param int $timestamp
     * @param double $price
     * @param double $oldPrice
     * @param double $stock
     * @param string $imageId
     * @param boolean $hotItem
     */
    public function createItem($categoryId, $title, $description, $vendor, $timestamp, $price, $oldPrice, $stock, $imageId, $hotItem = TRUE);

    /**
     * Deletes an existing items.
     *
     * @param Vcatalog_Bo_Catalog_BoItem $item
     */
    public function deleteItem($item);

    /**
     * Gets all available items as a list.
     *
     * @param int $pageNum
     * @param int $pageSize
     * @return Array
     */
    public function getAllItems($pageNum = 1, $pageSize = 999);

    /**
     * Gets an item by id.
     *
     * @param int $id
     * @return Vcatalog_Bo_Catalog_BoItem
     */
    public function getItemById($id);

    /**
     * Gets all items within a category as a list.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
     * @param int $pageNum
     * @param int $pageSize
     * @param string $itemSorting
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
     */
    public function getItemsForCategory($cat, $pageNum = 1, $pageSize = 999, $itemSorting=DEFAULT_ITEM_SORTING);

    /**
     * Gets "hot" items.
     *
     * @param int $numItems number of items to retrieve
     * @return Array
     */
    public function getHotItems($numItems = 10);

    /**
     * Searches for items.
     *
     * @param string $searchQuery
     * @param int $searchType 0 = search in title, 1 = search in description/content, 2 = search in both
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
     * @param int $pageNum
     * @param int $pageSize
     * @return Array
     */
    public function searchItems($searchQuery, $searchType = 2, $cat = NULL, $pageNum = 1, $pageSize = 10);

    /**
     * Counts items that match a search query.
     *
     * @param string $searchQuery
     * @param int $searchType 0 = search in title, 1 = search in description/content, 2 = search in both
     * @param Vcatalog_Bo_Catalog_BoCategory $cat
     */
    public function countSearchItems($searchQuery, $searchType, $cat = NULL);

    /**
     * Updates an existing item.
     *
     * @param Vcatalog_Bo_Catalog_BoItem $item
     */
    public function updateItem($item);
}
