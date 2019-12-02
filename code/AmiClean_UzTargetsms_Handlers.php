<?php
/**
 * @copyright Ugol zreniya. All rights reserved.
 * @author Sergey Prisyazhnyuk
 * @package   Config_AmiClean_UzTargetsms
 * @license MIT; see LICENSE.txt
 */

class AmiClean_UzTargetsms_OrderStatusHandler {

    //
    // Defines
    //
    protected $langData = "ru";
    protected $tplPostfix = "";
    protected $tplBlockName = "uz_targetsms_sms_templates";
    protected $tplFileNamePrefix = "_local/_admin/templates/modules/";
    protected $tplFileNamePostfix = "_sms_templates.tpl";

    protected $serviceUrlJSON = "https://sms.targetsms.ru/sendsmsjson.php";

    //
    // Vars
    //
    protected $modId = "";
    protected $tplFileName = "";
    protected $oTpl = null;
    protected $tableName = "";
    protected $oDB = null;


    public function __construct(){
        $this->oDB = AMI::getSingleton("db");
    }

    public function processEvent(&$aEvent){
        $this->modId = $GLOBALS["uzTargetsmsModId"];
        //$this->deb("processEvent ".$this->modId.", status = ".$aEvent["status"]);
        if($this->modId != ""){

            $this->tableName = "cms_".$this->modId;

            if(is_null($this->oTpl)){
                $this->tplFileName = $this->tplFileNamePrefix.$this->modId.$this->tplFileNamePostfix;
                $this->oTpl = AMI::getResource('env/template_sys');
                $this->oTpl->addBlock($this->tplBlockName, $this->tplFileName);
            }

            $aOrder = $aEvent["oItem"]->getData();
            if(isset($aOrder["status_history"])){
                unset($aOrder["status_history"]);
            }
            if(isset($aOrder["data"])){
                unset($aOrder["data"]);
            }
            if(isset($aOrder["statuses_history"])){
                unset($aOrder["statuses_history"]);
            }
            if(isset($aOrder["ext_data"])){
                unset($aOrder["ext_data"]);
            }
            if(isset($aOrder["custinfo"])){
                unset($aOrder["custinfo"]);
            }
            if(isset($aOrder["sysinfo"])){
                unset($aOrder["sysinfo"]);
            }

            // Force user event status
            $aOrder["status"] = $aEvent["status"];

            $aOrder = $this->flatArray($aOrder);

            // Prepare phone
            $aOrder["phone"] = $this->validatePhone($aOrder["custom_info_contact"]);

            // Prepare totals
            $aOrder += $this->recalcOrderTotals($aOrder);

            // Prepare options
            $aOrder["login"] = trim(AMI::getOption($this->modId, "login"));
            $aOrder["pass"] = trim(AMI::getOption($this->modId, "pass"));
            $aOrder["sender_name"] = trim(AMI::getOption($this->modId, "sender_name"));

            //$this->deb("processEvent aOrder", $aOrder);

            if($aOrder["login"] != "" && $aOrder["pass"] != ""){
                if($aOrder["sender_name"] != ""){

                    //$this->deb("processEvent can send");

                    // Add SMS to user
                    $frnText = trim($this->oTpl->parse($this->tplBlockName.":".$aOrder["status"]."_frn", $aOrder));
                    //$this->deb("processEvent frnText = '$frnText' set name = '".$aOrder["status"]."_frn'");
                    if($frnText != ""){

                        if($this->isValidPhone($aOrder["phone"])){

                            //$this->deb("processEvent user phone valid");
                            $idSms = $this->createSms($aOrder["id"], $aOrder["phone"], $frnText, "frn", $aOrder["sender_name"]);
                            if($idSms){

                                $aMessages = array();

                                $aAbonents = array(
                                    array(
                                        "phone" => $aOrder["phone"],
                                        "number_sms" => 1,
                                        "client_id_sms" => $idSms,
                                    )
                                );

                                $aMessages[] = array(
                                    "type" => "sms",
                                    "sender" => $aOrder["sender_name"],
                                    "text" => $frnText,
                                    "abonent" => $aAbonents,
                                );

                                $aPkg = array(
                                    "security" => array(
                                        "login" => $aOrder["login"],
                                        "password" => $aOrder["pass"]
                                     ),
                                     "type" => "sms",
                                     "message" => $aMessages
                                );
                                $this->sendPkg($aPkg);

                            } else {
                                trigger_error("TargetSMS warning: Fail to create sms record frn for ".$aOrder["phone"]);
                            }

                        } else {
                            trigger_error("TargetSMS warning: User phone number ".$aOrder["phone"]." is invalid, sms not sended.", E_USER_WARNING);
                        }
                    }


                    // Add SMS to admin
                    $aAdminNumbers = $this->getAdminNumbers();
                    //$this->deb("aAdminNumbers", $aAdminNumbers);

                    if(count($aAdminNumbers)){
                        // Add SMS to user
                        $admText = trim($this->oTpl->parse($this->tplBlockName.":".$aOrder["status"]."_adm", $aOrder));
                        //$this->deb("admText = '$admText', set name = '".$aOrder["status"]."_adm'");
                        if($admText != ""){
                            $aAbonents = array();
                            $num = 1;
                            for($i = 0; $i < count($aAdminNumbers); $i++){
                                $idSms = $this->createSms($aOrder["id"], $aAdminNumbers[$i], $admText, "adm", $aOrder["sender_name"]);
                                if($idSms){
                                    $aAbonents[] = array(
                                        "phone" => $aAdminNumbers[$i],
                                        "number_sms" => $num,
                                        "client_id_sms" => $idSms,
                                    );
                                    $num++;
                                } else {
                                    trigger_error("TargetSMS warning: Fail to create sms record adm for ".$aAdminNumbers[$i]);
                                }

                            }

                            if(count($aAbonents)){
                                $aMessages = array();
                                $aMessages[] = array(
                                    "type" => "sms",
                                    "sender" => $aOrder["sender_name"],
                                    "text" => $admText,
                                    "abonent" => $aAbonents,
                                );
                                $aPkg = array(
                                    "security" => array(
                                        "login" => $aOrder["login"],
                                        "password" => $aOrder["pass"]
                                     ),
                                     "type" => "sms",
                                     "message" => $aMessages
                                );
                                $this->sendPkg($aPkg);
                            }
                        }
                    }

                } else {
                    trigger_error("TargetSMS warning: sender name is not defined. Check module options.", E_USER_WARNING);
                }
            } else {
                trigger_error("TargetSMS warning: login or password is not defined. Check module options.", E_USER_WARNING);
            }
        }
    }

