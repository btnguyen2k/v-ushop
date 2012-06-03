[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]" style="height: 100%; width: 100%; position: absolute;" id="myBody">
    <!--
    <h1 class="heading align-center">[:$MODEL.language->getMessage('msg.dashboard'):]</h1>
    -->
    [:function name=displayCategoryTree level=0 category=NULL style="row-b" first=FALSE last=FALSE:]
        <tr class="[:$style:]" style="width: 100%">
            <td>
                [:if $level gt 0:][:for $i=0 to $level:]&nbsp;[:/for:]+&nbsp;[:/if:]
                [:$category->getTitle()|escape:'html':]
            </td>
            <td style="text-align: center;" width="36px">
                <a href="[:$category->getUrlEdit():]"><img border="0" alt="" src="img/edit.png" /></a>
                [:if count($category->getChildren()) gt 0:]
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                [:else:]
                    <a href="[:$category->getUrlDelete():]"><img border="0" alt="" src="img/delete.png" /></a>
                [:/if:]
            </td>
            <td style="text-align: center;" width="36px">
                [:if $first:]
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                [:else:]
                    <a href="[:$category->getUrlMoveUp():]"><img border="0" alt="" src="img/moveup.png" /></a>
                [:/if:]
                [:if $last:]
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                [:else:]
                    <a href="[:$category->getUrlMoveDown():]"><img border="0" alt="" src="img/movedown.png" /></a>
                [:/if:]
            </td>
        </tr>
        [:if $style=='row-a':][:$childStyle='row-b':][:else:][:$childStyle='row-a':][:/if:]
        [:foreach $category->getChildren() as $child:]
            [:displayCategoryTree category=$child level=$level+1 style=$childStyle first=$child@first last=$child@last:]
        [:/foreach:]
    [:/function:]
    <div style="float: left; width: 33%; height: 85%; position: static;">
        <h2 class="heading">[:$MODEL.language->getMessage('msg.gpv.vcatalog'):]</h2>
        <table cellpadding="0" class="align-center" style="width: 100%; margin: 0px; padding: 0px;">
        <tr>
            <td width="100px">
                <a href="[:$MODEL.urlCategoryManagement:]">[:$MODEL.language->getMessage('msg.numCategories'):]</a>: <strong>[:$MODEL.numCategories:]</strong>
            </td>
            <td>
                [:call name='percentBar' width='100%' percent=$MODEL.percentCategories:]
            </td>
        </tr>
        <tr>
            <td>
                <a href="[:$MODEL.urlItemManagement:]">[:$MODEL.language->getMessage('msg.numItems'):]</a>: <strong>[:$MODEL.numItems:]</strong>
            </td>
            <td>
                [:call name='percentBar' width='100%' percent=$MODEL.percentItems:]
            </td>
        </tr>
        <tr>
            <td>
                <a href="[:$MODEL.urlPageManagement:]">[:$MODEL.language->getMessage('msg.numPages'):]</a>: <strong>[:$MODEL.numPages:]</strong>
            </td>
            <td>
                [:call name='percentBar' width='100%' percent=$MODEL.percentPages:]
            </td>
        </tr>
        </table>
    </div>
    <div style="float: left; margin-left: 0.5%; margin-right: 0.5%; width: 33%; height: 85%; position: static;">
        <h2 class="heading">[:$MODEL.language->getMessage('msg.catalogManagement'):]</h2>
        <div style="margin-bottom: 4px;">
            <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateCategory:]');">[:$MODEL.language->getMessage('msg.createCategory'):]</button>
            [[:$MODEL.language->getMessage('msg.numCategories'):]: <strong>[:$MODEL.numCategories:]</strong>]
            [[:$MODEL.language->getMessage('msg.numItems'):]: <strong>[:$MODEL.numItems:]</strong>]
        </div>
        <div style="margin: 0px; padding: 0px; height: 100%; overflow: auto;">
            <table cellpadding="0" class="align-center" style="width: 100%; margin: 0px; padding: 0px;">
                <tbody>
                    [:foreach $MODEL.categoryTree as $cat:]
                        [:displayCategoryTree category=$cat first=$cat@first last=$cat@last:]
                    [:foreachelse:]
                        <tr>
                            <td colspan="3">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                        </tr>
                    [:/foreach:]
                </tbody>
            </table>
        </div>    
    </div>
    <div style="float: left; width: 33%; height: 85%; position: static;">
        <h2 class="heading">[:$MODEL.language->getMessage('msg.pageManagement'):]</h2>
        <div style="margin-bottom: 4px;">
            <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreatePage:]');">[:$MODEL.language->getMessage('msg.createPage'):]</button>
            [[:$MODEL.language->getMessage('msg.numPages'):]: <strong>[:$MODEL.numPages:]</strong>]
        </div>
        <div style="margin: 0px; padding: 0px; height: 100%; overflow: auto;">
            <table cellpadding="0" class="align-center" style="width: 100%; margin: 0px; padding: 0px;">
            <tbody>
                [:foreach $MODEL.pageList as $page:]
                    <tr class="[:if $page@index%2==0:]row-a[:else:]row-a[:/if:]">
                        <td width="96px">
                            [:$page->category|escape:'html':]
                        </td>
                        <td>
                            <a href="[:$page->urlView:]" target="_blank">[:$page->title|escape:'html':]</a>
                        </td>
                        <td style="text-align: center;" width="36px">
                            <a href="[:$page->urlEdit:]"><img border="0" alt="" src="img/edit.png" /></a>
                            <a href="[:$page->urlDelete:]"><img border="0" alt="" src="img/delete.png" /></a>
                            [:if $page->onMenu:]
                                <img border="0" alt="" src="img/arrow_down.png" />
                            [:else:]
                                <img border="0" alt="" src="img/arrow_up.png" />
                            [:/if:]
                        </td>
                    </tr>
                [:foreachelse:]
                    <tr>
                        <td colspan="2">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                    </tr>
                [:/foreach:]
            </tbody>
            </table>
        </div>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
