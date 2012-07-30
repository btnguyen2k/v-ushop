<div class="main" align="center">
    <div class="standard_error">
        <h2 class="blockhead">[:$LANG->getMessage('msg.login'):]</h2>
        
        <form class="vbform" method="post" action="">
       		[:call name=printFormHeader form=$MODEL.form:]
       <table style="padding: 20px;width: 400px">
    		<tr>
    			<td class="lable">[:$LANG->getMessage('msg.username'):]:</td>		
    			<td><input id="username"  value="" class="textbox" name="username" type="text" /></td>
    		</tr>
    		<tr>
    			<td class="lable">[:$LANG->getMessage('msg.password'):]:</td>		
    			<td><input  class="textbox" value="" name="password" type="password" /></td>
    		</tr>
    		<tr>
    			<td colspan="2" align="center"><br/>
        			<button type="submit" class="btn" >[:$LANGUAGE->getMessage('msg.login'):]</button>
        			<button type="button" class="btn" onclick="redirect('[:$MODEL.urlHome:]')">[:$LANGUAGE->getMessage('msg.cancelForm'):]</button>
    			</td>	
    		</tr>		
    	</table>
    		   
        </form>
	</div>
</div>