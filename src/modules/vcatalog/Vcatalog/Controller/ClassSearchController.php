<?php
class Vcatalog_Controller_SearchController extends Vcatalog_Controller_BaseFlowController {
    const VIEW_NAME = 'search';

    /**
     * @var Vcatalog_Bo_Catalog_BoCategory
     */
    private $category = NULL;
    private $searchTerm;
    private $pageNum;

    /**
     * @see Vcatalog_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates search criteria.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        $this->searchTerm = isset($_GET['q']) ? trim($_GET['q']) : '';
        $this->pageNum = isset($_GET['p']) ? (int)$_GET['p'] : 0;
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
     * @see Vcatalog_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        if ($this->category !== NULL) {
            $model['categoryObj'] = $this->category;
        }

        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);

        $items = $catalogDao->searchItems($this->searchTerm, 2, $this->category, $this->pageNum, 999);
        $model[MODEL_ITEM_LIST] = $items;

        return $model;
    }
}