    protected function validatePhone($str){
        $res = trim(preg_replace("/[^0-9]/", "", $str));
        if(preg_match("/^[78]?(9[0-9]{9,9})$/", $res, $aMatch)){
            $res = "7".$aMatch[1];
        }
        return $res;
    }

    protected function isValidPhone($str){
        $res = 1;

        if(substr($str, 0, 2) == "79"){
            // Check as russian phone
            if(strlen($str) < 11 || strlen($str) > 11){
                $res = 0;
            }
        } else {
            // Check as other country phone
            if(strlen($str) < 11 || strlen($str) > 13){
                $res = 0;
            }
        }

        //$this->deb("isValidPhone str = $str, res = $res");
        return $res;
    }

    protected function recalcOrderTotals($aOrder){
        $id = intval($aOrder["id"]);
        $aRes = array(
            "total_price_discount_abs" => 0,
            "total_price_original_abs" => 0,
            "total_qty" => 0,
            "total_discont_abs" => 0,
            "total_discount_percent" => 0,
        );
        if($id > 0){
            $aItems = array();
            $oSnippet = DB_Query::getSnippet("select * from `cms_es_order_items` where id_order = ".$id);
            $oRS = $this->oDB->select($oSnippet);
            foreach($oRS as $aRecord){
                $aRecord["ext_data"] = unserialize($aRecord["ext_data"]);
                $aItems[] = $aRecord;
            }
            //$this->deb("recalcOrderTotals aItems", $aItems);

            if(count($aItems)){
                $percentDiscountIsCommon = 1;
                $percentDiscountLastVal = null;
                foreach($aItems as $aItem){
                    $qty = floatval($aItem["qty"]);
                    $priceDiscount = floatval($aItem["price"]);
                    $priceOriginal = floatval($aItem["ext_data"]["item_info"]["original_price"]);
                    $discountPercent = floatval($aItem["ext_data"]["item_info"]["percentage_discount"]);
                    //$discountAbs = floatval($aItem["ext_data"]["item_info"]["absolute_discount"]);

                    $aRes["total_price_discount_abs"] += $priceDiscount * $qty;
                    $aRes["total_price_original_abs"] += $priceOriginal * $qty;
                    $aRes["total_qty"] += $qty;;

                    if(is_null($percentDiscountLastVal)){
                        $percentDiscountLastVal = $discountPercent;
                    }
                    if($percentDiscountLastVal != $discountPercent){
                        $percentDiscountIsCommon = 0;
                    }
                }

                $aRes["total_discount_abs"] = $aRes["total_price_original_abs"] - $aRes["total_price_discount_abs"];

                if($percentDiscountIsCommon){
                    $aRes["discount_percent"] = $percentDiscountLastVal;
                } else {
                    if($aRes["total_price_original_abs"] > 0){
                        $aRes["total_discount_percent"] = $aRes["total_discount_abs"] * 100 / $aRes["total_price_original_abs"];
                    }
                }
            }
        }

        $aRes += array(
            "total_price_discount_with_shipping_abs" => $aRes["total_price_discount_abs"] + $aOrder["shipping"],
            "total_price_original_with_shipping_abs" => $aRes["total_price_original_abs"] + $aOrder["shipping"],
        );

        //$this->deb("recalcOrderTotals aRes", $aRes);
        return $aRes;
    }


