<?php
// {{}}
if($oDeclarator->isRegistered("##modId##")){
    $oMod = $oDeclarator->getModule("##modId##");

    $oMod->addRule("login", AMI_Module::RLT_STRING, array(), "");
    $oMod->addRule("pass", AMI_Module::RLT_STRING, array(), "");
    $oMod->addRule("sender_name", AMI_Module::RLT_STRING, array(), "");
    $oMod->addRule("admins_phones", AMI_Module::RLT_TEXT, array(), "");

    $oMod->finalize();
}
