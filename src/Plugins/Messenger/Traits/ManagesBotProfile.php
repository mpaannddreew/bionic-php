<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 2:35 PM
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


trait ManagesBotProfile
{
    /**
     * @var string $messenger_profile_url
     */
    protected $messenger_profile_url = "https://graph.facebook.com/v2.6/me/messenger_profile?access_token=";


}