    protected function getAdminNumbers(){
        $aRes = array();

        $opt = trim(AMI::getOption($this->modId, "admins_phones"));
        $aOpt = explode("\n", $opt);

        foreach($aOpt as $row){
            $row = $this->validatePhone($row);
            if($this->isValidPhone($row)){
                $aRes[] = $row;
            }
        }

        $aRes = array_values(array_unique($aRes));

        return $aRes;
    }

    protected function flatArray($aData, $prefix = ""){
        $aRes = array();
        if(is_array($aData) && count($aData)){
            foreach($aData as $key => $val){
                if(is_array($val)){
                    $aRes += $this->flatArray($val, $prefix.$key."_");
                } else {
                    $aRes[$prefix.$key] = $val;
                }
            }
        }
        return $aRes;
    }


    protected function createSms($idOrder, $phone, $text, $targetType, $senderName){
        $aSql = array(
            "lang" => $this->langData,
            "date_created" => date("Y-m-d H:i:s"),
            "id_order" => $idOrder,
            "target_type" => $targetType,
            "sender" => $senderName,
            "phone" => $phone,
            "msg" => $text,
        );
        $oSnippet = DB_Query::getInsertQuery($this->tableName, $aSql);
        $this->oDB->query($oSnippet);
        $res = $this->oDB->getInsertId();
        return $res;
    }


    protected function sendPkg($aPkg){
        //$this->deb("sendPkg aPkg", $aPkg);
        $data = json_encode($aPkg, true);

        $aHeaders = array(
            'Content-Type: application/json',
            'charset=utf-8',
            'Expect: ',
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_HTTPHEADER, $aHeaders);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_TIMEOUT, 600);
        curl_setopt($ch, CURLOPT_URL, $this->serviceUrlJSON);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, false);
        $res = curl_exec($ch);
        //$this->deb("sendPkg res = '$res'");

        $aInfo = curl_getinfo($ch);
        //$this->deb("sendPkg aInfo", $aInfo);

        $aRes = json_decode($res, true);
        curl_close($ch);

        //$this->deb("sendPkg aRes", $aRes);

        // Process result
        $this->processResult($aPkg, $aRes);
    }

    // Process result
    protected function processResult($aPkg, $aRes){
        if(isset($aRes["error"])){
            // Global error
            foreach($aPkg["message"][0]["abonent"] as $aSms){
                $aSql = array(
                    "error" => $aRes["error"],
                    "resp" => json_encode($aRes, true),
                );
                $oSnippet = DB_Query::getUpdateQuery($this->tableName, $aSql, "where id = ".intval($aSms["client_id_sms"]));
                $this->oDB->query($oSnippet);
            }
        }
        if(isset($aRes["sms"])){
            // Process by item
            foreach($aRes["sms"] as $aResItem){
                $aSrcItem = $this->getPgkItemByNumber($aPkg, $aResItem["number_sms"]);
                if(is_array($aSrcItem)){
                    if(isset($aResItem["error"])){
                        // Item error
                        $aSql = array(
                            "error" => $aResItem["error"],
                            "resp" => json_encode($aResItem, true),
                        );
                        $oSnippet = DB_Query::getUpdateQuery($this->tableName, $aSql, "where id = ".intval($aSrcItem["client_id_sms"]));
                        $this->oDB->query($oSnippet);
                    } else {
                        // Item OK
                        $aSql = array(
                            "id_sms" => $aResItem["id_sms"],
                            "resp" => json_encode($aResItem, true),
                        );
                        $oSnippet = DB_Query::getUpdateQuery($this->tableName, $aSql, "where id = ".intval($aSrcItem["client_id_sms"]));
                        $this->oDB->query($oSnippet);
                    }
                }
            }
        }
    }

    protected function getPgkItemByNumber($aPkg, $numberSms){
        $aRes = null;
        foreach($aPkg["message"][0]["abonent"] as $aSms){
            if($aSms["number_sms"] == $numberSms){
                $aRes = $aSms;
                break;
            }
        }
        return $aRes;
    }


    protected function deb($str, $aData = null){
        if(is_null($aData)){
            AMI_Service::log($str, AMI_Registry::get('path/root')."_admin/_logs/uz_targetsms_deb.log");
        } else {
            AMI_Service::log($str.": ".print_r($aData, true), AMI_Registry::get('path/root')."_admin/_logs/uz_targetsms_deb.log");
        }
    }

}


function uzTargetsmsHandleOrderStatusChange($name, array $aEvent, $handlerModId, $srcModId){
    $oMod = new AmiClean_UzTargetsms_OrderStatusHandler;
    $oMod->processEvent($aEvent);
    return $aEvent;
}
AMI_Event::addHandler('on_order_after_status_change', 'uzTargetsmsHandleOrderStatusChange', AMI_Event::MOD_ANY);
