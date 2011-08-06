<!-- RIGHT COLUMN -->
<div id="right-column">
    <div class="right-column-box-green">
        <div class="right-column-box-title-green" align="center" style="text-transform: uppercase;">[:$MODEL.language->getMessage('msg.cart'):]</div>
        [:foreach $MODEL.cart->getItems() as $item:]
            &#187; [:$item->getTitle()|escape:'html':] ([:$item->getQuantity():])<br/>
        [:foreachelse:]
            [:$MODEL.language->getMessage('msg.nodata'):]
        [:/foreach:]
        [:if count($MODEL.cart->getItems()) gt 0:]
            <p align="center">
                <a href="[:$MODEL.cart->getUrlView():]">[:$MODEL.language->getMessage('msg.viewCart'):]</a>
            </p>
        [:/if:]
    </div>
    [:if isset($MODEL.hotItems):]
        <div class="right-column-box-blue" align="center">
            <div class="right-column-box-title-blue" style="text-transform: uppercase;">[:$MODEL.language->getMessage('msg.item.isHot'):]</div>
            <marquee behavior="scroll" direction="up" loop="-1" style="text-align: center;" height="400"
                    scrollamount="1" scrolldelay="20" truespeed="truespeed" onmouseover="this.stop()" onmouseout="this.start()">
                [:foreach $MODEL.hotItems as $item:]
                    [:if $item->getUrlThumbnail():]
                        [:assign var="urlThumbnail" value=$item->getUrlThumbnail():]
                    [:else:]
                        [:assign var="urlThumbnail" value="img/img_general.jpg":]
                    [:/if:]
                    <a href="[:$item->getUrlView():]" title="[:$item->getTitle()|escape:'html':]" style="text-decoration: none;">
                        <strong>[:$item->getTitle()|escape:'html':]</strong>
                        <br />
                        <img border="0" alt="" src="[:$urlThumbnail:]" width="115"/>
                    </a>
                    <br /><br />
                [:/foreach:]
            </marquee>
        </div>
    [:/if:]
</div>
