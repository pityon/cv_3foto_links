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

class Cv_3foto_links extends Module
{
    protected $config_form = false;

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
    }


    public function install()
    {
        return parent::install() &&
            $this->registerHook('header') &&
            $this->registerHook('displayHome') &&
            $this->installTab('AdminParentThemes', 'AdminCv_3foto_links', 'Convertis Boksy strony głównej');
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


    public function getContent()
    {
        $output = '';

        if (((bool)Tools::isSubmit('submitCv_3foto_linksModule')) == true) {
            $output .= $this->postProcess();
        }

        $output .= $this->context->smarty->fetch($this->local_path.'views/templates/admin/configure.tpl');

        return $output.$this->renderForm();
    }


    protected function renderForm()
    {
        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->table = $this->table;
        $helper->module = $this;
        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCv_3foto_linksModule';
        $helper->currentIndex = $this->context->link->getAdminLink('AdminModules', false)
            .'&configure='.$this->name.'&tab_module='.$this->tab.'&module_name='.$this->name;
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(), /* Add values for your inputs */
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
        );

        return $helper->generateForm($this->getConfigForm());
    }


    protected function getConfigForm()
    {
        $preview1 = Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE');
        $preview2 = Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE');
        $preview3 = Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE');

        return array(
            'first' => array(
                'form' => array(
                    'legend' => array(
                    'title' => $this->l('Blok 1'),
                    'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Nazwa'),
                            'name' => 'CV_3FOTO_LINKS_FIRST_TITLE',
                            'required' => true,
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'textarea',
                            'label' => $this->l('Opis'),
                            'name' => 'CV_3FOTO_LINKS_FIRST_DESC',
                            'autoload_rte' => 'rte',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Link'),
                            'name' => 'CV_3FOTO_LINKS_FIRST_URL',
                            'prefix' => 'URL',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'file',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_FIRST_IMAGE',
                            'required' => true,
                            'desc' => $preview1 ? $this->l('Wgrano plik').': '.$preview1 : null,
                        ),
                    ),
                ),
            ),
            'second' => array(
                'form' => array(
                    'legend' => array(
                    'title' => $this->l('Blok 2'),
                    'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Nazwa'),
                            'name' => 'CV_3FOTO_LINKS_SECOND_TITLE',
                            'required' => true,
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'textarea',
                            'label' => $this->l('Opis'),
                            'name' => 'CV_3FOTO_LINKS_SECOND_DESC',
                            'autoload_rte' => 'rte',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Link'),
                            'name' => 'CV_3FOTO_LINKS_SECOND_URL',
                            'prefix' => 'URL',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'file',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_SECOND_IMAGE',
                            'required' => true,
                            'desc' => $preview2 ? $this->l('Wgrano plik').': '.$preview2 : null,
                        ),
                    ),
                ),
            ),
            'third' => array(
                'form' => array(
                    'legend' => array(
                    'title' => $this->l('Blok 3'),
                    'icon' => 'icon-cogs',
                    ),
                    'input' => array(
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Nazwa'),
                            'name' => 'CV_3FOTO_LINKS_THIRD_TITLE',
                            'required' => true,
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'textarea',
                            'label' => $this->l('Opis'),
                            'name' => 'CV_3FOTO_LINKS_THIRD_DESC',
                            'autoload_rte' => 'rte',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'text',
                            'label' => $this->l('Link'),
                            'name' => 'CV_3FOTO_LINKS_THIRD_URL',
                            'prefix' => 'URL',
                            'lang' => true,
                        ),
                        array(
                            'type'  => 'file',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_THIRD_IMAGE',
                            'required' => true,
                            'desc' => $preview3 ? $this->l('Wgrano plik').': '.$preview3 : null,
                        ),
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                    ),
                ),
            ),
        );
    }


    protected function getConfigFormValues()
    {
        return array(
            // FIRST BLOCK
            'CV_3FOTO_LINKS_FIRST_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_TITLE', $this->l('Tytuł edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_FIRST_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_DESC', $this->l('Opis edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_FIRST_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_URL', '#'),
            'CV_3FOTO_LINKS_FIRST_IMAGE' => Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE'),
            // SECOND BLOCK
            'CV_3FOTO_LINKS_SECOND_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_TITLE', $this->l('Tytuł edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_SECOND_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_DESC', $this->l('Opis edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_SECOND_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_URL', '#'),
            'CV_3FOTO_LINKS_SECOND_IMAGE' => Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE'),
            // THIRD BLOCK
            'CV_3FOTO_LINKS_THIRD_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_TITLE', $this->l('Tytuł edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_THIRD_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_DESC', $this->l('Opis edytowalny z poziomu modułu ').$this->name),
            'CV_3FOTO_LINKS_THIRD_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_URL', '#'),
            'CV_3FOTO_LINKS_THIRD_IMAGE' => Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE'),
        );
    }


    protected function postProcess()
    {
        $form_values = $this->getConfigFormValues();
        $languages = Language::getLanguages(false);
        $warnings = '';

        foreach (array_keys($form_values) as $key) {
            // IMAGE UPLOAD
            if (strpos($key, '_IMAGE') !== false) {
                if (strlen($_FILES[$key]['tmp_name'])) {
                    $info = getimagesize($_FILES[$key]['tmp_name']);
                    $extensions = array(IMAGETYPE_GIF, IMAGETYPE_JPEG, IMAGETYPE_PNG);
                    if ($info === FALSE) {
                        $warnings .= $this->displayWarning($this->l('Niewspierany format pliku'));
                    }
                    elseif (!in_array($info[2], $extensions)) {
                        $warnings .= $this->displayWarning($this->l('Plik nie jest w formacie gif/jpeg/png'));
                    }
                    else {
                        $old_file = Configuration::get($key);
                        if ($old_file) {
                            @unlink(dirname(__FILE__).'/upload/'.$old_file);
                        }

                        $destinationFile = dirname(__FILE__).'/upload/'.$_FILES[$key]['name'];
                        move_uploaded_file($_FILES[$key]['tmp_name'], $destinationFile);

                        if (Module::isEnabled('cv_webp')) {
                            $ext = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
                            if (!ImageManager::resize(
                                $destinationFile,       // sourceFile
                                $destinationFile,       // destinationFile
                                $info[0],               // destinationWidth
                                $info[1],               // destinationHeight
                                $ext                   // fileType
                            )) {
                                $warnings .= $this->displayWarning($this->l('Nie można było wygenerować formatu webp'));
                            }
                        }

                        Configuration::updateValue($key, Tools::getValue($key));
                    }
                }
            }
            // DEFAULT BEHAVIOUR
            else {
                $html = strpos($key, '_DESC') !== false;
                $values = array();
                foreach ($languages as $lang) {
                    $values[$lang['id_lang']] = Tools::getValue($key.'_'.$lang['id_lang']);
                }
                Configuration::updateValue($key, $values, $html);
            }
        }

        return $warnings.$this->displayConfirmation($this->trans('The settings have been updated.', array(), 'Admin.Notifications.Success'));
    }

    
    public function hookHeader()
    {
        $this->context->controller->addCSS($this->_path.'views/css/front.css');
    }


    public function hookDisplayHome()
    {
        $form_values = $this->getConfigFormValues();
        $id_lang = $this->context->language->id;
        
        $values = array();
        foreach ($form_values as $key => $value) {
            $key_split = explode('_', $key);
            $attr = strtolower(array_pop($key_split));
            $slide = strtolower(implode('_', $key_split));

            if (is_array($value)) {
                $values[$slide][$attr] = $value[$id_lang];
            }
            else {
                $values[$slide][$attr] = $value;
            }
        }

        $this->context->smarty->assign('cv_3foto_blocks', $values);
        $this->context->smarty->assign('cv_3foto_upload_dir', _MODULE_DIR_ . 'cv_3foto_links/upload/');
        return $this->display(__FILE__, 'cv_3foto_links.tpl');
    }
}
