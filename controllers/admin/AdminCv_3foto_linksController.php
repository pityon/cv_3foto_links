<?php
class AdminCv_3foto_linksController extends ModuleAdminController
{
    public function __construct() {
        $module_name = "cv_3foto_links";
        Tools::redirectAdmin('index.php?controller=AdminModules&configure=' . $module_name . '&token=' . Tools::getAdminTokenLite('AdminModules'));
    }
}