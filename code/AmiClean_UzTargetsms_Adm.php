<?php
/**
 * @copyright Ugol zreniya. All rights reserved.
 * @author Sergey Prisyazhnyuk
 * @package   Config_AmiClean_UzTargetsms
 * @license MIT; see LICENSE.txt
 */

/**
 * AmiClean/UzTargetsms admin action controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_Adm extends Hyper_AmiClean_Adm{
    /**
     * Constructor.
     *
     * @param AMI_Request  $oRequest   Request
     * @param AMI_Response $oResponse  Response
     */
    public function __construct(AMI_Request $oRequest, AMI_Response $oResponse){
        parent::__construct($oRequest, $oResponse);

        $this->addComponents(
            array("form") // "filter", "list", "form" (order matters)
        );
    }
}

/**
 * AmiClean/UzTargetsms model.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Model
 */
class AmiClean_UzTargetsms_State extends Hyper_AmiClean_State{
}

/**
 * AmiClean/UzTargetsms admin filter component action controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_FilterAdm extends Hyper_AmiClean_FilterAdm{
}

/**
 * AmiClean/UzTargetsms item list component filter model.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Model
 */
class AmiClean_UzTargetsms_FilterModelAdm extends Hyper_AmiClean_FilterModelAdm{
}

/**
 * AmiClean/UzTargetsms admin filter component view.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage View
 */
class AmiClean_UzTargetsms_FilterViewAdm extends Hyper_AmiClean_FilterViewAdm{
}

/**
 * AmiClean/UzTargetsms admin form component action controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_FormAdm extends Hyper_AmiClean_FormAdm{
}

/**
 * AmiClean/UzTargetsms form component view.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage View
 */
class AmiClean_UzTargetsms_FormViewAdm extends Hyper_AmiClean_FormViewAdm{

    protected $langData = "en";

    /**
     * Fields init.
     *
     */
    public function init(){
        $this->langData = AMI_Registry::get('lang_data', 'ru');
        $this->addField(array("name" => "notes"));

        $modId = $this->getModId();

        $oModDeclarator = AMI_ModDeclarator::getInstance();
        $section = $oModDeclarator->getSection($modId);

        $this->aScope["modId"] = $modId;
        $this->aScope["section"] = $section;

        // Prepare template name and id
        $tplName = $modId."_sms_templates.tpl";

        $oDB = AMI::getSingleton("db");
        $oSnippet = DB_Query::getSnippet("select id from `cms_modules_templates` where name = %s limit 1")->q($tplName);
        $tplId = intval($oDB->fetchValue($oSnippet));

        $this->aScope["template_id"] = $tplId;
        $this->aScope["template_name"] = $tplName;

        //d::pr($this->aScope, "aScope");

        // Front-side domain
        $aIniData = parse_ini_file(AMI_Registry::get('path/root')."_local/config.ini.php");
        $this->aScope["root_path_www"] = $aIniData["ROOT_PATH_WWW"];
        if(mb_substr($this->aScope["root_path_www"], -1) != "/"){
            $this->aScope["root_path_www"] .= "/";
        }

        //d::pr($this->aScope, "aScope");

        return parent::init();
    }

}










/**
 * AmiClean/UzTargetsms admin list component action controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_ListAdm extends Hyper_AmiClean_ListAdm{
}


/**
 * AmiClean/UzTargetsms admin list component view.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage View
 */
class AmiClean_UzTargetsms_ListViewAdm extends Hyper_AmiClean_ListViewAdm{
}

/**
 * AmiClean/UzTargetsms admin list actions controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_ListActionsAdm extends AMI_ModListPositionActions{
}


/**
 * AmiClean/UzTargetsms admin list group actions controller.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Controller
 */
class AmiClean_UzTargetsms_ListGroupActionsAdm extends Hyper_AmiClean_ListGroupActionsAdm{
}


