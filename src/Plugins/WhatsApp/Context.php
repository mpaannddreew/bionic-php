<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 10:18 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp;


use Andre\Bionic\AbstractMessage;

class Context extends AbstractMessage
{
    protected $from;

    protected $group_id;

    protected $id;

    protected $mentions = [];

    /**
     * @return mixed
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @return mixed
     */
    public function getGroupId()
    {
        return $this->group_id;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public function getMentions()
    {
        return $this->mentions;
    }
}