<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:27 PM
 */

namespace Andre\Bionic\Contracts;


use Evenement\EventEmitterInterface;

interface PluginInterface
{
    public function attachEvents(EventEmitterInterface $emitter);

    public function send(MessageInterface $message);
}
