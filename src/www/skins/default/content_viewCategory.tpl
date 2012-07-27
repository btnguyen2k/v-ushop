<!--- main column starts-->
    <div id="main">    	
    	<h1>[:$MODEL.categoryName:]</h1>
    	<br style="clear: both;"/>
    	[:call name="displayCategoryItemList" itemList=$MODEL.itemList cart=$MODEL.cart:]
    </div>
<!--- main column ends -->