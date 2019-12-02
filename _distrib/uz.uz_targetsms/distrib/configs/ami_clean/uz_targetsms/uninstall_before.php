<?php

    $oStorage = AMI::getResource('storage/fs');
    $srcPath = dirname(__FILE__) . '/';
    $destPath = AMI_Registry::get('path/root') . '_local/';

    $file = 'common_functions.php';
    $oArgs = new AMI_Tx_Cmd_Args(
        array(
            'hypermod' => $this->oArgs->hypermod,
            'config'   => $this->oArgs->config,
            'pkgId'   => $this->oArgs->pkgId,
            'modId'    => $this->oArgs->modId,
            'mode'     => $this->oArgs->mode,
            'target'   => $destPath . $file,
            'oStorage' => $oStorage
        )
    );
    $this->aTx['storage']->addCommand('pkg/handlers/uninstall', $oArgs);

    /* Include optimizer core (installed, or included in distributive) */
    if(file_exists($destPath."modules/code/UZO.php")){
        @include_once($destPath.'modules/code/UZO.php');
        @include_once($destPath.'modules/code/UZO_AMI.php');

        /* Disable core if no other modules exists */
        UZO_AMI::uninstallIfNoNeed("uz_targetsms");
    }

