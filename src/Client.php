<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 9:45 PM
 */

namespace Andre\Bionic;


class Client extends AbstractBionicClient
{
    /**
     * execute client
     */
    public function execute(){
        if ($this->isExecuted())
            return;

        $this->hasExecuted();
        $this->plugin->emitEvents($this);
    }

    /**
     * send message
     *
     * @param AbstractMessage $message
     */
    public function send(AbstractMessage $message)
    {
        $this->message = $message;
        $this->plugin->send($this->message);
    }
}