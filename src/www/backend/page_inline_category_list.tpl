[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.categoryList'):]</h1>
    [:function name=displayCategoryTree level=0 category=NULL style="row-b" first=FALSE last=FALSE:]
        <tr class="[:$style:]">
            <td>
                [:if $level gt 0:][:for $i=0 to $level:]&nbsp;[:/for:]+&nbsp;[:/if:]
                [:$category->getTitle()|escape:'html':]
            </td>
            <td style="text-align: center;" width="48px">
                <a href="[:$category->getUrlEdit():]"><img border="0" alt="" src="img/edit.png" /></a>
                [:if count($category->getChildren()) gt 0:]
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                [:else:]
                    <a href="[:$category->getUrlDelete():]"><img border="0" alt="" src="img/delete.png" /></a>
                [:/if:]
            </td>
            <td style="text-align: center;" width="48px">
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
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateCategory:]');">[:$MODEL.language->getMessage('msg.createCategory'):]</button></td>
    </div>
    <table cellpadding="2" class="align-center viewport-800">
    <thead>
        <tr>
            <th>[:$MODEL.language->getMessage('msg.category'):]</td>
            <th width="96px" style="text-align: center;" colspan="2">[:$MODEL.language->getMessage('msg.actions'):]</td>
        </tr>
    </thead>
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
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateCategory:]');">[:$MODEL.language->getMessage('msg.createCategory'):]</button></td>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
