<?php
class Vcatalog_Controller_Admin_ItemListController extends Vcatalog_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'admin_itemList';

    private $pageNum;
    private $featuredItemsOnly = FALSE;
    private $category = NULL;

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates category and paging info.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $this->pageNum = isset($_GET['p']) ? (int)$_GET['p'] : 0;
        $this->featuredItemsOnly = isset($_GET['f']) ? (bool)$_GET['f'] : FALSE;
        $catId = isset($_GET['c']) ? (int)$_GET['c'] : 0;

        if ($this->pageNum < 1) {
            $this->pageNum = 1;
        }

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->category = $catalogDao->getCategoryById($catId);
        if ($this->category != NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
        }
    }

    /**
     * @see Vcatalog_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        if ($this->featuredItemsOnly) {
            $model['featuredItemsOnly'] = TRUE;
        }

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        if ($this->category !== NULL) {
            $model['objCategory'] = $this->category;
            $itemList = $catalogDao->getItemsForCategory($this->category, $this->pageNum, DEFAULT_PAGE_SIZE, DEFAULT_ITEM_SORTING, $this->featuredItemsOnly);
            //paging
            $numItems = $catalogDao->countNumItemsForCategory($this->category, $this->featuredItemsOnly);
            $urlTemplate = $_SERVER['SCRIPT_NAME'] . '/admin/items?p=${page}&c=' . $this->category->getId();
            if ($this->featuredItemsOnly) {
                $urlTemplate .= '&f=1';
            }
            $paginator = new Commons_Model_Paginator($urlTemplate, $numItems, DEFAULT_PAGE_SIZE,
                    $this->pageNum);
        } else {
            $itemList = $catalogDao->getAllItems($this->pageNum, DEFAULT_PAGE_SIZE, DEFAULT_ITEM_SORTING, $this->featuredItemsOnly);
            //paging
            $numItems = $catalogDao->countNumItems($this->featuredItemsOnly);
            $urlTemplate = $_SERVER['SCRIPT_NAME'] . '/admin/items?p=${page}';
            if ($this->featuredItemsOnly) {
                $urlTemplate .= '&f=1';
            }
            $paginator = new Commons_Model_Paginator($urlTemplate, $numItems, DEFAULT_PAGE_SIZE,
                    $this->pageNum);
        }
        $model[MODEL_ITEM_LIST] = $itemList;
        $model[MODEL_PAGINATOR] = $paginator;

        return $model;
    }
}
