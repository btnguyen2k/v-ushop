[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.pageList'):]</h1>
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreatePage:]');">[:$MODEL.language->getMessage('msg.createPage'):]</button>
    </div>
    
    <table cellpadding="2" class="align-center viewport-800">
    <thead>
        <tr>
            <th colspan="2">[:$MODEL.language->getMessage('msg.page'):]</th>
            <th width="112px" style="text-align: center;" colspan="2">[:$MODEL.language->getMessage('msg.actions'):]</th>
        </tr>
    </thead>
    <tbody>
        [:foreach $MODEL.pageList as $page:]
            <tr class="[:if $page@index%2==0:]row-a[:else:]row-a[:/if:]">
                <td width="96px">
                    [:$page->category|escape:'html':]
                </td>
                <td>
                    <a href="[:$page->urlView:]" target="_blank">[:$page->title|escape:'html':]</a>
                </td>
                <td style="text-align: center;" width="64px">
                    <a href="[:$page->urlEdit:]"><img border="0" alt="" src="img/edit.png" /></a>
                    <a href="[:$page->urlDelete:]"><img border="0" alt="" src="img/delete.png" /></a>
                    [:if $page->onMenu:]
                        <img border="0" alt="" src="img/arrow_down.png" />
                    [:else:]
                        <img border="0" alt="" src="img/arrow_up.png" />
                    [:/if:]
                </td>
                <td style="text-align: center;" width="48px">
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                    <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                    <!--
                    [:if $page@first:]
                        <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                    [:else:]
                        <a href="[:$page->urlMoveUp:]"><img border="0" alt="" src="img/moveup.png" /></a>
                    [:/if:]
                    [:if $page@last:]
                        <img border="0" alt="" width="16px" src="img/dot_background.gif" />
                    [:else:]
                        <a href="[:$page->urlMoveDown:]"><img border="0" alt="" src="img/movedown.png" /></a>
                    [:/if:]
                    -->
                </td>
            </tr>
        [:foreachelse:]
            <tr>
                <td colspan="3">[:$MODEL.language->getMessage('msg.nodata'):]</td>
            </tr>
        [:/foreach:]
        </tbody>
    </table>
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreatePage:]');">[:$MODEL.language->getMessage('msg.createPage'):]</button>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
