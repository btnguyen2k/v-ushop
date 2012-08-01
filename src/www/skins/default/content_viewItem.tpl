<div id="main">
	
<!-- Middle column full box -->
    [:assign var="_cart" value=$MODEL.cart nocache:]
    [:assign var="_item" value=$MODEL.itemObj:]    
    
    <h1 class="main-header">[:$LANG->getMessage('msg.detailsInformation'):]</h1>
    <br/>
    <div>
    	<table>
    		<tr>
    			<td width="200">
    				[:if $_item->getUrlThumbnail()=='':]
                        [:assign var="_urlThumbnail" value="img/img_general.jpg":]
                    [:else:]
                        [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                    [:/if:]
                    [:if $_item->getUrlImage()=='':]
                        [:assign var="_urlImage" value="img/img_general.jpg":]
                    [:else:]
                        [:assign var="_urlImage" value=$_item->getUrlImage():]
                    [:/if:]
                    <img width="200" height="200" alt="" style="padding: 5px; border: 1px solid #DCDCDC;" src="[:$_urlThumbnail:]"/>
    			</td>
    			<td valign="top" style="padding-left: 20px">
    				<span class="item-header-name">[:$_item->getTitle()|escape:'html':]</span>
    				<br/>
    				<br/>
       				<form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">
            			<small> 
            	 			<button class="btn btn-warning" type="button" onclick="this.form.submit(); return 0;"><img alt="" src="images/cart_add.png"> Add to cart</button>                	 		                              
                            <input type="hidden" name="item" value="[:$_item->getId():]" />
                            <br/>
                      		<a href="[:$_cart->getUrlView():]">[:$LANG->getMessage('msg.inCart'):]: <strong>
                    			[:if $_cart->existInCart($_item):][:$_cart->getItem($_item)->getQuantity():][:else:]0[:/if:]</strong></a>
                				|[:$LANG->getMessage('msg.addToCart'):]:  
                            <input type="text" name="quantity" value="1" style="width: 20px"/>                                
                        </small>
            	 	</form>   
            	 	<br/>          		
            		<span class="item-header-price" style="color:#08C;">[:$LANG->getMessage('msg.item.price'):]:</span> <span style="font-size: 16px;font-weight: bold;">[:$_item->getPriceForDisplay():]</span>
            		<br/><br/>
            		<span class="item-header-price" style="color:#08C;font-size: 14px">[:$LANG->getMessage('msg.item.vendor'):]:</span> [:$_item->getVendor()|escape:'html':]
                	
    			</td>
    		</tr>
    	</table>
    </div>
    <hr/>
    <br/>
    
     <div id="tabs">
        <ul>
        	<li><a href="#tabs-1">[:$LANG->getMessage('msg.itemInformation'):]</a></li>
        	<li><a href="#tabs-2">[:$LANG->getMessage('msg.image'):]</a></li>           
        </ul>
        <div id="tabs-1">
        	[:$_item->getDescription():]
        
        </div>
        <div id="tabs-2">        
        	 <img alt="" src="[:$_urlImage:]">        
        </div>
        <br/><br/><br/>
   </div>
    <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
    </script>
</div>
