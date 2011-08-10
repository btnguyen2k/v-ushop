<div class="content_section">
    [:if isset($TITLE):]<h2>[:$TITLE:]</h2>[:/if:]
    [:assign var="CART" value=$MODEL.cart:]
    [:assign var="LANGUAGE" value=$MODEL.language:]
    [:assign var="_index" value=0:]
    [:foreach $ITEM_LIST as $item:]
        [:if $cat->getUrlThumbnail()=='':]
            [:assign var="_urlThumbnail" value="images/noimage.jpg":]
        [:else:]
            [:assign var="_urlThumbnail" value=$cat->getUrlThumbnail():]
        [:/if:]
        <div class="product_box[:if ($_index%3)!=2:] margin_r35[:/if:]">
            <h3>[:$item->getTitle()|escape:'html':]</h3>
            <div class="image_wrapper"> <a href="[:$item->getUrlView():]" target="_parent"><img src="[:$_urlThumbnail:]" alt="" width="190"/></a> </div>
            <p class="price"><!--  [:$LANGUAGE->getMessage('msg.item.price'):]: -->[:$item->getPriceForDisplay():]</p>
            <a href="[:$item->getUrlView():]">[:$LANGUAGE->getMessage('msg.item.detail'):]</a>
            |
            [:assign var="_formName" value="frmItem$_index":]
            <form name="[:$_formName:]" method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart" style="margin: 0; display: inline;">
                <input type="hidden" name="item" value="[:$item->getId():]" />
                <input type="text" name="quantity" value="1" size="2" style="font-size: x-small;"/>
                <a onclick="document.[:$_formName:].submit();" href="javascript:;">[:$LANGUAGE->getMessage('msg.buy'):]</a>
            </form>
            [:if ($_index%3)==2:]
                <div class="cleaner"></div>
            [:/if:]
            [:assign var="_index" value=$_index+1:]
         </div>
    [:/foreach:]
    <div class="cleaner"></div>
    <!-- <div class="button_01"><a href="#">View All</a></div> -->
</div>
