<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:42 PM
 */

namespace Andre\Bionic\Contracts;


interface BionicInterface
{
    public function receive(WebHookEventInterface $event);

    public function execute();

    public function send(MessageInterface $message);
}