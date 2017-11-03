<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 6:53 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class Referral extends AbstractMessage
{
    /**
     * @var string $ref
     */
    protected $ref;

    /**
     * @var string $source
     */
    protected $source;

    /**
     * @var string $type
     */
    protected $type;

    /**
     * @return string
     */
    public function getRef()
    {
        return $this->ref;
    }

    /**
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }
}