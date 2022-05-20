<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/05/2022
 * Time: 15:10
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