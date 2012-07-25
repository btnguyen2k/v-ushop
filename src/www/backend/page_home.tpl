[:include file="inc_html_header.tpl":]
<body class="[:$DOJO_THEME:]" onload="initFrame();">
    <style type="text/css">
    .vcatalogIconSiteSettings {
        background-image: url('icon/iconSiteSettings.png'); width: 16px; height: 16px;
    }
    .vcatalogIconEmailSettings {
        background-image: url('icon/iconEmailSettings.png'); width: 16px; height: 16px;
    }
    .vcatalogIconCatalogSettings {
        background-image: url('icon/iconCatalogSettings.png'); width: 16px; height: 16px;
    }
    .vcatalogIconPageList {
        background-image: url('icon/iconPageList.png'); width: 16px; height: 16px;
    }
    .vcatalogIconPageAdd {
        background-image: url('icon/iconPageAdd.png'); width: 16px; height: 16px;
    }
    .vcatalogIconCategoryList {
        background-image: url('icon/iconCategoryList.png'); width: 16px; height: 16px;
    }
    .vcatalogIconCategoryAdd {
        background-image: url('icon/iconCategoryAdd.png'); width: 16px; height: 16px;
    }
    .vcatalogIconItemList {
        background-image: url('icon/iconItemList.png'); width: 16px; height: 16px;
    }
    .vcatalogIconItemAdd {
        background-image: url('icon/iconItemAdd.png'); width: 16px; height: 16px;
    }
    .vcatalogIconAdsList {
        background-image: url('icon/iconAdsList.png'); width: 16px; height: 16px;
    }
    .vcatalogIconAdsAdd {
        background-image: url('icon/iconAdsAdd.png'); width: 16px; height: 16px;
    }
 	.vcatalogIconUserList {
        background-image: url('icon/iconUserList.png'); width: 16px; height: 16px;
    }
    .vcatalogIconUserAdd {
        background-image: url('icon/iconUserAdd.png'); width: 16px; height: 16px;
    }
    </style>
    <script type="text/javascript">
    function loadUrl(url) {
        window.frameMainContent.location.href = url;
    }
    function refreshFrame() {
        window.frameMainContent.location.reload(true);
    }
    function goBack() {
        history.go(-1);
    }
    function goForward() {
        history.go(1);
    }
    function initFrame() {
        if (URL_PARAMS.url != undefined) {
            window.frameMainContent.location.href = URL_PARAMS.url;
        }        
    }
    </script>
    [:function name="displayMainMenu" mainMenu=NULL:]
        [:foreach $mainMenu as $menuItem:]
            [:if count($menuItem.children) gt 0:]
                [:call name="displaySubMenuBar" menu=$menuItem:]
            [:else:]
                [:call name="displayMenuBarItem" menuItem=$menuItem:]
            [:/if:]
        [:/foreach:]
    [:/function:]
    
    [:function name="displaySubMenuBar" menu=NULL:]
        <div dojoType="dijit.PopupMenuBarItem">
            <span>[:$menu.title:]</span>
            <div dojoType="dijit.Menu">
                [:foreach $menu.children as $child:]
                    [:call name="displayMenuItem" menuItem=$child:]
                [:/foreach:]
            </div>
        </div>
    [:/function:]
    
    [:function name="displayMenuBarItem" menuItem=NULL:]
        [:if $menuItem.title=='-':]
            |
        [:else:]
            <div dojoType="dijit.MenuBarItem" [:if isset($menuItem.url):]onclick="loadUrl('[:$menuItem.url:]');"[:/if:]>
                <span>[:$menuItem.title:]</span>
            </div>
        [:/if:]
    [:/function:]
    
    [:function name="displayMenuItem" menuItem=NULL:]
        [:if $menuItem.title=='-':]
            <div dojoType="dijit.MenuSeparator"></div>
        [:else:]
            <div dojoType="dijit.MenuItem" 
                [:if isset($menuItem.icon):]iconClass="vcatalogIcon[:ucfirst($menuItem.icon):]"[:/if:]
                [:if isset($menuItem.url):]onclick="loadUrl('[:$menuItem.url:]');"[:/if:]>[:$menuItem.title:]</div>
        [:/if:]
    [:/function:]
    <div dojoType="dijit.layout.BorderContainer" design="sidebar" gutters="true" id="main">
        <div dojoType="dijit.MenuBar" id="mainMenu" region="top">
            <div dojoType="dijit.MenuBarItem" onclick="window.location.href='[:$MODEL.urlHome:]/../../';"
                ><img src="icon/iconHome.png"
            /></div>
            <div dojoType="dijit.MenuBarItem" onclick="window.location.href='[:$MODEL.urlHome:]';">
                <strong>[:$MODEL.APP_NAME:]</strong>
            </div>
            |
            [:call name="displayMainMenu" mainMenu=$MODEL.menu:]
            |
            <div dojoType="dijit.MenuBarItem" onclick="refreshFrame();">
                <img border="0" alt="" src="img/refresh.png" title="Refresh Page"/>
            </div>
            <div dojoType="dijit.MenuBarItem" onclick="goBack();">
                <img border="0" alt="" src="img/arrow_left.png" title="Go Back" />
            </div>
            <div dojoType="dijit.MenuBarItem" onclick="goForward();">
                <img border="0" alt="" src="img/arrow_right.png" title="Go Forward"/>
            </div>
            |
            <div style="margin-top: 8px; margin-right: 8px; float: right;">
                [:$MODEL.language->getMessage('msg.welcome'):] <strong><a href="[:$USER->getUrlProfile():]" onclick="loadUrl('[:$USER->getUrlProfile():]');">[:$USER->getDisplayName()|escape:'html':]</a></strong>
                |
                <a href="[:$MODEL.urlLogout:]">[:$LANG->getMessage('msg.logout'):]</a>
            </div>
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="bottom" minSize="0" style="text-align: center;">
            [:$MODEL.APP_NAME:] [:$MODEL.APP_VERSION:] | <span id="siteCopyright">[:$MODEL.page.copyright:]</span>
        </div>
        [:if isset($MODEL.debug):]
            <div dojoType="dijit.layout.TabContainer" region="center" tabStrip="true" style="width: 100%; height: 100%; padding: 8px 10px 10px 8px">
                <div dojoType="dijit.layout.ContentPane" id="mainContent" style="width: 100%; height: 100%; padding: 8px 10px 10px 8px" title="[:$MODEL.language->getMessage('msg.adminCp'):]">
                    <iframe name="frameMainContent" style="width: 100%; height: 100%; border: 0px solid #009010" src="[:$MODEL.urlDashboard:]"></iframe>
                </div>
                <div dojoType="dijit.layout.ContentPane" id="debugInfo" style="width: 100%; height: 100%; padding: 8px 10px 10px 8px" title="Debug Info">
                </div>
            </div>
        [:else:]
            <div dojoType="dijit.layout.ContentPane" id="mainContent" region="center" tabStrip="true" style="width: 100%; height: 100%; padding: 8px 10px 10px 8px">
                <iframe name="frameMainContent" style="width: 100%; height: 100%; border: 0px solid #009010" src="[:$MODEL.urlDashboard:]"></iframe>
            </div>
        [:/if:]  
    </div>
</body>
[:include file="inc_html_footer.tpl":]
