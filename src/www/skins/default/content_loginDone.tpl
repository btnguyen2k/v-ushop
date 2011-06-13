<!-- MIDDLE COLUMN -->
<div id="middle-column" style="width: 97.5%">
    <!-- Middle column full box -->
    <div class="middle-column-box-green">
        <div class="middle-column-box-title-green">[:$MODEL.language->getMessage('msg.login'):]</div>
        <p>[:$MODEL.infoMessage:]</p>
        [:if isset($MODEL.transitMessage):]
            <p>[:$MODEL.transitMessage:]</p>
        [:/if:]
    </div>
</div>