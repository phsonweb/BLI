<?php
ArContactUsLoader::loadModel('ArContactUsConfigButtonAbstract');

class ArContactUsConfigMobileButton extends ArContactUsConfigButtonAbstract
{
    public function attributeDefaults()
    {
        return array(
            'mode' => 'regular',
            'button_icon' => 'hangouts',
            'button_size' => 'small',
            'button_color' => '008749',
            'position' => 'right',
            'x_offset' => '10',
            'y_offset' => '10',
            'pulsate_speed' => 2000,
            'icon_speed' => 600,
            'icon_animation_pause' => 2000,
            'text' => '',
            'drag' => 0,
        );
    }
}