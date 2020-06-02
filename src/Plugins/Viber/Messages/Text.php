<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 9:52 PM
 */

namespace Andre\Bionic\Plugins\Viber\Messages;



class Text extends ViberMessage
{
    /**
     * @var string $text
     */
    protected $text;

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * set message type
     * @return void
     */
    protected function setType()
    {
        $this->type = self::TEXT;
    }
}