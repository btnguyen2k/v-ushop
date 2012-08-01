<!--- main column starts-->
    <div id="main">    	
    	<h1>[:$MODEL.categoryName:]</h1>
    	<br style="clear: both;"/>
    	[:call name="paginator" paginator=$MODEL.paginator:]
    	[:call name="displayCategoryItemList" itemList=$MODEL.itemList cart=$MODEL.cart:]
    	<br style="clear: both;"/>
    	[:call name="paginator" paginator=$MODEL.paginator:]
    </div>
<!--- main column ends -->