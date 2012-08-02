<?php
class Vushop_Controller_ViewItemController extends Vushop_Controller_BaseFlowController {
    const VIEW_NAME = 'viewItem';
    const VIEW_NAME_ERROR = 'error';

    private $itemId;
    /**
     * @var Vushop_Bo_Catalog_BoItem
     */
    private $item = NULL;
    /**
     * @var Vushop_Bo_Shop_BoShop
     */
    private $shop = NULL;

    /**
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     * Populates itemId and item instance.
     *
     * @see Dzit_Controller_FlowController::populateParams()
     */
    protected function populateParams() {
        /**
         * @var Dzit_RequestParser
         */
        $requestParser = Dzit_RequestParser::getInstance();

        $this->itemId = (int)$requestParser->getPathInfoParam(1);
        /**
         * @var Vushop_Bo_Catalog_ICatalogDao
         */
        $catalogDao = $this->getDao(DAO_CATALOG);
        $this->item = $catalogDao->getItemById($this->itemId);

        if ( $this->item !== NULL ) {
            $shopId = $this->item->getOwnerId();
            $shopDao = $this->getDao(DAO_SHOP);
            $this->shop = $shopDao->getShopById($shopId);
        }
    }

    /**
     * Test if the item to be viewed is valid.
     *
     * @see Dzit_Controller_FlowController::validateParams()
     */
    protected function validateParams() {
        $item = $this->item;
        $itemId = $this->itemId;
        if ($item === NULL) {
            $lang = $this->getLanguage();
            $this->addErrorMessage($lang->getMessage('error.itemNotFound', (int)$itemId));
            return FALSE;
        }
        return TRUE;
    }

    /**
     * @see Dzit_Controller_FlowController::getModelAndView_Error()
     */
    protected function getModelAndView_Error() {
        $viewName = self::VIEW_NAME_ERROR;
        $model = $this->buildModel();
        if ($model == NULL) {
            $model = Array();
        }

        $lang = $this->getLanguage();
        $model[MODEL_ERROR_MESSAGES] = $this->getErrorMessages();

        return new Dzit_ModelAndView($viewName, $model);
    }

    /**
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model === NULL) {
            $model = Array();
        }

        $model['itemObj'] = $this->item;
        $model['shopObj'] = $this->shop;

        return $model;
    }
}
