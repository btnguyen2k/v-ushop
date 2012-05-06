[:include file="inc_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <div dojoType="dijit.layout.BorderContainer" design="headline" gutters="true" liveSplitters="false" id="main">
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="top" minSize="0">
            <strong><a href="[:$MODEL.urlHome:]">[:$MODEL.APP_NAME:]</a> |</strong>
            [:$LANG->getMessage('msg.info'):]
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="bottom" minSize="0" style="text-align: center;">
            [:$MODEL.APP_NAME:] [:$MODEL.APP_VERSION:] | [:$MODEL.page.copyright:]
        </div>
        <div dojoType="dijit.layout.ContentPane" splitter="false" region="center">
            <table class="form" style="width: 400px; margin: auto" cellspacing="10">
                <thead>
                    <tr>
                        <th>
                            [:$LANG->getMessage('msg.info'):]
                        </th>
                    </tr>
                </thead>
                <tr>
                    <td>
                        [:foreach $MODEL.infoMessages as $msg:]
                            <p style="font-size: 115%">[:$msg:]</p>
                        [:/foreach:]
                        [:if isset($MODEL.transitMessage):]
                            <p style="font-style: italic;">[:$MODEL.transitMessage:]</p>
                        [:/if:]
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
[:include file="inc_html_footer.tpl":]
