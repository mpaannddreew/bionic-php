<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 6:11 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

abstract class AbstractThreadControl extends AbstractMessage
{
    /**
     * @var string $metadata
     */
    protected $metadata;

    /**
     * get metadata
     *
     * @return string
     */
    public function getMetadata()
    {
        return $this->metadata;
    }
}