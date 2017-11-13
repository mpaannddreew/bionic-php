<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 10:03 AM
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

trait PassesThreadControl
{
    /**
     * @var string $messenger_profile_url
     */
    protected $pass_thread_control_url = "https://graph.facebook.com/{GRAPH_API_VERSION}/me/pass_thread_control?access_token={PAGE_ACCESS_TOKEN}";

    /**
     * @param AbstractEndPoint $recipient
     * @param $target_app_id
     * @param string $metadata
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function passThreadControl(AbstractEndPoint $recipient, $target_app_id, $metadata = "")
    {
        $this->checkForPageAccessTokenAndGraphApiVersion();

        $data = [
            'recipient' => $recipient->toArray(),
            'target_app_id' => $target_app_id
        ];

        if ($metadata)
            $data['metadata'] = $metadata;

        $this->pass_thread_control_url = str_replace('{GRAPH_API_VERSION}', $this->graph_api_version, str_replace('{PAGE_ACCESS_TOKEN}', $this->page_access_token, $this->pass_thread_control_url));

        return $this->httpClient->post($this->pass_thread_control_url, ['json' => $data]);
    }
}