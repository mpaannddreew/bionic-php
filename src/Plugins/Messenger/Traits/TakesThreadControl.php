<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 10:14 AM
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

trait TakesThreadControl
{
    /**
     * @var string $messenger_profile_url
     */
    protected $take_thread_control_url = "https://graph.facebook.com/%s/me/take_thread_control?access_token=%s";

    /**
     * @param AbstractEndPoint $recipient
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function takeThreadControl(AbstractEndPoint $recipient, $metadata = "")
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray()
        ];

        if ($metadata)
            $data['metadata'] = $metadata;

        $this->take_thread_control_url = sprintf($this->take_thread_control_url, $this->graph_api_version, $this->page_access_token);

        return $this->httpClient->post($this->take_thread_control_url, ['json' => $data]);
    }
}