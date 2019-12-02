<?php
// {{}}
if($oDeclarator->isRegistered('##modId##')){
    $oMod = $oDeclarator->getModule('##modId##');
    $oMod->setProperty('taborder', $oDeclarator->getTabOrder('##modId##'));

    $oMod->setProperty('dont_show_in_pm', true);

}
