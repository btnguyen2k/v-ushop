<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.info'):]</div>
        [:foreach $MODEL.infoMessages as $msg:]
            <p>[:$msg:]</p>
        [:/foreach:]
        [:if isset($MODEL.transitMessage):]
            <p>[:$MODEL.transitMessage:]</p>
        [:/if:]
    </div>
</div>
