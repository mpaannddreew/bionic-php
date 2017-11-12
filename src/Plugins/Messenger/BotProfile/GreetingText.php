<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 4:24 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\BotProfile;


use Andre\Bionic\AbstractMessage;

class GreetingText extends AbstractMessage
{
    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var string $text
     */
    protected $text;

    /**
     * get locale
     *
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * set locale
     *
     * @param string $locale
     * @return $this
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        $this->data['locale'] = $this->getLocale();
        return $this;
    }

    /**
     * get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set text
     *
     * @param string $text
     * @return $this
     */
    public function setText($text)
    {
        $this->text = $text;
        $this->data['locale'] = $this->getLocale();
        return $this;
    }
}