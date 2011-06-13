<!-- LEFT COLUMN --> <!-- Navigation -->
<div id="left-column">
    [:if isset($MODEL.categoryTree):]
        <ul>
            <li class="left-navheader-first">[:$MODEL.language->getMessage('msg.categories'):]</li>
            [:foreach $MODEL.categoryTree as $cat:]
                <li><a class="left-navheader" href="[:$cat->getUrlView():]">[:$cat->getTitle()|escape:'html':]</a></li>
                [:foreach $cat->getChildren() as $child:]
                    <li><a href="[:$child->getUrlView():]">[:$child->getTitle()|escape:'html':]</a></li>
                [:foreachelse:]
                    [:$MODEL.language->getMessage('msg.nodata'):]
                [:/foreach:]
            [:/foreach:]
        </ul>
    [:/if:]
</div>
