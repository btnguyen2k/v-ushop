<!-- MIDDLE COLUMN -->

<div id="main">
	<h1>[:$LANG->getMessage('msg.cart'):]</h1>
	<br></br>
	<form action="[:$MODEL.urlDeleteItemInCart:]" id="form_cart" method="post" >
		
          	<button type="submit" class="btn btn-warning" onclick="return confirmDelete('[:$MODEL.msgDelete:]')" >[:$MODEL.language->getMessage('msg.delete'):]</button>
          	<button type="submit" class="btn btn-warning" onclick="return changeActionForm('[:$MODEL.urlUpdateCart:]','form_cart')" >[:$MODEL.language->getMessage('msg.update'):]</button>                          	
        
        	<button type="button" class="btn btn-warning" onclick="redirect('[:$MODEL.cart->getUrlCheckout():]')">[:$MODEL.language->getMessage('msg.checkout'):]</button>
          	<button type="button" class="btn btn-warning" onclick="redirect('[:$smarty.server.SCRIPT_NAME:]')">[:$MODEL.language->getMessage('msg.continueShopping'):]</button>
  		<br/>  <br/>  
        <table class="table" cellpadding="0" cellspacing="0" border="0" align="center">
        	<thead class="table-header">  
            	<tr>        		
            		<th width="20px" class="table-conent"><input type="checkbox" class="checkbox" id="check-all" onchange="toggleChecked(this.checked)"> </th>
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
            	<tr class="[:if $item@index%2==0:]odd[:else:]even[:/if:] "
                        id="item_[:$item->getItemId():]"
                        	onmouseover="changeColorOver('item_[:$item->getItemId():]')" onmouseout="changeColorOut('item_[:$item->getItemId():]')">        		
            		<td class="table-conent"><input type="checkbox" class="checkbox" value="[:$item->getItemId():]" name="itemIds[]"></td>
            		<td>[:$item@index+1:]</td>
            		<td style="white-space: normal;">[:$item->getCode()|escape:'html':]-[:$item->getTitle()|escape:'html':]</td>
            		<td>
            			<div >  
                    		<img src="[:$_urlThumbnail:]" width="40px" style="padding: 2px" height="40px" alt="">
                    	</div>
    				</td>
    				<td style="text-align: right;">[:$item->getPriceForDisplay():]</td>
            		<td style="text-align: center;">
            			<input name="updateItemIds[]" value="[:$item->getItemId():]" type="hidden"/>
            			<input type="text" style="width: 30px" name="quantitys[]" value="[:$item->getQuantity():]"> 
            		</td>
            		<td style="text-align: right;font-size: 14px">[:$item->getTotalForDisplay():]</td>
            	</tr>
            [:foreachelse:]
                <tr>
                    <td colspan="7">[:call name=noData:]</td>
                </tr>
            [:/foreach:]
            </tbody>
        	<tr class="table-header">
        		<th colspan="5">
        			
                </th>
        		<th style="text-align: right;font-size: 14px;font-weight: normal;">[:$MODEL.language->getMessage('msg.grandTotal'):] : </th>
        		<th style="text-align: right;font-size: 14px;font-weight: normal;" >[:$MODEL.cart->getGrandTotalForDisplay():]</th>
        		
        	</tr>
            <tr>
            	<td colspan="6">
                   	<br/>
                      	<button type="submit" class="btn btn-warning" onclick="return confirmDelete('[:$MODEL.msgDelete:]')" >[:$MODEL.language->getMessage('msg.delete'):]</button>
                      	<button type="submit" class="btn btn-warning" onclick="return changeActionForm('[:$MODEL.urlUpdateCart:]','form_cart')" >[:$MODEL.language->getMessage('msg.update'):]</button>                          	
                    
                    	<button type="button" class="btn btn-warning" onclick="redirect('[:$MODEL.cart->getUrlCheckout():]')">[:$MODEL.language->getMessage('msg.checkout'):]</button>
                      	<button type="button" class="btn btn-warning" onclick="redirect('[:$smarty.server.SCRIPT_NAME:]')">[:$MODEL.language->getMessage('msg.continueShopping'):]</button>
                 
               	</td>
               	<td align="right" >
               		<br/>
               		<a href="javascript:void(0)" onclick="window.open('[:$MODEL.urlPrintCart:]','mywindow','width=1000,height=600'); return false;" target="_blank"><img alt="" src="images/icons/print_review.png" width="25" title="[:$MODEL.language->getMessage('msg.printReview'):]"> </a>
               	</td>
             </tr>
       	 </table>
    </form>
</div>
   
