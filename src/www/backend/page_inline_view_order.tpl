[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
[:if isset($MODEL.orderObj):]
	[:assign var="_order" value=$MODEL.orderObj:]
    <h1 class="heading align-center viewport-800">[:$LANG->getMessage('msg.orderInformation'):] - <span style="text-transform: uppercase;">[:$_order->getId()|escape:'html':]</span></h1>
		<div class="align-center viewport-800">
    			
           		<table class="align-center viewport-800" cellpadding="0" cellspacing="0" border="0px">        			
        			<tr>
        				<td class="lable" width="20%">[:$LANG->getMessage('msg.order.paymentMethod'):] :</td>
        				<td width="30%">
        					[:if $_order->getPaymentMethod():]
        						[:$LANG->getMessage('msg.order.paymentMethod.transfer'):]
        					[:else:]
        						[:$LANG->getMessage('msg.order.paymentMethod.cash'):]
        					[:/if:]
        				</td>         				
        				<td class="lable" width="20%">[:$LANG->getMessage('msg.order.name'):] :</td>
        				<td width="30%">[:$_order->getFullName()|escape:'html':]</td>
        			</tr>
        			<tr>
        				<td class="lable" width="20%">[:$LANG->getMessage('msg.order.email'):] :</td>
        				<td width="30%">[:$_order->getEmail()|escape:'html':]</td>
        				<td class="lable" width="20%">[:$LANG->getMessage('msg.order.phone'):] :</td>
        				<td width="30%">[:$_order->getPhone()|escape:'html':]</td>
        			</tr>
        			
        			<tr>
        				<td class="lable" colspan="4">[:$LANG->getMessage('msg.order.otherInfo'):] :
        				[:$_order->getAddress()|escape:'html':]</td>        				
        			</tr>
                </table> 
             [:/if:]
        <br />
        <h2 class="heading align-center viewport-800">[:$LANG->getMessage('msg.orderDetail'):]</h2>
        <br/>
         <table class="align-center viewport-800">
                <thead>
                   <thead class="table-header">  
            	<tr>        		
            		
            		<th width="30px">[:$MODEL.language->getMessage('msg.stt'):]</th>
            		<th >[:$MODEL.language->getMessage('msg.item'):]</th>
            		<th width="60px">[:$MODEL.language->getMessage('msg.image'):]</th>
            		<th style="text-align: right;" >[:$MODEL.language->getMessage('msg.item.price'):]</th>            		
            		<th style="text-align: center;width: 80px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
            		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.total'):]</th>
            		<th  style="text-align: center;">[:$MODEL.language->getMessage('msg.order.status.completed'):]</th>
            	</tr>
            </thead>
                </thead>
                <tbody>                	 
                    [:foreach $MODEL.orderDetail as $_orderItem:]         	
                        <tr class="[:if $_orderItem@index%2==0:]odd[:else:]even[:/if:] "
                        id="item_[:$_orderItem->getItemId():]"
                        	onmouseover="changeColorOver('item_[:$_orderItem->getItemId():]')" onmouseout="changeColorOut('item_[:$_orderItem->getItemId():]')">
                            <td class="table-conent">  [:$_orderItem@index+1:]</td>                            
                            <td>[:$_orderItem->getItemId():]-[:$_orderItem->getItem()->getTitle():] </td>
                            <td>
                                [:if $_orderItem->getItem()->getUrlThumbnail()=='':]
                                    [:assign var="_urlThumbnail" value="img/img_general.jpg":]
                                [:else:]
                                    [:assign var="_urlThumbnail" value=$_orderItem->getItem()->getUrlThumbnail():]
                                [:/if:]
                                <img src="[:$_urlThumbnail:]" alt="" width="40px" style="padding: 2px" height="40px"/>
                            </td>
                            <td align="right">[:$_orderItem->getPriceForDisplay():]</td>
                            <td align="center">[:$_orderItem->getQuantityForDisplay():]</td>
                            <td align="right">[:$_orderItem->getTotalForDisplay():]</td>
                           <td align="center" >
                           		<form id="form_item_[:$_orderItem->getItemId():]" action="[:$_orderItem->getUrlChangeStatus():]" method="post">
                           			<input type="hidden" name="orderId" value="[:$_orderItem->getOrderId():]">
                           			<input type="hidden" name="itemId" value="[:$_orderItem->getItemId():]">
                           			<input onchange="submitForm('form_item_[:$_orderItem->getItemId():]')" name="status" type="checkbox" value="1" [:if $_orderItem->getStatus():]checked [:/if:]/></td>
                           		</form>
                        </tr>
                    	[:foreachelse:]
                        <tr>
                            <td colspan="8">[:$MODEL.language->getMessage('msg.nodata'):]</td>
                        </tr>
                    	[:/foreach:]
                    	<tr class="table-header" >
                    		<th colspan="8" style="text-align: right;font-weight: bold;	">[:if isset($MODEL.priceTotal):][:$LANG->getMessage('msg.order.priceTotal'):]: [:$MODEL.priceTotal:][:/if:]</td>
                    	</tr>
                </tbody>
                </table>
                <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlOrderManagement:]')">[:$MODEL.language->getMessage('msg.orderList'):]</button>
   	</div>
</body>
[:include file="inc_inline_html_footer.tpl":]
