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
        	<li><a href="#tab-3">[:$LANG->getMessage('msg.myOrders'):]</a></li>
        </ul>
    <div id="tab-3">
        <h2>[:$LANG->getMessage('msg.orderList'):]</h2>
        <br />&nbsp;&nbsp;&nbsp;
        <span style="font-weight: bold;">[:$LANG->getMessage('msg.order.status'):]:</span>  
        	<select onchange="loadOrderForShop(this,'[:$MODEL.urlMyOrders:]');">
        		<option value="0">[:$MODEL.language->getMessage('msg.order.status.notComplete'):]</option>
            	[:if isset($MODEL.status) && $MODEL.status==1:]
                	<option value="1" selected="selected">[:$MODEL.language->getMessage('msg.order.status.completed'):]</option>
                [:else:]
                	<option value="1" >[:$MODEL.language->getMessage('msg.order.status.completed'):]</option>
                [:/if:]
        	</select> 
        <br />
        <br />
        <table class="table" cellpadding="0" cellspacing="0" border="0"
        	align="center">
        	<thead>
        		<tr class="table-header">
        			<th>[:$MODEL.language->getMessage('msg.order.id'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.status'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.name'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.phone'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.email'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.time'):]</th>
        			<th>[:$MODEL.language->getMessage('msg.order.priceTotal'):]</th>
        			<th width="40px" style="text-align: center;">[:$LANG->getMessage('msg.actions'):]</th>
        		</tr>
        	</thead>
        	<tbody>
        		[:foreach $MODEL.myOrders as $_order:]
        		<tr class="[:if $_order@index%2==0:]odd[:else:]even[:/if:] "
        			id="order_[:$_order->getId():]"
        			style="cursor: pointer;"
        			onclick="redirect('[:$_order->getUrlView():]')"
        			onmouseover="changeColorOver('order_[:$_order->getId():]')"
        			onmouseout="changeColorOut('order_[:$_order->getId():]')">
        			<td class="table-conent"><span style="text-transform: uppercase;">[:$_order->getId()|escape:'html':]</span></td>
        			<td>
        				[:if isset($MODEL.status) && $MODEL.status==1:]
        					[:$LANG->getMessage('msg.order.status.completed'):]
        				[:else:]
        					[:$LANG->getMessage('msg.order.status.notComplete'):]
        				[:/if:]
        			</td>
        			<td>[:$_order->getFullName()|escape:'html':]</td>
        			<td>[:$_order->getPhone()|escape:'html':]</td>        			
        			<td>[:$_order->getEmail()|escape:'html':]</td>
        			<td>[:$_order->getDisplayForTimeStamp():]</td>   
        			<td>[:$_order->getTotalPriceForDisplay():]</td>   
        			<td align="center"><img alt="" title="[:$LANG->getMessage('msg.view'):]" src="images/icons/detail.png"> </td>        			
        		</tr>
        		[:foreachelse:]
        		<tr>
        			<td colspan="8">[:call name=noData:]</td>
        		</tr>
        		[:/foreach:]
        	</tbody>
        	<tr class="table-header">
        		<td colspan="8" style="text-align: right;"><small>
        		[:$MODEL.language->getMessage('msg.page'):]: [:foreach
        		$MODEL.paginator->getVisiblePages() as $_page:] [:if $_page==0:]
        		&nbsp;<big>...</big>&nbsp; [:elseif
        		$_page==$MODEL.paginator->getCurrentPage():] &nbsp;<big>[:$_page:]</big>&nbsp;
        		[:else:] &nbsp;<a style="color: #DCDCDC; text-decoration: underline;"
        			href="[:$MODEL.paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp;
        		[:/if:] [:/foreach:] </small></td>
        	</tr>
        </table>
        
        
        <script type="text/javascript">           
                        $('#tabs').tabs({ selected: 3 });
                	</script> <br />
        <br />
        <br />
    </div>
</div>
<script>
	$(function() {
		$( "#tabs" ).tabs();
	});
    </script></div>