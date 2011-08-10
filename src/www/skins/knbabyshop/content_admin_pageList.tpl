<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-white">
        <div class="middle-column-box-title-blue">[:$MODEL.language->getMessage('msg.pages'):]</div>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th style="text-align: right;">
                        <a href="[:$MODEL.urlCreatePage:]">[:$MODEL.language->getMessage('msg.createPage'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th>[:$MODEL.language->getMessage('msg.page'):]</td>
                    <th width="112px" style="text-align: center;" colspan="2">[:$MODEL.language->getMessage('msg.actions'):]</td>
                </tr>
            </thead>
            <tbody>
            [:foreach $MODEL.pageList as $page:]
                <tr class="[:if $page@index%2==0:]row-a[:else:]row-a[:/if:]">
                    <td>
                        <a href="[:$page->getUrlView():]" target="_blank">[:$page->getTitle()|escape:'html':]</a>
                    </td>
                    <td style="text-align: center;" width="64px">
                        <a href="[:$page->getUrlEdit():]"><img border="0" alt="" src="img/edit.png" /></a>
                        <a href="[:$page->getUrlDelete():]"><img border="0" alt="" src="img/delete.png" /></a>
                        [:if $page->getOnMenu():]
                            <a href="[:$page->getUrlUnpin():]"><img border="0" alt="" src="img/arrow_down.png" /></a>
                        [:else:]
                            <a href="[:$page->getUrlPin():]"><img border="0" alt="" src="img/arrow_up.png" /></a>
                        [:/if:]
                    </td>
                    <td style="text-align: center;" width="48px">
                        [:if $page@first:]
                            <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                        [:else:]
                            <a href="[:$page->getUrlMoveUp():]"><img border="0" alt="" src="img/moveup.png" /></a>
                        [:/if:]
                        [:if $page@last:]
                            <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                        [:else:]
                            <a href="[:$page->getUrlMoveDown():]"><img border="0" alt="" src="img/movedown.png" /></a>
                        [:/if:]
                    </td>
                </tr>
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
                        <a href="[:$MODEL.urlCreatePage:]">[:$MODEL.language->getMessage('msg.createPage'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
