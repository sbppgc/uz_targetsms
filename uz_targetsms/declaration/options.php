<?php
// {{}}
if($oDeclarator->isRegistered("##modId##")){
    $oMod = $oDeclarator->getModule("##modId##");
    $oMod->setOption("engine_version", "0600");

    $oMod->setOption("login", "");
    $oMod->setOption("pass", "");
    $oMod->setOption("sender_name", "");
    $oMod->setOption("admins_phones", "");

}
