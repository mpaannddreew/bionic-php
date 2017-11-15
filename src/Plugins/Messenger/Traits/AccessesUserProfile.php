<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-06
 * Time: 1:46 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Traits;


use Andre\Bionic\Plugins\Messenger\Messages\EndPoint\AbstractEndPoint;
use Andre\Bionic\Plugins\Messenger\UserProfile;

trait AccessesUserProfile
{
    /**
     * @var string $profile_access_url
     */
    protected $profile_access_url = "https://graph.facebook.com/%s/%s?fields=first_name,last_name,profile_pic&access_token=%s";

    /**
     * get user profile from facebook
     *
     * @param AbstractEndPoint $user
     * @return UserProfile|null
     */
    public function getUserProfile(AbstractEndPoint $user)
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $this->profile_access_url = sprintf($this->profile_access_url, $this->graph_api_version, $user->getId(), $this->page_access_token);

        try{
            $response = $this->httpClient->get($this->profile_access_url)->getBody()->getContents();
            return UserProfile::create((array)json_decode($response));
        }catch (\Exception $exception){
            return null;
        }
    }
}