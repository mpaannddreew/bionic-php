<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 16/06/2021
 * Time: 23:31
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

class Story extends AbstractMessage
{
    /**
     * @var string $url
     */
    protected $url;

    /**
     * @var string $id
     */
    protected $id;

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}