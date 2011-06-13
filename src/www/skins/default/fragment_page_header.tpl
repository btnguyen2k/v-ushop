<!-- HEADER -->
<!-- Background -->
<div id="header-section"><a href="[:$MODEL.urlHome:]"><img id="header-background-left"
    src="./img/KNbabyshop-logo-01.jpg" alt="" /></a> <img id="header-background-right"
    src="./img/KNbabyshop-banner-01.jpg" alt="" /></div>
<!-- Navigation -->
<div id="header">
    <ul>
        <li><a href="[:$MODEL.urlHome:]">[:$MODEL.language->getMessage('msg.home'):]</a></li>
        [:if isset($MODEL.urlLogout):]
            <li><a href="[:$MODEL.urlLogout:]">[:$MODEL.language->getMessage('msg.logout'):]</a></li>
        [:else:]
            <li><a href="[:$MODEL.urlLogin:]">[:$MODEL.language->getMessage('msg.login'):]</a></li>
            <li><a href="[:$MODEL.urlRegister:]">[:$MODEL.language->getMessage('msg.register'):]</a></li>
        [:/if:]
        [:if isset($MODEL.urlAdmin):]
            <li class="float-right"><a href="[:$MODEL.urlAdmin:]">[:$MODEL.language->getMessage('msg.adminCp'):]</a></li>
        [:/if:]
    </ul>
</div>
<!-- //HEADER -->
