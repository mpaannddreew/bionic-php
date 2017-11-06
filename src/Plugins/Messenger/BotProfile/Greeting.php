<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 4:24 PM
 */

namespace Andre\Bionic\Plugins\Messenger\BotProfile;


use Andre\Bionic\AbstractMessage;

class Greeting extends AbstractMessage
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
     * @return string
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
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
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
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