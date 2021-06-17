<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 17/06/2021
 * Time: 12:12
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Message;


use Andre\Bionic\Plugins\Messenger\Messages\Payload\Payload;

abstract class AbstractReaction extends AbstractSenderAction
{
    /**
     * @var array
     */
    protected $payload = [];

    /**
     * set payload
     *
     * @param Payload $payload
     * @return $this
     */
    public function setPayload(Payload $payload)
    {
        $this->payload = $payload->toArray();
        $this->data['payload'] = $this->payload;
        return $this;
    }
}