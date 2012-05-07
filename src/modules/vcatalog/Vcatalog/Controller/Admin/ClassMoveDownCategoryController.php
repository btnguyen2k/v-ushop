<?php
class Vcatalog_Controller_Admin_MoveDownCategoryController extends Vcatalog_Controller_Admin_BaseFlowController {

    /**
     * @see Dzit_Controller_FlowController::execute()
     */
    public function execute($module, $action) {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $catId = $requestParser->getPathInfoParam(1);
        /**
         * @var Vcatalog_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $cat = $catalogDao->getCategoryById($catId);
        if ($cat !== NULL) {
            $parentId = $cat->getParentId();
            if ($parentId === NULL || $parentId < 1) {
                //first level category
                $catList = $catalogDao->getCategoryTree();
            } else {
                //child category
                $parent = $catalogDao->getCategoryById($parentId);
                //$catList = $parent->getChildren();
                $catList = $catalogDao->getCategoryChildren($parent);
            }
            $first = NULL;
            $second = $catList[0];
            for ($i = 1; $i < count($catList); $i++) {
                $first = $second;
                $second = $catList[$i];
                if ($first->getId() == $cat->getId()) {
                    $this->swapDown($first, $second);
                    break;
                }
            }
        }
        $url = $this->getUrlCategoryManagement();
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view);
    }

    /**
     * Swap "down" two categories' positions.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $first
     * @param Vcatalog_Bo_Catalog_BoCategory $second
     */
    private function swapDown($first, $second) {
        $catalogDao = $this->getDao(DAO_CATALOG);
        $positionFirst = $first->getPosition();
        $first->setPosition($positionFirst + 1);
        $second->setPosition($positionFirst);
        $catalogDao->updateCategory($first);
        $catalogDao->updateCategory($second);
    }
}
