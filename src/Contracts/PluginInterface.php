<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:27 PM
 */

namespace Andre\Bionic\Contracts;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\AbstractBionic;

interface PluginInterface
{
    public function emitEvents(AbstractBionic $client);

    public function send(AbstractMessage $message);
}
