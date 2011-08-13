<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-white">
        <div class="middle-column-box-title-purple">[:$MODEL.language->getMessage('msg.search'):]</div>
        [:if isset($smarty.get.c):]
            [:assign var="_catId" value=$smarty.get.c:]
        [:else:]
            [:assign var="_catId" value=0:]
        [:/if:]
        <form name="frmSearch" method="get" action="[:$smarty.server.SCRIPT_NAME:]/search">
        <p align="center">
            <input type="text" name="q" value="[:$smarty.get.q|escape:'html':]" />
            <select name="c">
                <option value="0">&gt;&gt;[:$MODEL.language->getMessage('msg.search.allCategories'):]&lt;&lt;</option>
                [:foreach $MODEL.categoryTree as $cat:]
                    <option value="[:$cat->getId():]" [:if $cat->getId()==$_catId:]selected="selected"[:/if:]>[:$cat->getTitle()|escape:'html':]</option>
                    [:foreach $cat->getChildren() as $child:]
                        <option value="[:$child->getId():]" [:if $child->getId()==$_catId:]selected="selected"[:/if:]>&nbsp;&nbsp;&nbsp;&nbsp;[:$child->getTitle()|escape:'html':]</option>
                    [:/foreach:]
                [:/foreach:]
            </select>
            <a href="javascript:document.frmSearch.submit();" onclick=""><img border="0" src="img/find.png" /></a>
        </p>
        </form>
    </div>
        [:if count($MODEL.itemList) eq 0:]
            [:$MODEL.language->getMessage('msg.nodata'):]
        [:else:]
            [:assign var="_cart" value=$MODEL.cart:]
            <div class="middle-column-left">
                [:for $i = 0 to round(count($MODEL.itemList)/2)-1:]
                    [:assign var="_item" value=$MODEL.itemList[$i]:]
                    <!-- Middle column left box -->
                    <div class="middle-column-box-left-white" style="">
                        <div class="middle-column-box-title-white blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                        [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                    </div>
                [:/for:]
            </div>

            <div class="middle-column-right">
                [:for $i = round(count($MODEL.itemList)/2) to count($MODEL.itemList)-1:]
                    [:assign var="_item" value=$MODEL.itemList[$i]:]
                    <!-- Middle column right box -->
                    <div class="middle-column-box-right-white" style="">
                        <div class="middle-column-box-title-white blockTitle"><a href="[:$_item->getUrlView():]">[:$_item->getTitle()|escape:'html':]</a></div>
                        [:displayCategoryItem cart=$_cart item=$_item picAlign='left':]
                    </div>
                [:/for:]
            </div>
        [:/if:]
</div>
