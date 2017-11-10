<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-05
 * Time: 5:33 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payload;


use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\Messenger\Messages\Message\Coordinates;

class LocationPayLoad extends AbstractMessage
{
    /**
     * @var array $coordinates
     */
    protected $coordinates = [];

    /**
     * get coordinates
     *
     * @return Coordinates|null
     */
    public function getCoordinates()
    {
        if ($this->coordinates)
            return Coordinates::create($this->coordinates);

        return null;
    }
}