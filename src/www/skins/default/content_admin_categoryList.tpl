<!-- MIDDLE COLUMN -->
[:function name=displayCategoryTree level=0 category=NULL style="row-b":]
    <tr class="[:$style:]">
        <td>
            [:if $level gt 0:][:for $i=0 to $level:]&nbsp;[:/for:]+&nbsp;[:/if:]
            [:$category->getTitle()|escape:'html':]
        </td>
        <td style="text-align: center;" width="48px">
            <a href="[:$category->getUrlEdit():]"><img border="0" alt="" src="img/edit.png" /></a>
            <a href="[:$category->getUrlDelete():]"><img border="0" alt="" src="img/delete.png" /></a>
        </td>
        <td style="text-align: center;" width="48px">
            [:if $category@first:]
                <img border="0" alt="" width="16px" src="img/dot_background.gif" />
            [:else:]
                <a href="[:$category->getUrlMoveUp():]"><img border="0" alt="" src="img/moveup.png" /></a>
            [:/if:]
            [:if $category@last:]
                <img border="0" alt="" width="16px" src="img/dot_background.gif" />
            [:else:]
                <a href="[:$category->getUrlMoveDown():]"><img border="0" alt="" src="img/movedown.png" /></a>
            [:/if:]
        </td>
    </tr>
    [:if $style=='row-a':][:$childStyle='row-b':][:else:][:$childStyle='row-a':][:/if:]
    [:foreach $category->getChildren() as $child:]
        [:displayCategoryTree category=$child level=$level+1 style=$childStyle:]
    [:/foreach:]
[:/function:]
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-white">
        <div class="middle-column-box-title-blue">[:$MODEL.language->getMessage('msg.categories'):]</div>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th style="text-align: right;">
                        <a href="[:$MODEL.urlCreateCategory:]">[:$MODEL.language->getMessage('msg.createCategory'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th>[:$MODEL.language->getMessage('msg.category'):]</td>
                    <th width="96px" style="text-align: center;" colspan="2">[:$MODEL.language->getMessage('msg.actions'):]</td>
                </tr>
            </thead>
            <tbody>
            [:foreach $MODEL.categoryTree as $cat:]
                [:displayCategoryTree category=$cat:]
            [:foreachelse:]
                <tr>
                    <td colspan="3">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                </tr>
            [:/foreach:]
            </tbody>
        </table>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th style="text-align: right;">
                        <a href="[:$MODEL.urlCreateCategory:]">[:$MODEL.language->getMessage('msg.createCategory'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>