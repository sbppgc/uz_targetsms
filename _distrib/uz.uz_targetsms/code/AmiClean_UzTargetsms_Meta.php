<?php
/**
 * AmiClean/UzTargetsms configuration.
 *
 * @copyright Ugol Zreniya. All rights reserved.
 * @category  Module
 * @package   Config_AmiClean_UzTargetsms
 */

/**
 * AmiClean/UzTargetsms configuration metadata.
 *
 * @package    Config_AmiClean_UzTargetsms
 * @subpackage Meta
 */
class AmiClean_UzTargetsms_Meta extends AMI_HyperConfig_Meta{
    /**
     * Version
     *
     * @var string
     */
    protected $version = '1.0';

    /**
     * Only one instance per config allowed
     *
     * @var bool
     */
    protected $isSingleInstance = TRUE;

    /**
     * Array having locales as keys and captions as values
     *
     * @var array
     */
    protected $aTitle = array(
        'en' => 'TargetSMS',
        'ru' => 'TargetSMS'
    );

    /**
     * Array having locales as keys and meta data as values
     *
     * @var array
     */
    protected $aInfo = array(
        'en' => array(
            'description' => 'TargetSMS',
            'author'      => '<a href="http://www.ugolzreniya.ru" target="_blank">Ugol Zreniya</a>'
        ),
        'ru' => array(
            'description' => 'Отправка СМС с помодью сервиса TargetSMS',
            'author'      => '<a href="http://www.ugolzreniya.ru" target="_blank">Угол зрения</a>'
        )
    );

    /**
     * Array containing captions struct
     *
     * @var array
     */
    protected $aCaptions = array(
        '' => array(
            'header' => array(
                'obligatory' => TRUE,
                'type' => self::CAPTION_TYPE_STRING,
                'locales' => array(
                    'en' => array(
                        'name' => 'Header',
                        'caption' => 'TargetSMS',
                    ),
                    'ru' => array(
                        'name' => 'Заголовок',
                        'caption' => 'TargetSMS',
                    ),
                ),
            ),
            'menu' => array(
                'obligatory' => TRUE,
                'type' => self::CAPTION_TYPE_STRING,
                'locales' => array(
                    'en' => array(
                        'name' => 'Menu caption',
                        'caption' => 'TargetSMS',
                    ),
                    'ru' => array(
                        'name' => 'Заголовок для меню',
                        'caption' => 'TargetSMS',
                    ),
                ),
            ),
            'description' => array(
                'obligatory' => FALSE,
                'type' => self::CAPTION_TYPE_TEXT,
                'locales' => array(
                    'en' => array(
                        'name' => 'Admin interface start page module description',
                        'caption' => 'TargetSMS',
                    ),
                    'ru' => array(
                        'name' => 'Описание модуля для стартовой страницы интерфейса администратора',
                        'caption' => 'Отправка СМС с помодью сервиса TargetSMS.',
                    ),
                ),
            ),

            'specblock' => array(
                'obligatory' => TRUE,
                'type' => self::CAPTION_TYPE_STRING,
                'locales' => array(
                    'en' => array(
                        'name' => 'Specblock caption for Site Manager',
                        'caption' => 'TargetSMS',
                    ),
                    'ru' => array(
                        'name' => 'Название спецблока для менеджера сайта',
                        'caption' => 'TargetSMS',
                    ),
                ),
            ),
        ),
    );
}
