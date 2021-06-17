<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 16/06/2021
 * Time: 23:09
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\AbstractMessage;

class Product extends AbstractMessage
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * get id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}