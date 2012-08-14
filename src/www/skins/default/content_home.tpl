<!--- main column starts-->
<div id="main">
	<h1>[:$LANG->getMessage('msg.categories'):]</h1>
	<br/>			
	[:if isset($MODEL.categoryList) && count($MODEL.categoryList) gt 0:]
		[:foreach $MODEL.categoryList as $_category:]
			[:if count($_category->getItemsForCategoryShop()) gt 0:]
    			<div class="category-title" onclick="redirect('[:$_category->getUrlView():]')">[:$_category->getTitle():]</div>
    			<br style="clear: both;"/>
    			<br/>
    			[:assign var="scrollerId" value=$_category@index-scroller-item scope=root:]
    			<ul id="[:$scrollerId:]">
        			[:foreach $_category->getItemsForCategoryShop() as $_item:]
        				[:if $_item->getUrlThumbnail()=='':]
                            [:assign var="_urlThumbnail" value="images/img_general.jpg":]
                        [:else:]
                            [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                        [:/if:]	        			
            				<li onclick="redirect('[:$_item->getUrlView():]')" style="text-align: left;position: relative;"><img src="[:$_urlThumbnail:]" class="sanpham" alt="">
                				<div style="padding-left: 5px;font-size: 14px">
        							<strong>[:$_item->getTitle():]</strong><br/>
                            		[:$LANG->getMessage('msg.price'):]: [:$_item->getPriceForDisplay():]<br/>
                            		[:$LANG->getMessage('msg.shopPrice'):]: [:$_item->getOldPriceForDisplay():]<br/>
                            		[:$LANG->getMessage('msg.savingPrice'):]: [:$_item->getSavingForDisplay():]
                            	</div>
                    		</li>  
            				
            		[:/foreach:] 
            		[:call name=autoScroller elName=$scrollerId auto='no':]
    			</ul>
			[:/if:]
		[:/foreach:] 
	[:else:]
		[:call name=noData:]
	[:/if:]	
		</div>
<!--- main column ends -->