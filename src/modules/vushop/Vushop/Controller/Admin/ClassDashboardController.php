<?php
class Vushop_Controller_Admin_DashboardController extends Vushop_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'inline_dashboard';

    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Vushop_Controller_Admin_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        $siteDao = $this->getSiteDao();
        $site = $this->getGpvSite();
        $siteProd = $this->getGpvProduct();
        $siteProdLevel = $siteProd->getProductLevel();
        $prod = $siteDao->getProductByName($siteProd->getProductName());
        $prodConfig = $prod->getProductConfigMap();
        $prodConfigLevel = $prodConfig['LEVELS'][$siteProdLevel];

        /**
         *
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $catTree = $catalogDao->getCategoryTree();
        $model[MODEL_CATEGORY_TREE] = $catTree;
        $numCats = $catalogDao->countNumCategories();
        $percentCats = 100.0 * $numCats / $prodConfigLevel['CATALOG_CATEGORIES'];
        if ($percentCats > 100.0) {
            $percentCats = 100.0;
        }
        $model['numCategories'] = $numCats;
        $model['maxCategories'] = $prodConfigLevel['CATALOG_CATEGORIES'];
        $model['percentCategories'] = $percentCats;

        $numItems = $catalogDao->countNumItems();
        $percentItems = 100.0 * $numItems / $prodConfigLevel['CATALOG_ITEMS'];
        if ($percentItems > 100.0) {
            $percentItems = 100.0;
        }
        $model['numItems'] = $numItems;
        $model['maxItems'] = $prodConfigLevel['CATALOG_ITEMS'];
        $model['percentItems'] = $percentItems;

        /**
         *
         * @var Vushop_Bo_Page_IPageDao
         */
        $pageDao = $this->getDao(DAO_PAGE);
        $allPages = $pageDao->getPages();
        $model[MODEL_PAGE_LIST] = Vushop_Model_PageBEModel::createModelObj($allPages);
        $numPages = $pageDao->countNumPages();
        $percentPages = 100.0 * $numPages / $prodConfigLevel['CMS_PAGES'];
        if ($percentPages > 100.0) {
            $percentPages = 100.0;
        }
        $model['numPages'] = $numPages;
        $model['maxPages'] = $prodConfigLevel['CMS_PAGES'];
        $model['percentPages'] = $percentPages;

        /**
         *
         * @var Vushop_Bo_TextAds_IAdsDao
         */
        $adsDao = $this->getDao(DAO_TEXTADS);
        $allAds = $adsDao->getAds();
        $model[MODEL_ADS_LIST] = Vushop_Model_AdsBEModel::createModelObj($allAds);
        $model['numAds'] = $adsDao->countNumAds();

        return $model;
    }
}
