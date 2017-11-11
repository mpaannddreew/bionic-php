<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-11
 * Time: 3:04 PM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages\Payment;


use Andre\Bionic\AbstractMessage;

class Shipping extends AbstractMessage
{
    /**
     * @var string $option_id
     */
    protected $option_id;

    /**
     * @var string $option_title
     */
    protected $option_title;

    /**
     * @var array $price_list
     */
    protected $price_list = [];

    /**
     * get option id
     *
     * @return string
     */
    public function getOptionId()
    {
        return $this->option_id;
    }

    /**
     * set option id
     *
     * @param string $option_id
     * @return $this
     */
    public function setOptionId($option_id)
    {
        $this->option_id = $option_id;
        $this->data['option_id'] = $this->getOptionId();
        return $this;
    }

    /**
     * get option title
     *
     * @return string
     */
    public function getOptionTitle()
    {
        return $this->option_title;
    }

    /**
     * set option title
     *
     * @param string $option_title
     * @return $this
     */
    public function setOptionTitle($option_title)
    {
        $this->option_title = $option_title;
        $this->data['option_title'] = $this->getOptionTitle();
        return $this;
    }

    /**
     * get price list
     *
     * @return array
     */
    public function getPriceList()
    {
        return $this->price_list;
    }

    /**
     * set price list
     *
     * @param array $price_list
     * @return $this
     */
    public function setPriceList($price_list = [])
    {
        $this->price_list = $price_list;
        $this->data['price_list'] = $this->getPriceList();
        return $this;
    }
}