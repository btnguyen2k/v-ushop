
<div class="main" align="center">
    <div class="standard_error" align="left">
        <h2 class="blockhead">[:$LANG->getMessage('msg.message'):]</h2>
    	<form  id="[:$FORM.name|escape:'html':]" class="vbform" style="text-align: center;"
            name="[:$FORM.name|escape:'html':]" action="[:$FORM.action:]" method="post"> 
            <br/>          
             	[:foreach $MODEL.infoMessages as $msg:]
                    <p>[:$msg:]</p>
                [:/foreach:]
                [:if isset($MODEL.transitMessage):]
                    <p>[:$MODEL.transitMessage:]</p>
                [:/if:]
        </form>
       
    </div>
</div>