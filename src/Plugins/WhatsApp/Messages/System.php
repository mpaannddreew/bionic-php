<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 10:12 PM
 */

namespace Andre\Bionic\Plugins\WhatsApp\Messages;


use Andre\Bionic\AbstractMessage;

class System extends AbstractMessage
{
    protected $body;

    protected $group_id;

    protected $operator;

    protected $type;

    protected $users = [];

    /**
     * @return mixed
     */
    public function getBody()
    {
        return $this->body;
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
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return array
     */
    public function getUsers()
    {
        return $this->users;
    }
}