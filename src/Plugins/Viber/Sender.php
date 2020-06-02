<?php
/**
 * Created by PhpStorm.
 * User: mpaannddreew
 * Date: 6/1/20
 * Time: 9:28 PM
 */

namespace Andre\Bionic\Plugins\Viber;


use Andre\Bionic\AbstractMessage;

class Sender extends AbstractMessage
{
    /**
     * @var string $name
     */
    protected $name;

    /**
     * @var string $avatar
     */
    protected $avatar;
}