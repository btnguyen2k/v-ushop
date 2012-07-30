[:include file="inc_inline_html_header.tpl":]
<body class="[:$DOJO_THEME:]">
    <h1 class="heading align-center viewport-800">[:$MODEL.language->getMessage('msg.userList'):]</h1>

    <script type="text/javascript">
        function refreshView(form) {
            form.submit();
        }
    </script>
    
    <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateUser:]');">[:$MODEL.language->getMessage('msg.createUser'):]</button>
    </div>
    
    <table cellpadding="2" class="align-center viewport-800">
    <thead>
        <tr>
            <th style="text-align: left;">[:$MODEL.language->getMessage('msg.user.username'):]</th>
            <th style="text-align: center;" width="160px">[:$MODEL.language->getMessage('msg.user.fullname'):]</th>
            <th style="text-align: center;" width="128px">[:$MODEL.language->getMessage('msg.user.email'):]</th>
            <th style="text-align: center;" width="128px">[:$MODEL.language->getMessage('msg.user.group'):]</th>
            <th style="text-align: center;" width="80px">[:$MODEL.language->getMessage('msg.actions'):]</th>
         </tr>
    </thead>
    <tbody>    	
        [:foreach $MODEL.userList as $_user:]
            <tr class="[:if $_user@index%2==0:]row-a[:else:]row-a[:/if:]">               
                <td>
                	[:$_user->getUsername()|escape:'html':]
                </td>
                <td style="text-align: center;">
                	[:$_user->getFullname()|escape:'html':]
                </td>
                <td style="text-align: center;">
                	[:$_user->getEmail()|escape:'html':]
                </td>
                <td style="text-align: center;">
                	[:call name=groupName groupId=$_user->getGroupId():]
                </td>
                <td style="text-align: center;" width="64px">
                    <a href="[:$_user->getUrlEdit():]"><img border="0" alt="" src="img/user_edit.png" /></a>
                    <!--
                    <a href="[:$_user->getUrlDelete():]"><img border="0" alt="" src="img/user_delete.png" /></a>
                    -->
                </td>
            </tr>
        [:foreachelse:]
            <tr>
                <td colspan="5">[:$MODEL.language->getMessage('msg.nodata'):]</td>
            </tr>
        [:/foreach:]        
    </tbody>
    </table>
    
     <div class="align-center viewport-800">
        <button dojoType="dijit.form.Button" onclick="openUrl('[:$MODEL.urlCreateUser:]');">[:$MODEL.language->getMessage('msg.createUser'):]</button>
    </div>
</body>
[:include file="inc_inline_html_footer.tpl":]
