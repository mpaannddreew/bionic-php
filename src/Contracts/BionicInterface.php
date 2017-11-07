<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:42 PM
 */

namespace Andre\Bionic\Contracts;


use Andre\Bionic\Plugins\AbstractBionicPlugin;

interface BionicInterface
{
    /**
     * set plugin
     *
     * @param AbstractBionicPlugin $plugin
     */
    public function setPlugin(AbstractBionicPlugin $plugin);

    /**
     * receive web hook data
     *
     * @param $data
     */
    public function receive($data);

    /**
     * register an event listener
     *
     * @param $event
     * @param $listener
     */
    public function listen($event, $listener);

    /**
     * execute client
     */
    public function execute();
}