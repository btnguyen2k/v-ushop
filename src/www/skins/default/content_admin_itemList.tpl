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
                    <th style="text-align: right;">
                        <a href="[:$MODEL.urlCreateItem:]">[:$MODEL.language->getMessage('msg.createItem'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
        <table cellpadding="2" style="width: 90%; margin-left: auto; margin-right: auto">
            <thead>
                <tr>
                    <th>[:$MODEL.language->getMessage('msg.page'):]</td>
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
                    <th style="text-align: right;">
                        <a href="[:$MODEL.urlCreateItem:]">[:$MODEL.language->getMessage('msg.createItem'):]</a>
                    </th>
                </tr>
            </thead>
        </table>
    </div>
</div>
