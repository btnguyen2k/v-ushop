
<div class="main" style="text-align: center;width: 900px;">
    <div id="info" class="standard_error" align="center">
        <h2 class="blockhead" style="font-size: 14;font-weight: bold;">[:$LANG->getMessage('msg.register'):]</h2>
    	<form  id="[:$FORM.name|escape:'html':]" class="vbform"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post"> 
            [:call name=printFormHeader form=$FORM:]
            <br/>
            <table>
            	<tr>
                    <td class="lable">[:$MODEL.language->getMessage('msg.user.username'):]:</td>
                    <td><input type="text" name="username" value="[:$MODEL.form.username|escape:'html':]"  /></td>
                </tr>
                <tr>
                    <td class="lable">[:$MODEL.language->getMessage('msg.user.email'):]:</td>
                <td><input type="text" name="email" value="[:$MODEL.form.email|escape:'html':]" /></td>
                </tr>
                <tr>
                    <td class="lable">[:$MODEL.language->getMessage('msg.user.password'):]:</td>
                	<td><input type="password" name="password" value=""  /></td>
                </tr>
                <tr>
               	 	<td class="lable">[:$MODEL.language->getMessage('msg.user.confirmedPassword'):]:</td>
                	<td><input type="password" name="confirmedPassword" value=""  /></td>
                </tr>
                <tr>
                	<td class="lable">[:$MODEL.language->getMessage('msg.user.fullname'):]:</td>
                	<td><input type="text" name="fullname" value="[:$MODEL.form.fullname|escape:'html':]" /></td>
                </tr>
                <tr>
                	<td class="lable">[:$MODEL.language->getMessage('msg.user.phone'):]:</td>
                	<td><input type="text" name="phone" value="[:$MODEL.form.phone|escape:'html':]" /></td>
                </tr>
                <tr>
                	<td class="lable">[:$MODEL.language->getMessage('msg.user.address'):]:</td>
                	<td><textarea  style="width: 240px;height: 60px" name="address" value="[:$MODEL.form.address|escape:'html':]" ></textarea> </td>
                </tr>
            </table>
            <br/>
           	<button class="btn" type="submit">[:$LANG->getMessage('msg.register'):]</button>
           	<button class="btn" type="button" onclick="redirect('[:$MODEL.urlHome:]')">[:$LANG->getMessage('msg.cancel'):]</button>
           	<br/>
           	<br/>
        </form>
       
    </div>
</div>
<script>
	jumpTo('info');
</script>