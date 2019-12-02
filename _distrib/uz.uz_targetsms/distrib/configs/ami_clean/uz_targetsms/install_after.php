<?php

    // File system storage driver
    $oStorage = AMI::getResource('storage/fs');

    // Template system storage driver
    $oTplStorage = AMI::getResource('storage/tpl');

    // Distrib source path
    $srcPath = dirname(__FILE__) . '/';

    // Website _local files path
    $destPath = AMI_Registry::get('path/root') . '_local/';

    // Adds custom status message after installation
    // File messages.lng must be placed in the same directory as this file.

    $this->oArgs->oPkgCommon->loadStatusMessages('messages.lng');
    $this->oArgs->oPkgCommon->addStatusMessage('after_install', array(), AMI_Response::STATUS_MESSAGE_WARNING);

    // Get module license if uz_core is installed
    if(file_exists($destPath."modules/code/UZO.php")){
        @include_once($destPath.'modules/code/UZO.php');
        @include_once($destPath.'modules/code/UZO_AMI.php');

        UZO_AMI::onInstallModuleGetLicense("uz_targetsms");
    }

    $file = 'common_functions.php';
    $oArgs = new AMI_Tx_Cmd_Args(
        array(
            'destPath' => $destPath,
            // Hypermodule
            'hypermod' => $this->oArgs->hypermod,
            // Configuration
            'config'   => $this->oArgs->config,
            // Package Id
            'pkgId'   => $this->oArgs->pkgId,
            // Instance Id
            'modId'    => $this->oArgs->modId,
            // Installation mode
            'mode'     => $this->oArgs->mode,
            // Source PHP-file path
            'handlerRegistrationSource' => $srcPath . 'commonEventHandlersRegistration.php',
            // Source PHP-file path
            'handlerDeclarationSource'  => $srcPath . 'commonEventHandlersDeclaration.php',
            // Target PHP-file to patch
            'target'   => $destPath . $file,
             // Storage driver
            'oStorage' => $oStorage
        )
    );
    $this->aTx['storage']->addCommand('pkg/handlers/install', $oArgs);
