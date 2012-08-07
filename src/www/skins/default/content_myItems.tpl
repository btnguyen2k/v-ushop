<!-- MIDDLE COLUMN -->
<div id="main" [:if isset($DISABLE_COLUMN_RIGHT)&&isset($DISABLE_COLUMN_LEFT):]style="width: 870px"[:else:]style="width: 680px"[:/if:]>
	<h1>[:$LANG->getMessage('msg.profile'):]</h1>
	<br/>
    <div id="tabs">
        <ul>
        	<li><a onclick="window.location.href='[:$MODEL.urlProfile:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.shop.information'):]</a></li>
        	<li><a onclick="window.location.href='[:$MODEL.urlChangePassword:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.changePassword'):]</a></li>
            <li><a href="#tab-3">[:$LANG->getMessage('msg.myitems'):]</a></li>
            <li><a onclick="window.location.href='[:$MODEL.urlMyOrders:]';" href="javascript:void(0);">[:$LANG->getMessage('msg.myOrders'):]</a></li>
        </ul>
        <div id="tab-3">
        	<h2>[:$LANG->getMessage('msg.itemList'):]</h2>
        	<br/>
        	&nbsp;&nbsp;&nbsp;
        	[:$LANG->getMessage('msg.category'):]: <select onchange="loadItemForCategory(this,'[:$MODEL.urlMyItems:]');">
                [:if isset($MODEL.objCategory):]
                    <option value="0">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                     [:call name="printCategoryTreeSelectBox" catList=$MODEL.categoryTree index=0 selectedIndex=$MODEL.objCategory->getId():]
                [:else:]
                    <option value="0" style="font-weight: bold;">&gt;&gt;[:$MODEL.language->getMessage('msg.all'):]&lt;&lt;</option>
                    [:call name="printCategoryTreeSelectBox" catList=$MODEL.categoryTree index=0 selectedIndex=0:]
                [:/if:]
            </select>
        	<br/><br/>
        	 <button class="btn" onclick="redirect('[:$MODEL.urlCreateItem:]')" type="button">[:$MODEL.language->getMessage('msg.createItem'):]</button>
        	 <br/> <br/>
       		 <table class="table" cellpadding="0" cellspacing="0" border="0" align="center">
                <thead>
                    <tr class="table-header">
                        <th class="table-conent">[:$MODEL.language->getMessage('msg.item'):]</th>
                        <th width="150px" >[:$MODEL.language->getMessage('msg.category'):]</th>
                        <th width="90px" style="text-align: center;">[:$MODEL.language->getMessage('msg.actions'):]</th>
                    </tr>
                </thead>
                <tbody>
                    [:foreach $MODEL.myItems as $item:]
                        <tr class="[:if $item@index%2==0:]odd[:else:]even[:/if:] "
                        id="item_[:$item->getId():]"
                        	onmouseover="changeColorOver('item_[:$item->getId():]')" onmouseout="changeColorOut('item_[:$item->getId():]')">
                            <td class="table-conent">                                
                                <big><a href="javascript:void(0);" onclick="redirect('[:$item->getUrlEdit():]')">[:$item->getTitle()|escape:'html':]</a></big>
                                <br />
                                <small>
                                    [:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$item->getVendor()|escape:'html':]</strong>
                                    |
                                    [:$MODEL.language->getMessage('msg.item.price'):]: <strong>[:number_format($item->getPrice(), 2, ',', '.'):]</strong>
                                </small>
                            </td>
                            <td>
                                <small>
                                    [:if $item->getCategory()!==NULL:]
                                        [:$item->getCategory()->getTitle()|escape:'html':]
                                    [:else:]
                                        &nbsp;
                                    [:/if:]
                                </small>
                            </td>
                            <td style="text-align: center;" width="64px">
                                <a href="[:$item->getUrlEdit():]"><img border="0" alt="" src="images/icons/edit.png" /></a>
                                <a href="[:$item->getUrlDelete():]"><img border="0" alt="" src="images/icons/delete.png" /></a>
                            </td>
                        </tr>
                    [:foreachelse:]
                        <tr>
                            <td colspan="3">[:call name=noData:]</td>
                        </tr>
                    [:/foreach:]
                </tbody>
                	 <tr class="table-header">
                         <td colspan="3" style="text-align: right;">
                            <small>
                            	[:$MODEL.language->getMessage('msg.page'):]:
                                [:foreach $MODEL.paginator->getVisiblePages() as $_page:]
                                    [:if $_page==0:]
                                        &nbsp;<big>...</big>&nbsp;
                                    [:elseif $_page==$MODEL.paginator->getCurrentPage():]
                                        &nbsp;<big>[:$_page:]</big>&nbsp;
                                    [:else:]
                                    	&nbsp;<a style="color: white;text-decoration: underline;" href="[:$MODEL.paginator->getUrlForPage($_page):]">[:$_page:]</a>&nbsp;
                                    [:/if:]
                                [:/foreach:]
                                    
                            </small>
                        </td>
                    </tr>
                </table>
                <br/>
                <button class="btn" onclick="redirect('[:$MODEL.urlCreateItem:]')" type="button">[:$MODEL.language->getMessage('msg.createItem'):]</button>
            
        	<script type="text/javascript">           
                $('#tabs').tabs({ selected: 2 });
        	</script>
        	<br/>
        	<br/>
        	<br/>
        </div>             
    </div>
    <script>
	$(function() {
		$( "#tabs" ).tabs();
	});
    </script>
</div>