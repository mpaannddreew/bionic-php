<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-12
 * Time: 10:37 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\AbstractMessage;

class AppRoles extends AbstractMessage
{
    /**
     * @var string $app_id
     */
    protected $app_id;

    /**
     * @var array $app_roles
     */
    protected $app_roles = [];

    /**
     * AppRoles constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);

        if (count($this->data) == 1){
            try{
                $this->app_id = array_keys($this->data)[0];
                $this->app_roles = array_values($this->data)[0];
            }catch (\Exception $exception){}
        }
    }

    /**
     * get app id
     *
     * @return string
     */
    public function getAppId()
    {
        return $this->app_id;
    }

    /**
     * get app roles
     *
     * @return array
     */
    public function getAppRoles()
    {
        return $this->app_roles;
    }
}