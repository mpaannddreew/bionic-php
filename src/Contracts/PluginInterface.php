<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-01
 * Time: 10:27 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Contracts;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\AbstractBionic;

interface PluginInterface
{
    /**
     * emit events
     *
     * @param AbstractBionic $bionic
     */
    public function emitEvents(AbstractBionic $bionic);

    /**
     * return a class instance
     *
     * @param array $config
     * @return static
     */
    public static function create($config = []);
}
