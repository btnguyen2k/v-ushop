
<div class="main" style="width: 885px; text-align: center">
    <div id="info" class="standard_error" align="left">
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
               [:if !isset($MODEL.urlTransit):]
               	<button class="btn" type="button" onclick="redirect('[:$MODEL.urlHome:]')">[:$LANG->getMessage('msg.home'):]</button>
               [:/if:]
               </br>
        </form>
       
    </div>
</div>
<script>
	jumpTo('info');
</script>