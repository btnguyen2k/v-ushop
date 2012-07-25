<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    [:assign var="_cart" value=$MODEL.cart nocache:]
    [:assign var="_item" value=$MODEL.itemObj:]
    <script type="text/javascript">
    //<![CDATA[
    function openImage(url) {
        window.open(url, '_blank', 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,directories=no,location=no');
        return false;
    }
    //]]>
    </script>
    <div class="middle-column-box-white">
        <!--
        <div class="middle-column-box-title-white" style="color: purple;">[:$_item->getTitle()|escape:'html':]</div>
        -->
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
        <img border="0" width="150" height="150" alt="" style="float: left; margin: 0px 8px 4px 8px;" src="[:$_urlThumbnail:]"/>
        <p style="font-weight: bold; color: purple;">[:$_item->getTitle()|escape:'html':]</p>
        <p>[:$MODEL.language->getMessage('msg.item.price'):]: <strong>[:$_item->getPriceForDisplay():]</strong></p>
        <p>[:$MODEL.language->getMessage('msg.item.vendor'):]: <strong>[:$_item->getVendor()|escape:'html':]</strong></p>
        <hr style="margin-right: 4px"/>
        [:assign var="_cart" value=$MODEL.cart nocache:]
        <form method="post" action="[:$smarty.server.SCRIPT_NAME:]/addToCart">
            <small>
                <a href="[:$_cart->getUrlView():]">[:$MODEL.language->getMessage('msg.inCart'):]: <strong>
                    [:if $_cart->existInCart($_item):][:$_cart->getItem($_item)->getQuantity():][:else:]0[:/if:]</strong></a>
                |
                [:$MODEL.language->getMessage('msg.addToCart'):]:
                <input type="hidden" name="item" value="[:$_item->getId():]" />
                <input type="text" name="quantity" value="1" style="width: 20px"/>
                <input type="image" src="img/cart_put.png" align="top" title="[:$MODEL.language->getMessage('msg.add'):]"/>
                <!--
                <input type="submit" value="[:$MODEL.language->getMessage('msg.add'):]" style="font-size: xx-small;"/>
                -->
            </small>
        </form>
        <hr style="margin-right: 4px"/>
        <span>[:$_item->getDescription():]</span>
    </div>
    <div class="middle-column-box-white">
        <!--
        <div class="middle-column-box-title-grey">[:$MODEL.language->getMessage('msg.item.image'):]</div>
        -->
        <p align="center"><img border="0" alt="" src="[:$_urlImage:]" /></p>
    </div>
</div>
