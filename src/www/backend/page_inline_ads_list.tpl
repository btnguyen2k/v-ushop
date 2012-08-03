[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.adsList'):]</h1>

    <script type="text/javascript">
        function refreshView(form) {
            form.submit();
        }
    </script>
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateAds:]');">[:$MODEL.language->getMessage('msg.createAds'):]</button>
    </div>   
    <table cellpadding="2" class="align-center viewport-800">
    <thead>
        <tr>
            <th colspan="2" style="text-align: left;">[:$MODEL.language->getMessage('msg.ads'):]</th>
            <th style="text-align: center;">[:$MODEL.language->getMessage('msg.ads.clicks'):]</th>
            <th width="80px" style="text-align: center;">[:$MODEL.language->getMessage('msg.actions'):]</th>
         </tr>
    </thead>
    <tbody>
        [:foreach $MODEL.adsList as $ads:]
            <tr class="[:if $ads@index%2==0:]row-a[:else:]row-a[:/if:]">
                <td>
                    <a href="[:$ads->url:]" target="_blank">[:$ads->title|escape:'html':]</a>
                </td>
                <td>
                    [:$ads->url|escape:'html':]
                </td>
                <td style="text-align: center;">
                    [:$ads->clicks:]
                </td>
                <td style="text-align: center;" width="64px">
                    <a href="[:$ads->urlEdit:]"><img border="0" alt="" src="img/edit.png" /></a>
                    <a href="[:$ads->urlDelete:]"><img border="0" alt="" src="img/delete.png" /></a>
                </td>
            </tr>
        [:foreachelse:]
            <tr>
                <td colspan="4">[:$MODEL.language->getMessage('msg.nodata'):]</td>
            </tr>
        [:/foreach:]
    </tbody>
    </table>
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateAds:]');">[:$MODEL.language->getMessage('msg.createAds'):]</button>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
