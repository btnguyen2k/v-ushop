<?php
class Vushop_Controller_Admin_HomeController extends Vushop_Controller_Admin_BaseFlowController {

    const VIEW_NAME = 'home';
    private $MENU;

    public function __construct() {
        parent::__construct();
        $lang = $this->getLanguage();
        /**
         *
         * @var Dzit_IUrlCreator
         */
        $urlCreator = Dzit_Config::get(Dzit_Config::CONF_URL_CREATOR);
        $this->MENU = Array(
                Array('title' => $lang->getMessage('msg.userManagement'),
                        'groups' => Array(USER_GROUP_ADMIN),
                        'children' => Array(
                                Array('title' => $lang->getMessage('msg.userList'),
                                        'icon' => 'userList',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'users'))),
                                Array('title' => $lang->getMessage('msg.createUser'),
                                        'icon' => 'userAdd',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'createUser'))))),
                Array('title' => $lang->getMessage('msg.settings'),
                        'groups' => Array(USER_GROUP_ADMIN),
                        'children' => Array(
                                Array('title' => $lang->getMessage('msg.siteSettings'),
                                        'icon' => 'siteSettings',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'siteSettings'))),
                                Array('title' => $lang->getMessage('msg.emailSettings'),
                                        'icon' => 'emailSettings',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'emailSettings'))),
                                Array('title' => $lang->getMessage('msg.catalogSettings'),
                                        'icon' => 'catalogSettings',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'catalogSettings'))),
                                Array('title' => '-'),
                                Array('title' => $lang->getMessage('msg.categoryList'),
                                        'icon' => 'categoryList',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'categories'))),
                                Array('title' => $lang->getMessage('msg.createCategory'),
                                        'icon' => 'categoryAdd',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'createCategory'))))),
                Array('title' => $lang->getMessage('msg.pageManagement'),
                        'groups' => Array(USER_GROUP_ADMIN),
                        'children' => Array(
                                Array('title' => $lang->getMessage('msg.pageList'),
                                        'icon' => 'pageList',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'pages'))),
                                Array('title' => $lang->getMessage('msg.createPage'),
                                        'icon' => 'pageAdd',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'createPage'))))),
                Array('title' => $lang->getMessage('msg.adsManagement'),
                        'groups' => Array(USER_GROUP_ADMIN),
                        'children' => Array(
                                Array('title' => $lang->getMessage('msg.adsList'),
                                        'icon' => 'adsList',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'ads'))),
                                Array('title' => $lang->getMessage('msg.createAds'),
                                        'icon' => 'adsAdd',
                                        'groups' => Array(USER_GROUP_ADMIN),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'createAds'))))),
                Array('title' => '-'),
                Array('title' => $lang->getMessage('msg.catalogManagement'),
                        'groups' => Array(USER_GROUP_ADMIN, USER_GROUP_SHOP_OWNER),
                        'children' => Array(
                                Array('title' => $lang->getMessage('msg.itemList'),
                                        'icon' => 'itemList',
                                        'groups' => Array(USER_GROUP_ADMIN, USER_GROUP_SHOP_OWNER),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'items'))),
                                Array('title' => $lang->getMessage('msg.createItem'),
                                        'icon' => 'itemAdd',
                                        'groups' => Array(USER_GROUP_ADMIN, USER_GROUP_SHOP_OWNER),
                                        'url' => $urlCreator->createUrl(Array(
                                                Dzit_IUrlCreator::PARAM_MODULE => 'createItem'))))));
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::getViewName()
     */
    protected function getViewName() {
        return self::VIEW_NAME;
    }

    /**
     *
     * @see Vushop_Controller_BaseFlowController::buildModel_Custom()
     */
    protected function buildModel_Custom() {
        $model = parent::buildModel_Custom();
        if ($model == NULL) {
            $model = Array();
        }

        $model['menu'] = $this->buildMainMenu();

        return $model;
    }

    protected function buildMainMenu() {
        $menu = Array();

        foreach ($this->MENU as $menuItem) {
            $menuItem = $this->buildMenuItem($menuItem);
            if ($menuItem !== NULL) {
                $menu[] = $menuItem;
            }
        }
        while (count($menu) > 0 && $menu[0]['title'] === '-') {
            // make it look a bit less urgly if current user is not admin
            array_shift($menu);
        }

        return $menu;
    }

    protected function buildMenuItem($menuItem) {
        $userGroup = $this->getCurrentUserGroup();
        $allowedGroups = isset($menuItem['groups']) ? $menuItem['groups'] : NULL;
        if ($allowedGroups !== NULL && !in_array($userGroup, $allowedGroups)) {
            return NULL;
        }
        $menu = Array();
        $menu['title'] = $menuItem['title'];
        $menu['icon'] = isset($menuItem['icon']) ? $menuItem['icon'] : NULL;
        $menu['url'] = isset($menuItem['url']) ? $menuItem['url'] : NULL;
        $menu['children'] = Array();
        if (isset($menuItem['children'])) {
            foreach ($menuItem['children'] as $child) {
                $childItem = $this->buildMenuItem($child);
                if ($childItem !== NULL) {
                    $menu['children'][] = $childItem;
                }
            }
        }
        return $menu;
    }
}
