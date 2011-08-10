<div class="content_section">
    [:if isset($TITLE):]<h2>[:$TITLE:]</h2>[:/if:]
    [:assign var="_index" value=0:]
    [:foreach $CAT_LIST as $cat:]
        [:if $cat->getUrlThumbnail()=='':]
            [:assign var="_urlThumbnail" value="images/noimage.jpg":]
        [:else:]
            [:assign var="_urlThumbnail" value=$cat->getUrlThumbnail():]
        [:/if:]
        <div class="product_box[:if $_index!=2:] margin_r35[:/if:]">
            <h3>[:$cat->getTitle()|escape:'html':]</h3>
            <div class="image_wrapper"> <a href="[:$cat->getUrlView():]" target="_parent"><img src="[:$_urlThumbnail:]" alt="" width="190"/></a> </div>
            <!--
            <p class="price">Price: $350</p>
            <a href="#">Detail</a> | <a href="#">Buy Now</a>
            -->
            [:if $_index==2:]
                <div class="cleaner"></div>
            [:/if:]
            [:assign var="_index" value=($_index+1)%3:]
         </div>
    [:/foreach:]
    <div class="cleaner"></div>
    <!-- <div class="button_01"><a href="#">View All</a></div> -->
</div>
