<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;

use Andre\Bionic\AbstractMessage;

/**
 * A template message, sent with WhatsAppPlugin::sendMessage('template', $template, $to).
 *
 * The data is the "template" object of the Cloud API request:
 * ['name' => ..., 'language' => ['code' => ...], 'components' => [...]].
 */
class Template extends AbstractMessage
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $language = [];

    /**
     * @var array
     */
    protected $components = [];

    /**
     * Build a template message from its name, language code and components
     *
     * @param string $name approved template name
     * @param string $language_code e.g. "en_US"
     * @param array $components header/body/button components with their parameters
     * @return static
     */
    public static function named($name, $language_code, array $components = [])
    {
        $data = ['name' => $name, 'language' => ['code' => $language_code]];

        if ($components) {
            $data['components'] = $components;
        }

        return static::create($data);
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getLanguage()
    {
        return $this->language;
    }

    /**
     * @return array
     */
    public function getComponents()
    {
        return $this->components;
    }
}
