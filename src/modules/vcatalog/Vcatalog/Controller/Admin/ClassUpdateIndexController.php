<?php
class Vcatalog_Controller_Admin_UpdateIndexController extends Vcatalog_Controller_Admin_BaseFlowController {

    /**
     * @see Vcatalog_Controller_BaseFlowController::execute()
     */
    public function execute($module, $action) {
        $dao = $this->getDao(DAO_CATALOG);
        $items = $dao->getAllItems();
        for ($i = 0, $n = count($items); $i < $n; $i++) {
            $item = $items[$i];
            echo "Processing..." . ($i + 1) . "/$n<br>";
            $dao->updateItem($item);
        }
    }
}
