<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 10:43 PM
 */

namespace Andre\Bionic\Plugins\Messenger\BotProfile;


use Andre\Bionic\AbstractMessage;

class PersistentMenu extends AbstractMessage
{
    /**
     * @var string $locale
     */
    protected $locale;

    /**
     * @var bool $composer_input_disabled
     */
    protected $composer_input_disabled = false;

    /**
     * @var array $call_to_actions
     */
    protected $call_to_actions = [];

    /**
     * @return array
     */
    public function getCallToActions()
    {
        return $this->call_to_actions;
    }

    /**
     * @param array $call_to_actions
     * @return $this
     */
    public function setCallToActions($call_to_actions)
    {
        $this->call_to_actions = $call_to_actions;
        $this->data['call_to_actions'] = $this->getCallToActions();
        return $this;
    }

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
     * @return bool
     */
    public function isComposerInputDisabled()
    {
        return $this->composer_input_disabled;
    }

    /**
     * @param bool $composer_input_disabled
     * @return $this
     */
    public function setComposerInputDisabled($composer_input_disabled)
    {
        $this->composer_input_disabled = $composer_input_disabled;
        $this->data['composer_input_disabled'] = $this->isComposerInputDisabled();
        return $this;
    }


}