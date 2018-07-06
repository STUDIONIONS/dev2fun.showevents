<?php
/**
 * Install
 * @author dev2fun (darkfriend)
 * @copyright (c) 2018, darkfriend <hi@darkfriend.ru>
 * @version 1.0.0
 */
IncludeModuleLangFile(__FILE__);

\Bitrix\Main\Loader::registerAutoLoadClasses(
    "dev2fun.showevents",
    array(
        'Dev2funShowEvents' => 'include.php',
    )
);

if(class_exists("dev2fun_showevents")) return;

use Bitrix\Main\Localization\Loc,
    Bitrix\Main\Config\Option;

Class dev2fun_showevents extends CModule
{
    var $MODULE_ID = "dev2fun.showevents";
    var $MODULE_VERSION;
    var $MODULE_VERSION_DATE;
    var $MODULE_NAME;
    var $MODULE_DESCRIPTION;
    var $MODULE_GROUP_RIGHTS = "Y";

    function dev2fun_showevents() {
        $path = str_replace("\\", "/", __FILE__);
        $path = substr($path, 0, strlen($path) - strlen("/index.php"));
        include($path."/version.php");
        if (isset($arModuleVersion) && is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion)){
            $this->MODULE_VERSION = $arModuleVersion["VERSION"];
            $this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
        } else {
            $this->MODULE_VERSION = '1.0.0';
            $this->MODULE_VERSION_DATE = '2018-07-02 15:00:00';
        }
        $this->MODULE_NAME = Loc::getMessage("DEV2FUN_MODULE_NAME_SHOWEVENTS");
        $this->MODULE_DESCRIPTION = Loc::getMessage("DEV2FUN_MODULE_DESCRIPTION_SHOWEVENTS");
        $this->PARTNER_NAME = "dev2fun";
        $this->PARTNER_URI = "http://dev2fun.com/";
    }

    function DoInstall() {
        global $APPLICATION;
        if(!check_bitrix_sessid()) return;
        try {
            \Bitrix\Main\ModuleManager::registerModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage("D2F_SHOWEVENTS_STEP1"), __DIR__."/step1.php");
        } catch (Exception $e) {
            $APPLICATION->ThrowException($e->getMessage());
            return false;
        }
        return true;
    }

    function DoUninstall() {
        global $APPLICATION;
        if(!check_bitrix_sessid()) return false;
        try {
            \Bitrix\Main\ModuleManager::unRegisterModule($this->MODULE_ID);
            $APPLICATION->IncludeAdminFile(Loc::getMessage("D2F_SHOWEVENTS_UNSTEP1"), __DIR__."/unstep1.php");
        } catch (Exception $e) {
            $APPLICATION->ThrowException($e->getMessage());
            return false;
        }
        return true;
    }
}
?>