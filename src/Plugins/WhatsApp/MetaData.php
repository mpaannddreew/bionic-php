<?php
/**
 * Created by PhpStorm.
 * User: hp
 * Date: 20/05/2022
 * Time: 15:18
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractMessage;

class MetaData extends AbstractMessage
{
    /**
     * @var string $display_phone_number
     */
    protected $display_phone_number;

    /**
     * @var string $phone_number_id
     */
    protected $phone_number_id;

    /**
     * @return string
     */
    public function getDisplayPhoneNumber()
    {
        return $this->display_phone_number;
    }

    /**
     * @return string
     */
    public function getPhoneNumberId()
    {
        return $this->phone_number_id;
    }
}