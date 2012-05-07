[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.itemList'):]</h1>

    <script type="text/javascript">
        function refreshView(form) {
            form.submit();
        }
    </script>
    
    <form dojoType="dijit.form.Form" id="form_itemList" class="align-center viewport-800"
            name="form_itemList" action="[:$smarty.server.SCRIPT_NAME:]/items" method="get">
        <input dojoType="dijit.form.CheckBox" type="checkbox" [:if isset($MODEL.featuredItemsOnly):]checked="checked"[:/if:]
            name="f" value="1" onchange="refreshView(document.form_itemList);" />
        [:$MODEL.language->getMessage('msg.onlyFeaturedItems'):]
        &nbsp;&nbsp;|&nbsp;&nbsp;
        [:$MODEL.language->getMessage('msg.category'):]:
        <select name="c" onchange="refreshView(this.form);">
            [:if isset($MODEL.objCategory):]
                <option value="0">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                [:call name="displayCategoryTreeForSelectBox" categoryTree=$MODEL.categoryTree selectedIndex=$MODEL.objCategory->getId():]
            [:else:]
                <option value="0" style="font-weight: bold;">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                [:call name="displayCategoryTreeForSelectBox" categoryTree=$MODEL.categoryTree:]
            [:/if:]
        </select>
        <input type="hidden" name="p" value="1" />
        <div class="align-center viewport-800">
            <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateItem:]');">[:$MODEL.language->getMessage('msg.createItem'):]</button>
            |
            [:$MODEL.language->getMessage('msg.page'):]:
            [:foreach $MODEL.paginator->getVisiblePages() as $_page:]
                [:if $_page==0:]
                    &nbsp;<big>...</big>&nbsp;
                [:elseif $_page==$MODEL.paginator->getCurrentPage():]
                    &nbsp;<big>[:$_page:]</big>&nbsp;
                [:else:]
                    &nbsp;<button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.paginator->getUrlForPage($_page):]')">[:$_page:]</button>&nbsp;
                    <!-- &nbsp;<a href="[:$MODEL.paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp; -->
                [:/if:]
            [:/foreach:]
        </div>
        
        <table cellpadding="2" class="align-center viewport-800">
        <thead>
            <tr>
                <th>[:$MODEL.language->getMessage('msg.item'):]</th>
                <th width="96px" style="text-align: center;">[:$MODEL.language->getMessage('msg.category'):]</th>
                <th width="80px" style="text-align: center;">[:$MODEL.language->getMessage('msg.actions'):]</th>
            </tr>
        </thead>
        <tbody>
            [:foreach $MODEL.itemList as $item:]
                <tr class="[:if $item@index%2==0:]row-a[:else:]row-a[:/if:]">
                    <td>
                        [:if $item->isHotItem():]
                            <span class="hot">[:$MODEL.language->getMessage('msg.hot'):]</span>
                        [:/if:]
                        [:if $item->isNewItem():]
                            <span class="new">[:$MODEL.language->getMessage('msg.new'):]</span>
                        [:/if:]
                        <big><a href="[:$item->getUrlView():]" target="_blank">[:$item->getTitle()|escape:'html':]</a></big>
                        <br />
                        <small>
                            [:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$item->getVendor()|escape:'html':]</strong>
                            |
                            [:$MODEL.language->getMessage('msg.item.price'):]: <strong>[:number_format($item->getPrice(), 2, ',', '.'):]</strong>
                        </small>
                    </td>
                    <td>
                        <small>
                            [:if $item->getCategory()!==NULL:]
                                [:$item->getCategory()->getTitle()|escape:'html':]
                            [:else:]
                                &nbsp;
                            [:/if:]
                        </small>
                    </td>
                    <td style="text-align: center;" width="64px">
                        <a href="[:$item->getUrlEdit():]"><img border="0" alt="" src="img/edit.png" /></a>
                        <a href="[:$item->getUrlDelete():]"><img border="0" alt="" src="img/delete.png" /></a>
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
            <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateItem:]');">[:$MODEL.language->getMessage('msg.createItem'):]</button>
            |
            [:$MODEL.language->getMessage('msg.page'):]:
            [:foreach $MODEL.paginator->getVisiblePages() as $_page:]
                [:if $_page==0:]
                    &nbsp;<big>...</big>&nbsp;
                [:elseif $_page==$MODEL.paginator->getCurrentPage():]
                    &nbsp;<big>[:$_page:]</big>&nbsp;
                [:else:]
                    &nbsp;<button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.paginator->getUrlForPage($_page):]')">[:$_page:]</button>&nbsp;
                    <!-- &nbsp;<a href="[:$MODEL.paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp; -->
                [:/if:]
            [:/foreach:]
        </div>
    </form>
</body>
[:include file="inc_inline_html_footer.tpl":]
