<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.checkout'):]</div>
        <table style="width: 95%; margin-left: auto; margin-right: auto; font-size: smaller;">
        <thead>
            <th style="text-align: center;">[:$MODEL.language->getMessage('msg.item'):]</th>
            <th style="text-align: center;" width="64px">[:$MODEL.language->getMessage('msg.price'):]</th>
            <th style="text-align: center;" width="64px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
            <th style="text-align: center;" width="100px">[:$MODEL.language->getMessage('msg.total'):]</th>
        </thead>
        <tbody>
            [:assign var='_grandTotal' value=0:]
            [:foreach $MODEL.cart->getItems() as $item:]
                <tr>
                    <td>[:$item->getTitle()|escape:'html':]</td>
                    <td align="right">[:number_format($item->getPrice(), 2, '.', ','):]</td>
                    <td align="center">[:$item->getQuantity():]</td>
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
                <th style="text-align: center;" colspan="3">[:$MODEL.language->getMessage('msg.grandTotal'):]</th>
                <th style="text-align: right;">[:number_format($_grandTotal, 2, ',', '.'):]</th>
            </tr>
        </tfoot>
        </table>

        <form method="post" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
            [:printFormHeader form=$MODEL.form:]
            <label>[:$MODEL.language->getMessage('msg.order.name'):]:</label>
            <input type="text" name="orderName" value="[:$MODEL.form.orderName|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.order.email'):]:</label>
            <input type="text" name="orderEmail" value="[:$MODEL.form.orderEmail|escape:'html':]" style="width: 98%" />
            <br/>
            <label>[:$MODEL.language->getMessage('msg.order.phone'):]:</label>
            <input type="text" name="orderPhone" value="[:$MODEL.form.orderPhone|escape:'html':]" style="width: 98%" />
            <br/>
            <label style="display: inline;">[:$MODEL.language->getMessage('msg.order.paymentMethod'):]:</label>
            <input [:if $MODEL.form.orderPaymentMethod==0:]checked="checked"[:/if:] type="radio" name="orderPaymentMethod" value="0" />
                [:$MODEL.language->getMessage('msg.order.paymentMethod.cash'):]
            <input [:if $MODEL.form.orderPaymentMethod==1:]checked="checked"[:/if:] type="radio" name="orderPaymentMethod" value="1" />
                [:$MODEL.language->getMessage('msg.order.paymentMethod.transfer'):]
            <br /><br />
            <label>[:$MODEL.language->getMessage('msg.order.otherInfo'):]:</label>
            <textarea rows="6" style="width: 98%" name="orderOtherInfo">[:$MODEL.form.orderOtherInfo|escape:'html':]</textarea>
            <input type="submit" value="[:$MODEL.language->getMessage('msg.checkout'):]" style="width: 64px" />
            <input type="button" onclick="javascript:location.href='[:$MODEL.form.actionCancel:]';"
                value="[:$MODEL.language->getMessage('msg.cancel'):]" style="width: 64px" />
        </form>
    </div>
</div>