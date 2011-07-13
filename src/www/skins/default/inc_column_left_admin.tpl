<!-- LEFT COLUMN --> <!-- Navigation -->
<div id="left-column">
    <ul>
        <li class="left-navheader-first">[:$MODEL.language->getMessage('msg.adminCp'):]</li>

        <li><a class="left-navheader" href="[:$MODEL.urlAdmin:]">[:$MODEL.language->getMessage('msg.siteManagement'):]</a></li>
        <!-- <li><a href="[:$MODEL.urlAdmin:]">[:$MODEL.language->getMessage('msg.adminCp'):]</a> -->
        <li><a href="[:$MODEL.urlSiteSettings:]">[:$MODEL.language->getMessage('msg.siteSettings'):]</a>
        <li><a href="[:$MODEL.urlEmailSettings:]">[:$MODEL.language->getMessage('msg.emailSettings'):]</a>

        <li><a class="left-navheader" href="[:$MODEL.urlCategoryManagement:]">[:$MODEL.language->getMessage('msg.catalogManagement'):]</a></li>
        <li><a href="[:$MODEL.urlCategoryManagement:]">[:$MODEL.language->getMessage('msg.categoryList'):]</a>
        <li><a href="[:$MODEL.urlCreateCategory:]">[:$MODEL.language->getMessage('msg.createCategory'):]</a>
        <li><a href="[:$MODEL.urlItemManagement:]">[:$MODEL.language->getMessage('msg.itemList'):]</a>
        <li><a href="[:$MODEL.urlCreateItem:]">[:$MODEL.language->getMessage('msg.createItem'):]</a>
        <li><a class="left-navheader" href="[:$MODEL.urlPageManagement:]">[:$MODEL.language->getMessage('msg.pageManagement'):]</a></li>
        <li><a href="[:$MODEL.urlCreatePage:]">[:$MODEL.language->getMessage('msg.createPage'):]</a>
    </ul>
</div>
