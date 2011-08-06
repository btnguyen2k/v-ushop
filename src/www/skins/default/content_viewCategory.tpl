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
        [:assign var="_cart" value=$MODEL.cart:]
        <div class="middle-column-left">
            [:for $i = 0 to round(count($MODEL.itemList)/2)-1:]
                [:assign var="_item" value=$MODEL.itemList[$i]:]
                <!-- Middle column left box -->
                <div class="middle-column-box-left-white">
                    <div class="middle-column-box-title-grey blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                    [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                </div>
            [:/for:]
        </div>

        <div class="middle-column-right">
            [:for $i = round(count($MODEL.itemList)/2) to count($MODEL.itemList)-1:]
                [:assign var="_item" value=$MODEL.itemList[$i]:]
                <!-- Middle column right box -->
                <div class="middle-column-box-right-white">
                    <div class="middle-column-box-title-grey blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                    [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                </div>
            [:/for:]
        </div>
    [:/if:]
</div>
