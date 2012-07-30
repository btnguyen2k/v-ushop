<!-- MIDDLE COLUMN -->
<div id="middle-column"
    [:if isset($DISABLE_COLUMN_LEFT) && isset($DISABLE_COLUMN_RIGHT):]
        style="width: 98%"
    [:elseif isset($DISABLE_COLUMN_RIGHT)||isset($DISABLE_COLUMN_LEFT):]
        style="width: 77.9%"
    [:/if:]
><!-- Middle column full box -->
    <div class="middle-column-box-red">
        <div class="middle-column-box-title-red">[:$MODEL.language->getMessage('msg.error'):]</div>
        [:foreach $MODEL.errorMessages as $msg:]
            <p>[:$msg:]</p>
        [:/foreach:]
    </div>
</div>
