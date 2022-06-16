<?php

class AdminCv_3foto_linksController extends ModuleAdminController
{
    public function __construct()
    {
        $this->bootstrap = true;
        $this->display = 'view';
        parent::__construct();
        $this->meta_title = $this->l('Convertis Boksy strony głównej');
        if (!$this->module->active) {
            Tools::redirectAdmin($this->context->link->getAdminLink('AdminDashboard'));
        }
    }


    public function renderView()
    {
        return $this->renderForm();
    }


    public function renderForm()
    {
        $helper = new HelperForm();
        $helper->show_toolbar = false;
        $helper->table = 'configuration';
        $helper->module = $this->module;        // necessary only to allow form override (searches for file in specified directory -> eq. module)

        $helper->default_form_language = $this->context->language->id;
        $helper->allow_employee_form_lang = Configuration::get('PS_BO_ALLOW_EMPLOYEE_FORM_LANG', 0);

        $helper->identifier = $this->identifier;
        $helper->submit_action = 'submitCv_3foto_linksModule';
        $helper->token = Tools::getAdminTokenLite('AdminModules');

        $helper->tpl_vars = array(
            'fields_value' => $this->getConfigFormValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            // custom
            'image_baseurl' => _MODULE_DIR_.$this->module->name.DIRECTORY_SEPARATOR.'upload/',
        );

        return $helper->generateForm($this->getConfigForm());
    }


