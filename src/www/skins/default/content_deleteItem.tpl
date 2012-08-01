<div class="main" align="center">
    <div class="standard_error" align="left">
        <h2 class="blockhead">[:$LANG->getMessage('msg.message'):]</h2>
    	<form  id="[:$FORM.name|escape:'html':]" class="vbform" style="text-align: center;"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post"> 
            <br/>          
            [:call name="printFormHeader" form=$FORM:]
            
            <button class="btn" type="submit">&nbsp;&nbsp;[:$LANG->getMessage('msg.yes'):]&nbsp;&nbsp;</button>
            <button class="btn" type="button" onclick="redirect('[:$MODEL.form.actionCancel:]');">[:$LANG->getMessage('msg.cancelForm'):]</button> <br/> <br/>
        </form>
       
    </div>
</div>