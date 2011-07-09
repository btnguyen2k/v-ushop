<?php
abstract class Vcatalog_Bo_Cart_BaseCartDao extends Commons_Bo_BaseDao implements
        Vcatalog_Bo_Cart_ICartDao {

    /**
     * @var Ddth_Commons_Logging_ILog
     */
    private $LOGGER;

    public function __construct() {
        $this->LOGGER = Ddth_Commons_Logging_LogFactory::getLog(__CLASS__);
        parent::__construct();
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getCart()
     */
    public function getCart($sessionId) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('sessionId' => $sessionId);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $cart = new Vcatalog_Bo_Cart_BoCart();
            $cart->populate($row);
        } else {
            $cart = NULL;
        }

        $this->closeConnection();
        if ($cart === NULL) {
            $cart = new Vcatalog_Bo_Cart_BoCart();
            $cart->setSessionId($sessionId);
        }
        if ($cart !== NULL) {
            $items = $this->getItemsInCart($cart);
            foreach ($items as $item) {
                $cart->addItem($item);
            }
        }
        return $cart;
    }

    /**
     * @see Vcatalog_Bo_Cart_ICartDao::getItemsInCart()
     */
    public function getItemsInCart($cart) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $params = Array('sessionId' => $cart->getSessionId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $cartItem = new Vcatalog_Bo_Cart_BoCartItem();
            $cartItem->populate($row);
            $result[] = $cartItem;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::createPage()
     */
    public function createPage($id, $position, $title, $content, $onMenu) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id,
                'position' => $position,
                'title' => $title,
                'content' => $content,
                'onMenu' => $onMenu ? 1 : 0);
        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::deletePage()
     */
    public function deletePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $page->getId());
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getPageById()
     */
    public function getPageById($id) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $id);
        $rs = $sqlStm->execute($sqlConn->getConn(), $params);
        $row = $this->fetchResultAssoc($rs);
        if ($row !== NULL && $row !== FALSE) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
        } else {
            $page = NULL;
        }

        $this->closeConnection();
        return $page;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getAllPages()
     */
    public function getAllPages() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
            $result[] = $page;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::getOnMenuPages()
     */
    public function getOnMenuPages() {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $result = Array();
        $rs = $sqlStm->execute($sqlConn->getConn());
        $row = $this->fetchResultAssoc($rs);
        while ($row !== FALSE && $row !== NULL) {
            $page = new Vcatalog_Bo_Page_BoPage();
            $page->populate($row);
            $result[] = $page;
            $row = $this->fetchResultAssoc($rs);
        }

        $this->closeConnection();
        return $result;
    }

    /**
     * @see Vcatalog_Bo_Page_IPageDao::updatePage()
     */
    public function updatePage($page) {
        $sqlStm = $this->getStatement('sql.' . __FUNCTION__);
        $sqlConn = $this->getConnection();

        $params = Array('id' => $page->getId(),
                'position' => $page->getPosition(),
                'title' => $page->getTitle(),
                'content' => $page->getContent(),
                'onMenu' => $page->getOnMenu() ? 1 : 0);

        $sqlStm->execute($sqlConn->getConn(), $params);

        $this->closeConnection();
    }
}
