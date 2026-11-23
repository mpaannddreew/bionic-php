<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;

use Andre\Bionic\AbstractMessage;
use Andre\Bionic\Plugins\WhatsApp\WhatsAppValue;

class Change extends AbstractMessage
{
    /**
     * @var array $value
     */
    protected $value = [];

    /**
     * @var string $field
     */
    protected $field;

    /**
     * @return WhatsAppValue
     */
    public function getValue()
    {
        return WhatsAppValue::create($this->value);
    }

    /**
     * @return string
     */
    public function getField()
    {
        return $this->field;
    }
}
