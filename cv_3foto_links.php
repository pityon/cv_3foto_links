<?php
/**
* 2007-2022 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2022 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

if (!defined('_PS_VERSION_')) {
    exit;
}

require_once(dirname(__FILE__) . '/controllers/admin/AdminCv_3foto_linksController.php');

class Cv_3foto_links extends Module
{
    private $templateFiles;

    public function __construct()
    {
        $this->name = 'cv_3foto_links';
        $this->tab = 'front_office_features';
        $this->version = '1.0.0';
        $this->author = 'https://github.com/pityon/';
        $this->need_instance = 0;

        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Convertis Boksy strony głównej');
        $this->description = $this->l('Moduł generujący widok trzech zdjęć na stronie głównej z linkami i opisami.');

        $this->confirmUninstall = $this->l('Czy na pewno chcesz usunąć moduł wraz z zawartością?');

        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => _PS_VERSION_);

        $this->templateFiles = array(
            'displayHome' => 'module:cv_3foto_links/views/templates/front/cv_3foto_links.tpl',
        );
        $this->templateFiles16 = array(
            'displayHome' => array('cv_3foto_links.tpl', 'cv_3foto_links'),
        );
    }


    public function install()
    {
        $return = parent::install();
        $return &= $this->registerHook('header');
        $return &= $this->registerHook('actionAdminControllerSetMedia');
        $return &= $this->registerHook('displayHome');
        
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $return &= $this->installTab('AdminParentModules', 'AdminCv_3foto_links', 'Convertis Boksy strony głównej');
        }
        else {
            $return &= $this->installTab('AdminParentThemes', 'AdminCv_3foto_links', 'Convertis Boksy strony głównej');
        }

        $this->clearCache();

        return (bool)$return;
    }


    public function installTab($parent_class, $class_name, $name) 
    {
        $tab = new Tab();
        $tab->name = array();
        foreach (Language::getLanguages(true) as $lang) {
            $tab->name[$lang['id_lang']] = $name;
        }
        $tab->class_name = $class_name;
        $tab->id_parent = (int) Tab::getIdFromClassName($parent_class);
        $tab->module = $this->name;
        return $tab->add();
    }


    public function uninstall()
    {
        return 
        $this->uninstallTab('AdminCv_3foto_links') &&
        parent::uninstall();
    }

    
    public function uninstallTab($class_name)
    {
        $id_tab = (int)Tab::getIdFromClassName($class_name);
        $tab = new Tab((int)$id_tab);
        return $tab->delete();
    }

    
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/front.css');
    }


    public function hookActionAdminControllerSetMedia()
	{
		if (!$this->active)
			return;

        if (get_class($this->context->controller) == 'AdminCv_3foto_linksController')
		{
            $this->context->controller->addCSS($this->_path.'views/css/back.css');
        }
	}


    public function hookDisplayHome()
    {
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            $cached = $this->isCached($this->templateFiles16['displayHome'][0], $this->getCacheId($this->templateFiles16['displayHome'][1]));
        }
        else {
            $cached = $this->isCached($this->templateFiles['displayHome'], $this->getCacheId());
        }

        if (!$cached) {
            $values = AdminCv_3foto_linksController::getSmartyValues($this->context->language->id);

            $this->context->smarty->assign('cv_3foto_blocks', $values);
            $this->context->smarty->assign('cv_3foto_upload_dir', _MODULE_DIR_ . 'cv_3foto_links/upload/');
        }

        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            return $this->display(__FILE__, $this->templateFiles16['displayHome'][0], $this->getCacheId($this->templateFiles16['displayHome'][1]));
        }

        return $this->fetch($this->templateFiles['displayHome'], $this->getCacheId());
    }


    // cache is saved to: \var\cache\dev\smarty\cache\cv_3foto_links\(...)
    public function clearCache()
    {
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            foreach ($this->templateFiles16 as $tpl) {
                $this->_clearCache($tpl[0], $tpl[1]);
            }
        }
        else {
            foreach ($this->templateFiles as $tpl) {
                $this->_clearCache($tpl);
            }
        }
    }

}
