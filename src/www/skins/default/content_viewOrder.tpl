<!-- MIDDLE COLUMN -->
<div id="main" [:if isset($DISABLE_COLUMN_RIGHT)&&isset($DISABLE_COLUMN_LEFT):]style="width: 870px" [:else:]style="width: 680px"[:/if:]>
    <h1>[:$LANG->getMessage('msg.profile'):]</h1>
    <br />
    <div id="tabs">
        <ul>
        	<li><a onclick="window.location.href='[:$MODEL.urlProfile:]';"
        		href="javascript:void(0);">[:$LANG->getMessage('msg.shop.information'):]</a></li>
        	<li><a onclick="window.location.href='[:$MODEL.urlChangePassword:]';"
        		href="javascript:void(0);">[:$LANG->getMessage('msg.changePassword'):]</a></li>
        	<li><a onclick="window.location.href='[:$MODEL.urlMyItems:]';"
        		href="javascript:void(0);">[:$LANG->getMessage('msg.myitems'):]</a></li>
        	<li><a onclick="window.location.href='[:$MODEL.urlMyOrders:]';"
        		href="javascript:void(0);">[:$LANG->getMessage('msg.myOrders'):]</a></li>
        	<li><a href="#tab-4">[:$LANG->getMessage('msg.orderDetail'):]</a></li>
        </ul>
    <div id="tab-4">
        	 [:if isset($MODEL.orderObj):]
        		[:assign var="_order" value=$MODEL.orderObj:]
           		<table width="100%">
        			<tr>
        				<td colspan="4"><h2>[:$LANG->getMessage('msg.orderInformation'):] - [:$_order->getId()|escape:'html':]</h2><br/></td>
        			</tr>
        			<tr>
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.order.paymentMethod'):] :</td>
        				<td width="35%">
        					[:if $_order->getPaymentMethod():]
        						[:$LANG->getMessage('msg.order.paymentMethod.cash'):]
        					[:else:]
        						[:$LANG->getMessage('msg.order.paymentMethod.transfer'):]
        					[:/if:]
        				</td>         				
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.order.name'):] :</td>
        				<td width="35%">[:$_order->getFullName()|escape:'html':]</td>
        			</tr>
        			<tr>
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.order.email'):] :</td>
        				<td width="35%">[:$_order->getEmail()|escape:'html':]</td>
        				<td class="lable" width="15%">[:$LANG->getMessage('msg.order.phone'):] :</td>
        				<td width="35%">[:$_order->getPhone()|escape:'html':]</td>
        			</tr>
        			
        			<tr>
        				<td class="lable" colspan="4">[:$LANG->getMessage('msg.order.otherInfo'):] :
        				[:$_order->getAddress()|escape:'html':]</td>        				
        			</tr>
                </table> 
             [:/if:]
        <br />
        <h2>[:$LANG->getMessage('msg.orderDetail'):]</h2>
        <br/>
         <table class="table" cellpadding="0" cellspacing="0" border="0" align="center">
                <thead>
                   <thead class="table-header">  
            	<tr>        		
            		
            		<th width="30px">[:$MODEL.language->getMessage('msg.stt'):]</th>
            		<th >[:$MODEL.language->getMessage('msg.item'):]</th>
            		<th width="60px">[:$MODEL.language->getMessage('msg.image'):]</th>
            		<th style="text-align: right;" >[:$MODEL.language->getMessage('msg.price'):]</th>            		
            		<th style="text-align: center;width: 80px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
            		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.total'):]</th>
            		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.order.status.completed'):]</th>
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
                                    [:assign var="_urlThumbnail" value="images/img_general.jpg":]
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
                           			<input onchange="submitForm('form_item_[:$_orderItem->getItemId():]')" name="status" type="checkbox" value="true" [:if $_orderItem->getStatus():]checked [:/if:]/></td>
                           		</form>
                        </tr>
                    	[:foreachelse:]
                        <tr>
                            <td colspan="8">[:call name=noData:]</td>
                        </tr>
                    	[:/foreach:]
                    	<tr class="table-header" >
                    		<td colspan="8" style="text-align: right;font-weight: bold;	">[:if isset($MODEL.priceTotal):][:$LANG->getMessage('msg.order.priceTotal'):]: [:$MODEL.priceTotal:][:/if:]</td>
                    	</tr>
                </tbody>
                </table>
        
        <script type="text/javascript">           
            $('#tabs').tabs({ selected: 4 });
    	</script> <br />
        <br />
        <br />
    </div>
</div>
<script>
	$(function() {
		$( "#tabs" ).tabs();
		jumpTo('tabs');
	});
    </script></div>