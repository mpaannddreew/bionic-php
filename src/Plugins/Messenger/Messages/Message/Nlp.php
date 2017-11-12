<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 9:38 PM
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

class Nlp extends AbstractMessage
{
    /**
     * @var array $entities
     */
    protected $entities = [];

    /**
     * @return array
     */
    public function getEntities()
    {
        return $this->entities;
    }
}