<!-- MIDDLE COLUMN -->

<div id="main">
	<h1>[:$LANG->getMessage('msg.cart'):]</h1>
	<br></br>
    <table class="table" cellpadding="0" cellspacing="0" border="0" align="center">
    	<thead class="table-header">  
        	<tr>        		
        		<th width="20px"><input type="checkbox" class="checkbox"> </th>
        		<th width="30px">[:$MODEL.language->getMessage('msg.stt'):]</th>
        		<th >[:$MODEL.language->getMessage('msg.item'):]</th>
        		<th width="60px">[:$MODEL.language->getMessage('msg.image'):]</th>
        		<th style="text-align: right;" >[:$MODEL.language->getMessage('msg.price'):]</th>            		
        		<th style="text-align: center;width: 80px">[:$MODEL.language->getMessage('msg.quantity'):]</th>
        		<th  style="text-align: right;">[:$MODEL.language->getMessage('msg.total'):]</th>
        	</tr>
        </thead>
        <tbody>
        [:foreach $MODEL.cart->getItems() as $item:]            	
        	[:if $item->getUrlThumbnail()=='':]
                [:assign var="_urlThumbnail" value="images/img_general.jpg":]
            [:else:]
                [:assign var="_urlThumbnail" value=$item->getUrlThumbnail():]
            [:/if:]
        	<tr>        		
        		<td><input type="checkbox" class="checkbox"> </td>
        		<td>[:$item@index+1:]</td>
        		<td style="white-space: normal;">[:$item->getTitle()|escape:'html':]</td>
        		<td>
        			<div >  
                		<img src="[:$_urlThumbnail:]" width="40px" style="padding: 2px" height="40px" alt="">
                	</div>
				</td>
				<td style="text-align: right;">[:$item->getPriceForDisplay():]</td>
        		<td style="text-align: center;"><input type="text" style="width: 30px" value="[:$item->getQuantity():]"> </td>
        		<td style="text-align: right;font-size: 16px">[:$item->getTotalForDisplay():]</td>
        	</tr>
        [:foreachelse:]
            <tr>
                <td colspan="7">[:call name=noData:]</td>
            </tr>
        [:/foreach:]
        </tbody>
        <tfoot>  
        	<tr>
        		<th colspan="5">
        			<div class="btn-group ">
                      	<button class="btn btn-warning" >[:$MODEL.language->getMessage('msg.delete'):]</button>
                      	<button class="btn btn-warning" onclick="redirect('[:$MODEL.cart->getUrlCheckout():]')">[:$MODEL.language->getMessage('msg.checkout'):]</button>
                      	<button class="btn btn-warning" onclick="redirect('[:$smarty.server.SCRIPT_NAME:]')">[:$MODEL.language->getMessage('msg.continueShopping'):]</button>
                    </div>
                </th>
        		<th style="text-align: right;font-size: 16px">[:$MODEL.language->getMessage('msg.grandTotal'):] : </th>
        		<th style="text-align: right;font-size: 16px" >[:$MODEL.cart->getGrandTotalForDisplay():]</th>
        		
        	</tr>
        </tfoot>
    </table>
</div>
   
