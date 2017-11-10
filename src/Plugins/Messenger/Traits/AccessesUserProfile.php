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
    protected $profile_access_url = "https://graph.facebook.com/v2.10/{PSID}?fields=first_name,last_name,profile_pic&access_token={PAGE_ACCESS_TOKEN}";

    /**
     * get user profile from facebook
     *
     * @param AbstractEndPoint $user
     * @return UserProfile|null
     */
    public function getUserProfile(AbstractEndPoint $user)
    {
        $this->checkForPageAccessToken();

        $this->profile_access_url = str_replace('{PAGE_ACCESS_TOKEN}', $this->page_access_token, str_replace('{PSID}', $user->getId(), $this->profile_access_url));

        try{
            $response = $this->httpClient->get($this->profile_access_url)->getBody()->getContents();
            return UserProfile::create((array)json_decode($response));
        }catch (\Exception $exception){
            return null;
        }
    }
}