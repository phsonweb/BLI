<?php
ArContactUsLoader::loadClass('ArContactUsAbstract');
ArContactUsLoader::loadModel('ArContactUsModel');
ArContactUsLoader::loadModel('ArContactUsCallbackModel');
ArContactUsLoader::loadModel('ArContactUsPromptModel');

class ArContactUs extends ArContactUsAbstract
{
    public function css()
    {
        return array(
            'jquery.contactus.css' => 'res/css/jquery.contactus.min.css'
        );
    }
    
    public function js()
    {
        return array(
            'jquery' => null,
            'jquery.contactus.scripts' => 'res/js/scripts.js',
            //'jquery.contactus.min.js' => 'res/js/jquery.contactus.min.js' moved to template
        );
    }
    
    public function init()
    {
        load_plugin_textdomain('ar-contactus', false, basename(AR_CONTACTUS_PLUGIN_DIR) . '/languages');
        $this->registerShortcodes();
        add_action('wp_footer', array($this, 'renderContactUsButton'));
        add_action('wp_enqueue_scripts', array($this, 'registerAjaxScript'));
        add_action('wp_print_styles', array($this, 'registerAssets'));
    }
    
    public function registerAssets()
    {
        $this->registerCss();
        $this->registerJs();
    }
    
    public function registerShortcodes()
    {
        add_shortcode('contactus_menu_item', array($this, 'contactusMenuItemShortcode'));
    }
    
    public function contactusMenuItemShortcode($params)
    {
        if (empty($params) || !isset($params['id'])){
            return null;
        }
        $id = $params['id'];
        
        if ($model = ArContactUsModel::find()->where(array('id' => $id))->one()){
            if ($model->display == 1 || ($model->display == 2 && !$this->isMobile()) || ($model->display == 3 && $this->isMobile())) {
                if (isset($params['title']) && !empty($params['title'])){
                    $model->title = $params['title'];
                }
                return $this->render('front/shortcodes/menuItem.php', array(
                    'model' => $model
                ));
            }
        }
        return null;
    }
    
    public function registerAjaxScript()
    {
        wp_localize_script('jquery.contactus.scripts', 'arcontactusAjax', 
            array(
                'url' => admin_url('admin-ajax.php'),
                'version' => AR_CONTACTUS_VERSION
            )
	);
    }

