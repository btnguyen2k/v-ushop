[:function name=printFormHeader form=NULL:]
    [:if isset($form.errorMessages) && count($form.errorMessages) gt 0:]
        [:foreach $form.errorMessages as $msg:]
            <span class="errorMsg">[:$msg:]</span>
        [:/foreach:]
        <br />
    [:/if:]
    [:if isset($form.infoMessages) && count($form.infoMessages) gt 0:]
        [:foreach $form.infoMessages as $msg:]
            <span class="infoMsg">[:$msg:]</span>
        [:/foreach:]
        <br />
    [:/if:]
[:/function:]

[:function renderMenuItemAction menuItem=NULL:]
    [:if isset($menuItem.URL):]
        onclick="window.location.href='[:$menuItem.URL:]';"
    [:elseif isset($menuItem.FORM):]
        onclick="apiOpenForm('[:$menuItem.FORM|escape:'html':]');"
    [:/if:]
[:/function:]

[:function name=printMenubarItem menuItem=NULL:]
    [:if isset($menuItem.CHILDREN):]
        <div dojoType="dijit.PopupMenuBarItem">
            <span>[:$menuItem.TITLE|escape:'html':]</span>
            <div dojoType="dijit.Menu">
                [:foreach $menuItem.CHILDREN as $child:]
                    [:call name="printMenuItem" menuItem=$child:]
                [:/foreach:]
            </div>
        </div>
    [:else:]
        <div dojoType="dijit.MenuBarItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>
            [:$menuItem.TITLE|escape:'html':]
        </div>
    [:/if:]
[:/function:]

[:function name=printMenuItem menuItem=NULL:]
    [:if isset($menuItem.CHILDREN):]
        <div dojoType="dijit.PopupMenuItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>
            <span>[:$menuItem.TITLE|escape:'html':]</span>
            <div dojoType="dijit.Menu">
                [:foreach $menuItem.CHILDREN as $child:]
                    [:call name="printMenuItem" menuItem=$child:]
                [:/foreach:]
            </div>
        </div>
    [:else:]
        <div dojoType="dijit.MenuItem" [:call name="renderMenuItemAction" menuItem=$menuItem:]>[:$menuItem.TITLE|escape:'html':]</div>
    [:/if:]
[:/function:]
