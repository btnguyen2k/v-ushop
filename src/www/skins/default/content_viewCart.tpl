<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-blue">
        <div class="middle-column-box-title-blue">[:$MODEL.language->getMessage('msg.cart'):]</div>
        <table style="width: 95%; margin-left: auto; margin-right: auto">
        <thead>
            <th style="text-align: center;">[:$MODEL.language->getMessage('msg.item'):]</th>
            <th width="100px" style="text-align: center;">[:$MODEL.language->getMessage('msg.price'):]</th>
            <th width="85px" style="text-align: center;">[:$MODEL.language->getMessage('msg.quantity'):]</th>
            <th width="140px" style="text-align: center;">[:$MODEL.language->getMessage('msg.total'):]</th>
        </thead>
        <tfoot>
            <tr>
                <th colspan="3">[:$MODEL.language->getMessage('msg.grandTotal'):]</th>
                <th style="text-align: right;">[:$MODEL.cart->getGrandTotalForDisplay():]</th>
            </tr>
        </tfoot>
        <tbody>
            [:foreach $MODEL.cart->getItems() as $item:]
                <tr>
                    <td>[:$item->getTitle()|escape:'html':]</td>
                    <td align="right">[:$item->getPriceForDisplay():]</td>
                    <td>
                        <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/updateCart">
                            <input type="hidden" name="item" value="[:$item->getId():]"/>
                            <input style="margin-top: auto; margin-bottom: auto; width: 40px" type="text" name="quantity" value="[:$item->getQuantity():]"/>
                            <input type="image" src="img/cart_edit.png" align="top" title="[:$MODEL.language->getMessage('msg.update'):]"/>
                            <!--
                            <input style="margin-top: auto; margin-bottom: auto; font-size: xx-small;" type="submit" value="[:$MODEL.language->getMessage('msg.update'):]" />
                            -->
                        </form>
                    </td>
                    <td align="right">[:$item->getTotalForDisplay():]</td>
                </tr>
            [:foreachelse:]
                <tr>
                    <td colspan="4">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                </tr>
            [:/foreach:]
        </tbody>
        </table>
        <p align="center">
            <a href="[:$MODEL.cart->getUrlCheckout():]"><img src="img/cart_go.png" border="0"/> [:$MODEL.language->getMessage('msg.checkout'):]</a>
            &nbsp;
            <a href="[:$smarty.server.SCRIPT_NAME:]"><img src="img/home.png" border="0"/> [:$MODEL.language->getMessage('msg.continueShopping'):]</a>
        </p>
    </div>
</div>
