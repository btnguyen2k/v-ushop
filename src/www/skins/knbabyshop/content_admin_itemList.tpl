<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-white">
        <div class="middle-column-box-title-blue">[:$MODEL.language->getMessage('msg.items'):]</div>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th style="text-align: center;">
                        <script type="text/javascript">
                        //<![CDATA[
                        function refreshView(form) {
                            form.submit();
                        }
                        //]]>
                        </script>
                        <form action="[:$smarty.server.SCRIPT_NAME:]/admin/items" method="get">
                            [:$MODEL.language->getMessage('msg.category'):]:
                            <select name="c" onchange="refreshView(this.form);">
                                [:if isset($MODEL.objCategory):]
                                    <option value="0">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                                    [:displayCategoryTreeForSelectBox categoryTree=$MODEL.categoryTree selectedIndex=$MODEL.objCategory->getId():]
                                [:else:]
                                    <option value="0" style="font-weight: bold;">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                                    [:displayCategoryTreeForSelectBox categoryTree=$MODEL.categoryTree:]
                                [:/if:]
                            </select>
                            <input type="hidden" name="p" value="1" />
                            <p>
                                [:$MODEL.language->getMessage('msg.page'):]:
                                [:for $tmp=1 to $MODEL.paginator->getNumPages():]
                                    [:if $tmp==$MODEL.paginator->getCurrentPage():]
                                        &nbsp;<big>[:$tmp:]</big>&nbsp;
                                    [:else:]
                                        &nbsp;<a href="[:$MODEL.paginator->getUrlForPage($tmp):]">[:$tmp:]</a>&nbsp;
                                    [:/if:]
                                [:/for:]
                            </p>
                        </form>
                    </th>
                </tr>
            </thead>
        </table>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th>[:$MODEL.language->getMessage('msg.item'):]</td>
                    <th width="96px" style="text-align: center;">[:$MODEL.language->getMessage('msg.category'):]</th>
                    <th width="80px" style="text-align: center;">[:$MODEL.language->getMessage('msg.actions'):]</td>
                </tr>
            </thead>
            <tbody>
            [:foreach $MODEL.itemList as $item:]
                <tr class="[:if $item@index%2==0:]row-a[:else:]row-a[:/if:]">
                    <td>
                        [:if $item->isHotItem():]
                            <span class="hot">[:$MODEL.language->getMessage('msg.hot'):]</span>
                        [:/if:]
                        <a href="[:$item->getUrlView():]" target="_blank">[:$item->getTitle()|escape:'html':]</a>
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
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th style="text-align: center;">
                        <a href="[:$MODEL.urlCreateItem:]">[:$MODEL.language->getMessage('msg.createItem'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
