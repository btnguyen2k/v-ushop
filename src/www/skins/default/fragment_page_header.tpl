<!-- HEADER -->
<!-- Background -->
<!--
<div id="header-section"><a href="[:$MODEL.urlHome:]"><img id="header-background-left"
    src="./img/KNbabyshop-logo-01.jpg" alt="" /></a> <img id="header-background-right"
    src="./img/KNbabyshop-banner-01.jpg" alt="" /></div>
 -->
<div id="header-section" style="height: 120px">
    <div style="float: left; width: 145px; height: 120px;">
        <p style="font-weight: bold; text-align: center; margin-top: 16px;">KHÁNH NGỌC<br/>BABY SHOP</p>
        <p style="text-align: center;">260/9A Nguyễn Thái Bình, P12, QTB, TpHCM</p>
        <p style="text-align: center;">ĐT: <strong>0983208247 (Thuý)</strong></p>
    </div><div style=""><img id="header-background-right" src="./img/KNbabyshop-banner-01.jpg"
        alt="" /></div>
</div>
<!-- Navigation -->
<div id="header">
    <ul>
        <li><a href="[:$MODEL.urlHome:]">[:$MODEL.language->getMessage('msg.home'):]</a></li>
        [:foreach $MODEL.onMenuPages as $page:]
            <li><a href="[:$page->getUrlView():]">[:$page->getTitle()|escape:'html':]</a></li>
        [:/foreach:]

        [:if isset($MODEL.urlLogout):]
            <li class="float-right"><a href="[:$MODEL.urlLogout:]">[:$MODEL.language->getMessage('msg.logout'):]</a></li>
            <li class="float-right"><a href="[:$MODEL.urlProfileCp:]">[:$MODEL.language->getMessage('msg.profileCp'):]</a></li>
        [:else:]
            <li class="float-right"><a href="[:$MODEL.urlLogin:]">[:$MODEL.language->getMessage('msg.login'):]</a></li>
            [:if isset($MODEL.urlRegister):]
                <li class="float-right"><a href="[:$MODEL.urlRegister:]">[:$MODEL.language->getMessage('msg.register'):]</a></li>
            [:/if:]
        [:/if:]
        [:if isset($MODEL.urlAdmin):]
            <li class="float-right"><a href="[:$MODEL.urlAdmin:]">[:$MODEL.language->getMessage('msg.adminCp'):]</a></li>
        [:/if:]
    </ul>
</div>
<!-- //HEADER -->
