<!--- main column starts-->
<div id="main">
	<h1>[:$LANG->getMessage('msg.categories'):]-Shop [:$MODEL.shopObject->getTitle():] </h1>
	<br/>			
	[:if isset($MODEL.categoryList) && count($MODEL.categoryList) gt 0:]
		[:foreach $MODEL.categoryList as $_category:]
			[:if count($_category->getItemsForCategoryShop()) gt 0:]
    			<div class="category-title">[:$_category->getTitle():]</div>
    			<br style="clear: both;"/>
    			<br/>
    			[:assign var="scrollerId" value=$_category@index-scroller-item scope=root:]
    			<ul id="[:$scrollerId:]">
        			[:foreach $_category->getItemsForCategoryShop() as $_item:]
        				[:if $_item->getUrlThumbnail()=='':]
                            [:assign var="_urlThumbnail" value="img/img_general.jpg":]
                        [:else:]
                            [:assign var="_urlThumbnail" value=$_item->getUrlThumbnail():]
                        [:/if:]	        			
            				<li onclick="redirect('[:$_item->getUrlView():]')"><img src="[:$_urlThumbnail:]" class="sanpham" alt=""><div style="width: 120px;height:40px;white-space: normal;">[:$_item->getTitle():]</div></li>  
            				
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