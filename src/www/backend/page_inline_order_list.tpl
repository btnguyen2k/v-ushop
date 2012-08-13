[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-1000">[:$MODEL.language->getMessage('msg.orderList'):]</h1>

    <script type="text/javascript">
        function refreshView(form) {
            form.submit();
        }
    </script>
    <div class="align-center viewport-1000">
     <span style="font-weight: bold;">[:$LANG->getMessage('msg.order.status'):]:</span>  
        	<select onchange="loadOrderForShop(this,'[:$MODEL.urlOrderManagement:]');">
        		<option value="0">[:$MODEL.language->getMessage('msg.order.status.notComplete'):]</option>
            	[:if isset($MODEL.status) && $MODEL.status==1:]
                	<option value="1" selected="selected">[:$MODEL.language->getMessage('msg.order.status.completed'):]</option>
                [:else:]
                	<option value="1" >[:$MODEL.language->getMessage('msg.order.status.completed'):]</option>
                [:/if:]
        	</select> 
        <br />
      </div>
    <table cellpadding="2" class="align-center viewport-1000">
    <thead>
        <tr>
           	<th>[:$MODEL.language->getMessage('msg.order.id'):]</th>
    		<th style="white-space: nowrap;">[:$MODEL.language->getMessage('msg.order.status'):]</th>
    		<th>[:$MODEL.language->getMessage('msg.order.name'):]</th>
    		<th>[:$MODEL.language->getMessage('msg.order.phone'):]</th>
    		<th>[:$MODEL.language->getMessage('msg.order.email'):]</th>
    		<th >[:$MODEL.language->getMessage('msg.order.time'):]</th>
    		<th>[:$MODEL.language->getMessage('msg.order.priceTotal'):]</th>
    		<th style="text-align: center;width: 40px">[:$LANG->getMessage('msg.actions'):]</th>
         </tr>
    </thead>
   <tbody>
		[:foreach $MODEL.myOrders as $_order:]
		<tr class="[:if $_order@index%2==0:]odd[:else:]even[:/if:] "
			id="order_[:$_order->getId():]"
			style="cursor: pointer;"
			onclick="openUrl('[:$_order->getUrlView():]')"
			onmouseover="changeColorOver('order_[:$_order->getId():]')"
			onmouseout="changeColorOut('order_[:$_order->getId():]')">
			<td class="table-conent"><span style="text-transform: uppercase;">[:$_order->getId()|escape:'html':]</span></td>
			<td >
				[:if isset($MODEL.status) && $MODEL.status==1:]
					[:$LANG->getMessage('msg.order.status.completed'):]
				[:else:]
					[:$LANG->getMessage('msg.order.status.notComplete'):]
				[:/if:]
			</td>
			<td>[:$_order->getFullName()|escape:'html':]</td>
			<td>[:$_order->getEmail()|escape:'html':]</td>
			<td>[:$_order->getPhone()|escape:'html':]</td>
			<td style="white-space: nowrap;">[:$_order->getDisplayForTimeStamp():]</td>   
			<td>[:$_order->getTotalPriceForDisplay():]</td>   
			<td align="center"><img alt="" title="[:$LANG->getMessage('msg.view'):]" src="img/detail.png"> </td>        			
		</tr>
		[:foreachelse:]
		<tr>
			<td colspan="8">[:$MODEL.language->getMessage('msg.nodata'):]</td>
		</tr>
		[:/foreach:]
	</tbody>
    	<tr class="table-header">
    		<th colspan="8" style="text-align: right;"><small>
    		[:$MODEL.language->getMessage('msg.page'):]: [:foreach
    		$MODEL.paginator->getVisiblePages() as $_page:] [:if $_page==0:]
    		&nbsp;<big>...</big>&nbsp; [:elseif
    		$_page==$MODEL.paginator->getCurrentPage():] &nbsp;<big>[:$_page:]</big>&nbsp;
    		[:else:] &nbsp;<a style=" text-decoration: underline;"
    			href="[:$MODEL.paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp;
    		[:/if:] [:/foreach:] </small></td>
    	</tr>
</table>
</body>
[:include file="inc_inline_html_footer.tpl":]
