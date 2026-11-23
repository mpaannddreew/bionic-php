<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Telegram\Messages;

use Andre\Bionic\AbstractMessage;

class Location extends AbstractMessage
{
    /**
     * @var float $longitude
     */
    protected $longitude;

    /**
     * @var float $latitude
     */
    protected $latitude;

    /**
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
    }
}
