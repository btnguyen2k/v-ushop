<?php
class Vushop_Controller_MyItemsController extends Vushop_Controller_BaseFlowController {

    const VIEW_NAME = 'my_items';

    private $pageNum;
    private $category = NULL;

    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
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
        $catId = isset($_GET['c']) ? (int)$_GET['c'] : 0;

        if ($this->pageNum < 1) {
            $this->pageNum = 1;
        }

        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->category = $catalogDao->getCategoryById($catId);
        if ($this->category != NULL) {
            $children = $catalogDao->getCategoryChildren($this->category);
            $this->category->setChildren($children);
        }
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $ownerId=isset($_SESSION[SESSION_USER_ID])?$_SESSION[SESSION_USER_ID]:0;
        if ($this->category !== NULL) {
            $model['objCategory'] = $this->category;
            $itemList = $catalogDao->getItemsForCategoryShop($this->category,$ownerId, $this->pageNum, 5, DEFAULT_ITEM_SORTING);
            // paging
            $numItems = count($itemList);
            
            $urlTemplate = $this->getUrlMyItems() . '?p=${page}&c=' . $this->category->getId();            
            $paginator = new Quack_Model_Paginator($urlTemplate, $numItems, 5,
                    $this->pageNum);
        } else {
            $itemList = $catalogDao->getAllItemsForShop($ownerId,$this->pageNum, 5, DEFAULT_ITEM_SORTING);
            // paging
            $numItems = count($itemList);
           
            $urlTemplate =$this->getUrlMyItems() . '?p=${page}';           
            $paginator = new Quack_Model_Paginator($urlTemplate, $numItems, 5,
                    $this->pageNum);
        }
        $model[MODEL_MY_ITEMS] = $itemList;
        $model[MODEL_PAGINATOR] = $paginator;

        return $model;
    }
}
