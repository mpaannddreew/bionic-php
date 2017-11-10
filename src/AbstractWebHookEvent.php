<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-02
 * Time: 12:15 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic;


use Andre\Bionic\Contracts\WebHookEventInterface;
use Andre\Bionic\Traits\IsADataWrapper;
use Andre\Bionic\Traits\SetsProperties;

abstract class AbstractWebHookEvent implements WebHookEventInterface
{
    use IsADataWrapper, SetsProperties;

    /**
     * AbstractWebHookEvent constructor.
     * @param $data
     */
    public function __construct($data)
    {
        $this->data = $data;
        $this->setProperties();
    }

    /**
     * get webhook event data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * create a new class instance
     *
     * @param array $data
     * @return static
     */
    public static function create($data = [])
    {
        return new static($data);
    }
}