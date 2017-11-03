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
use Andre\Bionic\Plugins\AbstractBionicPlugin;

interface BionicInterface
{
    public function setPlugin(AbstractBionicPlugin $plugin);

    public function receive($data);

    public function execute();
}