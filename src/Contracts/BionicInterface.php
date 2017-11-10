<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:42 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Contracts;


use Andre\Bionic\Plugins\AbstractBionicPlugin;

interface BionicInterface
{
    /**
     * return a class instance
     *
     * @return static
     */
    public static function initialize();

    /**
     * set plugin to used by the bionic instance
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
     * execute bionic instance
     */
    public function execute();
}