    protected function getConfigForm()
    {
        $fields = array(
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
                            'type' => 'file_preview',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_FIRST_IMAGE',
                            'required' => true,
                            'thumbnail' => Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE'),
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
                            'type' => 'file_preview',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_SECOND_IMAGE',
                            'required' => true,
                            'thumbnail' => Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE'),
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
                            'type' => 'file_preview',
                            'label' => $this->l('Zdjęcie'),
                            'name' => 'CV_3FOTO_LINKS_THIRD_IMAGE',
                            'required' => true,
                            'thumbnail' => Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE'),
                        ),
                    ),
                    'submit' => array(
                        'title' => $this->l('Save'),
                    ),
                ),
            ),
        );

        return $fields;
    }


    protected function getConfigFormValues()
    {
        if (version_compare(_PS_VERSION_, '1.7', '<')) {
            return array(
                // FIRST BLOCK
                'CV_3FOTO_LINKS_FIRST_TITLE' => Configuration::getInt('CV_3FOTO_LINKS_FIRST_TITLE'),
                'CV_3FOTO_LINKS_FIRST_DESC' => Configuration::getInt('CV_3FOTO_LINKS_FIRST_DESC'),
                'CV_3FOTO_LINKS_FIRST_URL' => Configuration::getInt('CV_3FOTO_LINKS_FIRST_URL'),
                'CV_3FOTO_LINKS_FIRST_IMAGE' => Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE'),
                // SECOND BLOCK
                'CV_3FOTO_LINKS_SECOND_TITLE' => Configuration::getInt('CV_3FOTO_LINKS_SECOND_TITLE'),
                'CV_3FOTO_LINKS_SECOND_DESC' => Configuration::getInt('CV_3FOTO_LINKS_SECOND_DESC'),
                'CV_3FOTO_LINKS_SECOND_URL' => Configuration::getInt('CV_3FOTO_LINKS_SECOND_URL'),
                'CV_3FOTO_LINKS_SECOND_IMAGE' => Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE'),
                // THIRD BLOCK
                'CV_3FOTO_LINKS_THIRD_TITLE' => Configuration::getInt('CV_3FOTO_LINKS_THIRD_TITLE'),
                'CV_3FOTO_LINKS_THIRD_DESC' => Configuration::getInt('CV_3FOTO_LINKS_THIRD_DESC'),
                'CV_3FOTO_LINKS_THIRD_URL' => Configuration::getInt('CV_3FOTO_LINKS_THIRD_URL'),
                'CV_3FOTO_LINKS_THIRD_IMAGE' => Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE'),
            );
        }
        else {
            return array(
                // FIRST BLOCK
                'CV_3FOTO_LINKS_FIRST_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_TITLE'),
                'CV_3FOTO_LINKS_FIRST_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_DESC'),
                'CV_3FOTO_LINKS_FIRST_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_FIRST_URL'),
                'CV_3FOTO_LINKS_FIRST_IMAGE' => Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE'),
                // SECOND BLOCK
                'CV_3FOTO_LINKS_SECOND_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_TITLE'),
                'CV_3FOTO_LINKS_SECOND_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_DESC'),
                'CV_3FOTO_LINKS_SECOND_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_SECOND_URL'),
                'CV_3FOTO_LINKS_SECOND_IMAGE' => Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE'),
                // THIRD BLOCK
                'CV_3FOTO_LINKS_THIRD_TITLE' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_TITLE'),
                'CV_3FOTO_LINKS_THIRD_DESC' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_DESC'),
                'CV_3FOTO_LINKS_THIRD_URL' => Configuration::getConfigInMultipleLangs('CV_3FOTO_LINKS_THIRD_URL'),
                'CV_3FOTO_LINKS_THIRD_IMAGE' => Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE'),
            );
        }
        
    }


    public static function getSmartyValues($id_lang) {
        return array(
            'first' => array(
                'title' => Configuration::get('CV_3FOTO_LINKS_FIRST_TITLE', $id_lang),
                'desc' => Configuration::get('CV_3FOTO_LINKS_FIRST_DESC', $id_lang),
                'url' => Configuration::get('CV_3FOTO_LINKS_FIRST_URL', $id_lang),
                'image' => Configuration::get('CV_3FOTO_LINKS_FIRST_IMAGE'),
            ),
            'second' => array(
                'title' => Configuration::get('CV_3FOTO_LINKS_SECOND_TITLE', $id_lang),
                'desc' => Configuration::get('CV_3FOTO_LINKS_SECOND_DESC', $id_lang),
                'url' => Configuration::get('CV_3FOTO_LINKS_SECOND_URL', $id_lang),
                'image' => Configuration::get('CV_3FOTO_LINKS_SECOND_IMAGE'),
            ),
            'third' => array(
                'title' => Configuration::get('CV_3FOTO_LINKS_THIRD_TITLE', $id_lang),
                'desc' => Configuration::get('CV_3FOTO_LINKS_THIRD_DESC', $id_lang),
                'url' => Configuration::get('CV_3FOTO_LINKS_THIRD_URL', $id_lang),
                'image' => Configuration::get('CV_3FOTO_LINKS_THIRD_IMAGE'),
            ),
        );
    }


    // in controller it is called automatically
    public function postProcess()
    {
        if (((bool)Tools::isSubmit('submitCv_3foto_linksModule')) == true) {
            $form_values = $this->getConfigFormValues();
            $languages = Language::getLanguages(false);

            foreach (array_keys($form_values) as $i => $key) {
                // IMAGE UPLOAD
                if (strpos($key, '_IMAGE') !== false) {
                    if (isset($_FILES[$key]['tmp_name']) && strlen($_FILES[$key]['tmp_name'])) {
                        if ($error = ImageManager::validateUpload($_FILES[$key])) {
                            $this->errors[] = $error;
                        }
                        else {
                            $file_name = 'bg' . md5_file($_FILES[$key]['tmp_name']) . $i;
                            if (Shop::getContext() == Shop::CONTEXT_GROUP) {
                                $file_name .= '-g'.(int)$this->context->shop->getContextShopGroupID();
                            }
                            elseif (Shop::getContext() == Shop::CONTEXT_SHOP) {
                                $file_name .= '-s'.(int)$this->context->shop->getContextShopID();
                            }

                            $info = getimagesize($_FILES[$key]['tmp_name']);
                            $ext = pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION);
                            $dir = dirname(__FILE__).'/../../upload/';

                            if (Module::isEnabled('cv_webp')) {
                                $file_name .= '.webp';
                            }
                            else {
                                $file_name .= '.'.$ext;
                            }

                            $old_file = Configuration::get($key);
                            $destination_file = $dir.$file_name;

                            if (!ImageManager::resize(
                                $_FILES[$key]['tmp_name'],
                                $destination_file,
                                $info[0],
                                $info[1],
                                $ext
                            )) {
                                $this->errors[] = $this->displayWarning($this->l('Nie można było zapisać pliku'));
                            }
                            else {
                                @unlink($dir.$old_file);
                            }

                            Configuration::updateValue($key, $file_name);
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

            if (!$this->errors) {
                $this->module->clearCache();
                $this->confirmations[] = $this->l('The settings have been updated.');
            }

            return true;
        }
    }

}
