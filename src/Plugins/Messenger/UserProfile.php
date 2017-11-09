<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 1:54 PM
 */

namespace Andre\Bionic\Plugins\Messenger;


use Andre\Bionic\AbstractMessage;

class UserProfile extends AbstractMessage
{
    /**
     * @var string $id
     */
    protected $id;

    /**
     * @var string $first_name
     */
    protected $first_name;

    /**
     * @var string $last_name
     */
    protected $last_name;

    /**
     * @var string $profile_pic
     */
    protected $profile_pic;

    /**
     * get user id
     *
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * get first name
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * get last_name
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * get profile pic
     *
     * @return string
     */
    public function getProfilePic()
    {
        return $this->profile_pic;
    }
}