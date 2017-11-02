<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:42 PM
 */

namespace Andre\Bionic\Contracts;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\AbstractWebHookEvent;

interface BionicInterface
{
    public function receive(AbstractWebHookEvent $event);

    public function execute();

    public function send(AbstractMessage $message);
}