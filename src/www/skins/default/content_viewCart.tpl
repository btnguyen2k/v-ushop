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
            <th>[:$MODEL.language->getMessage('msg.item'):]</th>
            <th width="64px">[:$MODEL.language->getMessage('msg.price'):]</th>
            <th width="160px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
            <th width="80px">[:$MODEL.language->getMessage('msg.total'):]</th>
        </thead>
        <tbody>
            [:assign var='_grandTotal' value=0:]
            [:foreach $MODEL.cart->getItems() as $item:]
                <tr>
                    <td>[:$item->getTitle()|escape:'html':]</td>
                    <td align="right">[:number_format($item->getPrice(), 2, '.', ','):]</td>
                    <td>
                        <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/updateCart">
                            <input type="hidden" name="item" value="[:$item->getId():]"/>
                            <input style="margin-top: auto; margin-bottom: auto; width: 64px" type="text" name="quantity" value="[:$item->getQuantity():]"/>
                            <input type="image" src="img/cart_edit.png" align="top" title="[:$MODEL.language->getMessage('msg.update'):]"/>
                            <!--
                            <input style="margin-top: auto; margin-bottom: auto; font-size: xx-small;" type="submit" value="[:$MODEL.language->getMessage('msg.update'):]" />
                            -->
                        </form>
                    </td>
                    <td align="right">[:number_format($item->getPrice()*$item->getQuantity(), 2, '.', ','):]</td>
                    [:assign var='_grandTotal' value=$_grandTotal+$item->getPrice()*$item->getQuantity():]
                </tr>
            [:foreachelse:]
                <tr>
                    <td colspan="4">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                </tr>
            [:/foreach:]
        </tbody>
        <tfoot>
            <tr>
                <th colspan="3">[:$MODEL.language->getMessage('msg.grandTotal'):]</th>
                <th style="text-align: right;">[:number_format($_grandTotal, 2, ',', '.'):]</th>
            </tr>
        </tfoot>
        </table>
        <p align="center">
            <a href="[:$MODEL.cart->getUrlCheckout():]"><img src="img/cart_go.png" border="0"/> [:$MODEL.language->getMessage('msg.checkout'):]</a>
        </p>
    </div>
</div>
