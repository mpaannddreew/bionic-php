<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Viber\Messages;


class Location extends ViberMessage
{
    /**
     * @var string $lat
     */
    protected $lat;

    /**
     * @var string $lon
     */
    protected $lon;

    /**
     * @return string
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @return string
     */
    public function getLon()
    {
        return $this->lon;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::LOCATION;
    }
}