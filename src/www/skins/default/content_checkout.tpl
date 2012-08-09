<!-- MIDDLE COLUMN -->
<!-- Middle column full box -->
<div id="main">
	<h1>[:$MODEL.language->getMessage('msg.cart'):]</h1>
	<br></br>
        <table class="table" cellpadding="0" cellspacing="0" border="0" align="center">
    	<thead class="table-header">  
        	<tr>        		
        		
        		<th width="30px">[:$MODEL.language->getMessage('msg.stt'):]</th>
        		<th >[:$MODEL.language->getMessage('msg.item'):]</th>
        		<th style="text-align: right;" >[:$MODEL.language->getMessage('msg.item.price'):]</th>            		
        		<th style="text-align: center;width: 80px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
        		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.total'):]</th>
        	</tr>
        </thead>
        <tbody>
        [:foreach $MODEL.cart->getItems() as $item:]
        	<tr class="[:if $item@index % 2 ==0:]even[:else:]odd[:/if:]">
        		<td align="center">[:$item@index+1:]</td>
        		<td style="white-space: normal;">[:$item->getTitle()|escape:'html':]</td>        		
				<td style="text-align: right;">[:$item->getPriceForDisplay():]</td>
        		<td style="text-align: center;">[:$item->getQuantity():] </td>
        		<td style="text-align: right;font-size: 14px">[:$item->getTotalForDisplay():]</td>
        	</tr>
        [:foreachelse:]
            <tr>
                <td colspan="5">[:$MODEL.language->getMessage('msg.nodata'):]</td>
            </tr>
        [:/foreach:]
        </tbody>
        <tfoot>  
        	<tr class="table-header">        		
        		<th colspan="4" style="text-align: right;font-size: 14px">[:$MODEL.language->getMessage('msg.grandTotal'):] : </th>
        		<th style="text-align: right;font-size: 14px" >[:$MODEL.cart->getGrandTotalForDisplay():]</th>
        		
        	</tr>
        </tfoot>
    </table>
    <br/>
	<button class="btn btn-warning" onclick="redirect('[:$MODEL.cart->getUrlView():]')" >[:$MODEL.language->getMessage('msg.editCart'):]</button>
 <h1>[:$MODEL.language->getMessage('msg.checkout'):]</h1>
 <br/>
<form method="post" style="text-align: left;" action="[:$MODEL.form.action:]" name="[:$MODEL.form.name|escape:'html':]">
    [:printFormHeader form=$MODEL.form:]
    <label class="lable-css">[:$MODEL.language->getMessage('msg.order.name'):]:</label>
    <input type="text" name="orderName" value="[:$MODEL.form.orderName|escape:'html':]" style="width: 98%" />
    <br/>
    <label class="lable-css">[:$MODEL.language->getMessage('msg.order.email'):]:</label>
    <input type="text" name="orderEmail" value="[:$MODEL.form.orderEmail|escape:'html':]" style="width: 98%" />
    <br/>
    <label class="lable-css">[:$MODEL.language->getMessage('msg.order.phone'):]:</label>
    <input type="text" name="orderPhone" value="[:$MODEL.form.orderPhone|escape:'html':]" style="width: 98%" />
    <br/>
    <label style="display: inline;" class="lable-css">[:$MODEL.language->getMessage('msg.order.paymentMethod'):]:</label>
    <input [:if $MODEL.form.orderPaymentMethod==0:]checked="checked"[:/if:] type="radio" name="orderPaymentMethod" value="0" />
        [:$MODEL.language->getMessage('msg.order.paymentMethod.cash'):]
    <input  [:if $MODEL.form.orderPaymentMethod==1:]checked="checked"[:/if:] type="radio" name="orderPaymentMethod" value="1" />
        [:$MODEL.language->getMessage('msg.order.paymentMethod.transfer'):]
    <br />
    <label class="lable-css">[:$MODEL.language->getMessage('msg.order.otherInfo'):]:</label>
    <textarea rows="6" style="width: 98%" name="orderOtherInfo">[:$MODEL.form.orderOtherInfo|escape:'html':]</textarea>
    <input type="submit" class="btn btn-warning" value="[:$MODEL.language->getMessage('msg.checkout'):]" />
    <input type="button" class="btn btn-warning" onclick="javascript:location.href='[:$MODEL.form.actionCancel:]';"
        value="[:$MODEL.language->getMessage('msg.cancel'):]"  />
</form>
</div>