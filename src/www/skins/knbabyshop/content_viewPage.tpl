<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-whilte">
        <!-- <div class="middle-column-box-title-blue">[:$MODEL.pageObj->getTitle()|escape:'html':]</div>  -->
        [:$MODEL.pageObj->getContent():]
    </div>
</div>