<!-- RIGHT COLUMN -->
<div id="right-column">
    <div class="right-column-box-white">
        <div class="right-column-box-title-purple" align="center" style="text-transform: uppercase;">[:$MODEL.language->getMessage('msg.cart'):]</div>
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
    <div class="right-column-box-white">
        <div class="right-column-box-title-purple" align="center" style="text-transform: uppercase;">[:$MODEL.language->getMessage('msg.support'):]</div>
        <p>
            [:assign var="_yahooid" value="kn_babyshop":]
            <a href="ymsgr:sendIM?[:$_yahooid:]"><img border="0" src="http://opi.yahoo.com/online?u=[:$_yahooid:]&m=g&t=14&l=us" /></a>
            <!-- <a href="http://edit.yahoo.com/config/send_webmesg?.target=[:$_yahooid:]&.src=pg" target="_blank"><img border="0" src="http://opi.yahoo.com/online?u=[:$_yahooid:]&m=g&t=14&l=us" /></a> -->
        </p>
    </div>
    [:if isset($MODEL.hotItems):]
        <div class="right-column-box-white" align="center">
            <div class="right-column-box-title-purple" style="text-transform: uppercase;">[:$MODEL.language->getMessage('msg.hotItems'):]</div>
            <marquee behavior="scroll" direction="up" loop="-1" style="text-align: center;" height="480"
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
