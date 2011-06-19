<?php
class Vcatalog_Controller_Admin_MoveUpCategoryController extends Vcatalog_Controller_Admin_BaseController {

    /* (non-PHPdoc)
     * @see Vcatalog_Controller_BaseController::execute()
     */
    public function execute($module, $action) {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();
        $catId = $requestParser->getPathInfoParam(2);
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
                if ($second->getId() == $cat->getId()) {
                    $this->swapUp($first, $second);
                    break;
                }
            }
        }
        $url = $_SERVER['SCRIPT_NAME'] . '/admin/categories';
        $view = new Dzit_View_RedirectView($url);
        return new Dzit_ModelAndView($view);
    }

    /**
     * Swap "up" two categories' positions.
     *
     * @param Vcatalog_Bo_Catalog_BoCategory $first
     * @param Vcatalog_Bo_Catalog_BoCategory $second
     */
    private function swapUp($first, $second) {
        $catalogDao = $this->getDao(DAO_CATALOG);
        $positionSecond = $second->getPosition();
        $second->setPosition($positionSecond - 1);
        $first->setPosition($positionSecond);
        $catalogDao->updateCategory($first);
        $catalogDao->updateCategory($second);
    }
}
