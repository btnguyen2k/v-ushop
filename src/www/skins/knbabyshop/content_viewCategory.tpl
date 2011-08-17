<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    [:if count($MODEL.categoryObj->getChildren()) gt 0:]
        [:displayCategoryList categoryList=$MODEL.categoryObj->getChildren():]
    [:else:]
        [:if count($MODEL.itemList) eq 0:]
            [:$MODEL.language->getMessage('msg.nodata'):]
        [:else:]
            <div class="middle-column-box-white">
                <form action="[:$smarty.server.REQUEST_URI:]" method="get" style="margin: 0px; padding: 0px">
                    <item type="hidden" name="p" value="[:if isset($smarty.get.p):][:$smarty.get.p+0:][:else:]1[:/if:]"/>
                    [:$MODEL.language->getMessage('msg.itemSorting'):]:
                    <select name="s" onchange="this.form.submit();">
                        <option value="timedesc"[:if isset($smarty.session.ITEM_SORTING) && $smarty.session.ITEM_SORTING=='timedesc':]
                            selected="selected"[:/if:]>[:$MODEL.language->getMessage('msg.itemSorting.timedesc'):]</option>
                        <option value="timeasc"[:if isset($smarty.session.ITEM_SORTING) && $smarty.session.ITEM_SORTING=='timeasc':]
                            selected="selected"[:/if:]>[:$MODEL.language->getMessage('msg.itemSorting.timeasc'):]</option>
                        <option value="pricedesc"[:if isset($smarty.session.ITEM_SORTING) && $smarty.session.ITEM_SORTING=='pricedesc':]
                            selected="selected"[:/if:]>[:$MODEL.language->getMessage('msg.itemSorting.pricedesc'):]</option>
                        <option value="priceasc"[:if isset($smarty.session.ITEM_SORTING) && $smarty.session.ITEM_SORTING=='priceasc':]
                            selected="selected"[:/if:]>[:$MODEL.language->getMessage('msg.itemSorting.priceasc'):]</option>
                        <option value="title"[:if isset($smarty.session.ITEM_SORTING) && $smarty.session.ITEM_SORTING=='title':]
                            selected="selected"[:/if:]>[:$MODEL.language->getMessage('msg.itemSorting.title'):]</option>
                    </select>
                </form>
            </div>
            [:assign var="_cart" value=$MODEL.cart:]
            <div class="middle-column-left">
                [:for $i = 0 to round(count($MODEL.itemList)/2)-1:]
                    [:assign var="_item" value=$MODEL.itemList[$i]:]
                    <!-- Middle column left box -->
                    <div class="middle-column-box-left-white">
                        <div class="middle-column-box-title-white blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                        [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                    </div>
                [:/for:]
            </div>

            <div class="middle-column-right">
                [:for $i = round(count($MODEL.itemList)/2) to count($MODEL.itemList)-1:]
                    [:assign var="_item" value=$MODEL.itemList[$i]:]
                    <!-- Middle column right box -->
                    <div class="middle-column-box-right-white">
                        <div class="middle-column-box-title-white blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                        [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                    </div>
                [:/for:]
            </div>
        [:/if:]
    [:/if:]
</div>