    public function renderContactUsButton()
    {
        $generalConfig = new ArContactUsConfigGeneral('arcug_');
        $generalConfig->loadFromConfig();
        if ($generalConfig->pages){
            $currentPage = $_SERVER['REQUEST_URI'];
            $excludePages = explode(PHP_EOL, $generalConfig->pages);
            foreach ($excludePages as $page){
                $p = str_replace(array("\n", "\r"), '', $page);
                if ($currentPage == $p){
                    return null;
                }
            }
        }
        if ($generalConfig->sandbox) {
            $ips = explode("\r\n", $generalConfig->allowed_ips);
            if (!in_array($generalConfig->getCurrentIP(), $ips)) {
                return null;
            }
        }
        if (!$generalConfig->mobile && $this->isMobile()){
            return null;
        }
        if ($this->isMobile()){
            $buttonConfig = new ArContactUsConfigMobileButton('arcumb_');
            $menuConfig = new ArContactUsConfigMobileMenu('arcumm_');
            $promptConfig = new ArContactUsConfigMobilePrompt('arcumpr_');
        }else{
            $buttonConfig = new ArContactUsConfigButton('arcub_');
            $menuConfig = new ArContactUsConfigMenu('arcum_');
            $promptConfig = new ArContactUsConfigPrompt('arcupr_');
        }
        
        $popupConfig = new ArContactUsConfigPopup('arcup_');
        $liveChatsConfig = new ArContactUsConfigLiveChat('arcul_');
        
        $buttonConfig->loadFromConfig();
        $menuConfig->loadFromConfig();
        $popupConfig->loadFromConfig();
        $promptConfig->loadFromConfig();
        $liveChatsConfig->loadFromConfig();
        $models = ArContactUsModel::find()->where(array('status' => 1))->orderBy('`position` ASC')->all();
        if ($popupConfig->recaptcha && $popupConfig->key){
            wp_register_script('arcontactus-google-recaptcha-v3', 'https://www.google.com/recaptcha/api.js?render=' . $popupConfig->key, array('jquery'), AR_CONTACTUS_VERSION);
            wp_enqueue_script('arcontactus-google-recaptcha-v3');
        }
        if ($popupConfig->phone_mask_on && $popupConfig->maskedinput) {
            // moved to template
            //wp_register_script('arcontactus-masked-input', AR_CONTACTUS_PLUGIN_URL . 'res/js/jquery.maskedinput.min.js', array('jquery'), AR_CONTACTUS_VERSION);
            //wp_enqueue_script('arcontactus-masked-input');
        }
        if ($buttonConfig->drag){
            wp_enqueue_script('jquery-ui-draggable');
        }
        $items = array();
        $tawkTo = false;
        $crisp = false;
        $intercom = false;
        $facebook = false;
        $vkChat = false;
        $skype = false;
        $zopim = false;
        $zalo = false;
        $lhc = false;
        $lc = false;
        $ss = false;
        foreach ($models as $model){
            if ($model->display == 1 || ($model->display == 2 && !$this->isMobile()) || ($model->display == 3 && $this->isMobile())) {
                $item = array(
                    'href' => $model->link,
                    'color' => '#' . $model->color,
                    'title' => $model->title,
                    'id' => 'msg-item-' . $model->id,
                    'class' => 'msg-item-' . $model->icon,
                    'type' => $model->type,
                    'integration' => $model->integration,
                    'target' => $model->target,
                    'js' => $model->js,
                    'icon' => ArContactUsConfigModel::getIcon($model->icon)
                );
                if ($model->type == ArContactUsModel::TYPE_INTEGRATION){
                    switch ($model->integration){
                        case 'tawkto':
                            $tawkTo = true;
                            break;
                        case 'crisp':
                            $crisp = true;
                            break;
                        case 'intercom':
                            $intercom = true;
                            break;
                        case 'facebook':
                            $facebook = true;
                            break;
                        case 'vk':
                            $vkChat = true;
                            break;
                        case 'zopim':
                            $zopim = true;
                            break;
                        case 'skype':
                            $skype = true;
                            break;
                        case 'zalo':
                            $zalo = true;
                        case 'lhc':
                            $lhc = true;
                            break;
                        case 'smartsupp':
                            $ss = true;
                            break;
                        case 'livechat':
                            $lc = true;
                            break;
                    }
                }
                $items[] = $item;
            }
        }
        echo self::render('front/button.php', array(
            'generalConfig' => $generalConfig,
            'buttonConfig' => $buttonConfig,
            'menuConfig' => $menuConfig,
            'popupConfig' => $popupConfig,
            'promptConfig' => $promptConfig,
            'liveChatsConfig' => $liveChatsConfig,
            'buttonIcon' => ArContactUsConfigModel::getIcon($buttonConfig->button_icon),
            'tawkTo' => $liveChatsConfig->isTawkToIntegrated() && $tawkTo,
            'crisp' => $liveChatsConfig->isCrispIntegrated() && $crisp,
            'intercom' => $liveChatsConfig->isIntercomIntegrated() && $intercom,
            'facebook' => $liveChatsConfig->isFacebookChatIntegrated() && $facebook,
            'vkChat' => $liveChatsConfig->isVkIntegrated() && $vkChat,
            'zopim' => $liveChatsConfig->isZopimIntegrated() && $zopim,
            'skype' => $liveChatsConfig->isSkypeIntegrated() && $skype,
            'zalo' => $liveChatsConfig->isZaloIntegrated() && $zalo,
            'lhc' => $liveChatsConfig->isLhcIntegrated() && $lhc,
            'lc' => $liveChatsConfig->isLiveChatIntegrated() && $lc,
            'ss' => $liveChatsConfig->isSmartsuppIntegrated() && $ss,
            'user' => wp_get_current_user(),
            'messages' => $promptConfig->enable_prompt? ArContactUsPromptModel::getMessages() : array(),
            'items' => $items,
            'isMobile' => $this->isMobile()
        ));
    }


    public function activate()
    {
        if (!get_option('arcu_installed')){
            ArContactUsModel::createTable();
            ArContactUsModel::createDefaultMenuItems();
            ArContactUsCallbackModel::createTable();
            ArContactUsPromptModel::createTable();
            ArContactUsPromptModel::createDefaultItems();
            
            $generalConfig = new ArContactUsConfigGeneral('arcug_');
            $buttonConfig = new ArContactUsConfigButton('arcub_');
            $mobileButtonConfig = new ArContactUsConfigMobileButton('arcumb_');
            $menuConfig = new ArContactUsConfigMenu('arcum_');
            $mobileMenuConfig = new ArContactUsConfigMobileMenu('arcumm_');
            $popupConfig = new ArContactUsConfigPopup('arcup_');
            $promptConfig = new ArContactUsConfigPrompt('arcupr_');
            $mobilePromptConfig = new ArContactUsConfigMobilePrompt('arcumpr_');
            $integrationConfig = new ArContactUsConfigLiveChat('arcul_');
            
            $generalConfig->loadDefaults();
            $generalConfig->saveToConfig();
            
            $buttonConfig->loadDefaults();
            $buttonConfig->saveToConfig();
            
            $mobileButtonConfig->loadDefaults();
            $mobileButtonConfig->saveToConfig();
            
            $menuConfig->loadDefaults();
            $menuConfig->saveToConfig();
            
            $mobileMenuConfig->loadDefaults();
            $mobileMenuConfig->saveToConfig();
            
            $popupConfig->loadDefaults();
            $popupConfig->saveToConfig();
            
            $promptConfig->loadDefaults();
            $promptConfig->saveToConfig();
            
            $mobilePromptConfig->loadDefaults();
            $mobilePromptConfig->saveToConfig();
            
            $integrationConfig->loadDefaults();
            $integrationConfig->saveToConfig(false);
            
            update_option('arcu_installed', time());
        }
        return true;
    }
}
