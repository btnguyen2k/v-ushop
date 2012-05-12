[:include file="inc_html_header.tpl":]
<body class="[:$DOJO_THEME:]" onload="initFrame();">
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
    <div dojoType="dijit.layout.BorderContainer" design="sidebar" gutters="true" id="main">
        <div dojoType="dijit.MenuBar" id="mainMenu" region="top">
            <div dojoType="dijit.MenuBarItem" onclick="window.location.href='[:$MODEL.urlHome:]';">
                <strong>[:$MODEL.APP_NAME:]</strong>
            </div>
            |
            <!-- MENU: Site Management -->
            <div dojoType="dijit.PopupMenuBarItem">
                <span>[:$MODEL.language->getMessage('msg.siteManagement'):]</span>
                <div dojoType="dijit.Menu">
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlSiteSettings:]');">[:$MODEL.language->getMessage('msg.siteSettings'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlEmailSettings:]');">[:$MODEL.language->getMessage('msg.emailSettings'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCatalogSettings:]');">[:$MODEL.language->getMessage('msg.catalogSettings'):]</div>
                </div>
            </div>
            <!-- MENU: Catalog Management -->
            <div dojoType="dijit.PopupMenuBarItem">
                <span>[:$MODEL.language->getMessage('msg.catalogManagement'):]</span>
                <div dojoType="dijit.Menu">
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCategoryManagement:]');">[:$MODEL.language->getMessage('msg.categoryList'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCreateCategory:]');">[:$MODEL.language->getMessage('msg.createCategory'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlItemManagement:]');">[:$MODEL.language->getMessage('msg.itemList'):]</div>
					<div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCreateItem:]');">[:$MODEL.language->getMessage('msg.createItem'):]</div>
                </div>
            </div>
			<!-- MENU: Page Management -->
            <div dojoType="dijit.PopupMenuBarItem">
                <span>[:$MODEL.language->getMessage('msg.pageManagement'):]</span>
                <div dojoType="dijit.Menu">
					<div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlPageManagement:]');">[:$MODEL.language->getMessage('msg.pageList'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCreatePage:]');">[:$MODEL.language->getMessage('msg.createPage'):]</div>
                </div>
            </div>
            <!-- MENU: Ads Management -->
            <div dojoType="dijit.PopupMenuBarItem">
                <span>[:$MODEL.language->getMessage('msg.adsManagement'):]</span>
                <div dojoType="dijit.Menu">
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlAdsManagement:]');">[:$MODEL.language->getMessage('msg.adsList'):]</div>
                    <div dojoType="dijit.MenuItem" onclick="loadUrl('[:$MODEL.urlCreateAds:]');">[:$MODEL.language->getMessage('msg.createAds'):]</div>
                </div>
            </div>
            |
            <div dojoType="dijit.MenuBarItem" onclick="window.location.href='[:$MODEL.urlLogout:]';">
                [:$LANG->getMessage('msg.logout'):]
            </div>
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
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="bottom" minSize="0" style="text-align: center;">
            [:$MODEL.APP_NAME:] [:$MODEL.APP_VERSION:] | <span id="siteCopyright">[:$MODEL.page.copyright:]</span>
        </div>
        <div dojoType="dijit.layout.ContentPane" id="mainContent" region="center" tabStrip="true" style="width: 100%; height: 100%; padding: 8px 10px 10px 8px">
			<iframe name="frameMainContent" style="width: 100%; height: 100%; border: 0px solid #009010" src="[:$MODEL.urlDashboard:]"></iframe>
        </div>
    </div>
</body>
[:include file="inc_html_footer.tpl":]
