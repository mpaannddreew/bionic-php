<?php
/**
 * Created by PhpStorm.
 * User: andre
 * Date: 2017-11-03
 * Time: 11:53 AM
 *
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\Messenger\Messages;


use Andre\Bionic\Plugins\Messenger\Messages\Payment\CheckoutUpdate;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\Payment;
use Andre\Bionic\Plugins\Messenger\Messages\Payment\PreCheckout;

class MessagingItem extends AbstractChannelItem
{
    /**
     * @var array $postback
     */
    protected $postback = [];

    /**
     * @var array $referral
     */
    protected $referral = [];

    /**
     * @var array $optin
     */
    protected $optin = [];

    /**
     * @var array $account_linking
     */
    protected $account_linking = [];

    /**
     * @var array $policy_enforcement
     */
    protected $policy_enforcement = [];

    /**
     * @var array $payment
     */
    protected $payment = [];

    /**
     * @var array $checkout_update
     */
    protected $checkout_update = [];

    /**
     * @var array $pre_checkout
     */
    protected $pre_checkout = [];

    /**
     * @var array $pass_thread_control
     */
    protected $pass_thread_control = [];

    /**
     * @var array $take_thread_control
     */
    protected $take_thread_control = [];

    /**
     * MessagingItem constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        parent::__construct($data);
        if (array_key_exists('policy-enforcement', $this->data))
            $this->policy_enforcement = $this->data['policy-enforcement'];
    }

    /**
     * get postback
     *
     * @return PostBack|null
     */
    public function getPostback()
    {
        if ($this->postback)
            return PostBack::create($this->postback);

        return null;
    }

    /**
     * get referral
     *
     * @return Referral|null
     */
    public function getReferral()
    {
        if ($this->referral)
            return Referral::create($this->referral);

        return null;
    }

    /**
     * get optin
     *
     * @return Optin|null
     */
    public function getOptin()
    {
        if ($this->optin)
            return Optin::create($this->optin);

        return null;
    }

    /**
     * get account linking
     *
     * @return AccountLinking|null
     */
    public function getAccountLinking()
    {
        if ($this->account_linking)
            return AccountLinking::create($this->account_linking);

        return null;
    }

    /**
     * get policy enforcement
     *
     * @return PolicyEnforcement|null
     */
    public function getPolicyEnforcement()
    {
        if ($this->policy_enforcement)
            return PolicyEnforcement::create($this->policy_enforcement);

        return null;
    }

    /**
     * get payment
     *
     * @return Payment|null
     */
    public function getPayment()
    {
        if ($this->payment)
            return Payment::create($this->payment);

        return null;
    }

    /**
     * get checkout update
     *
     * @return CheckoutUpdate|null
     */
    public function getCheckoutUpdate()
    {
        if ($this->checkout_update)
            return CheckoutUpdate::create($this->checkout_update);

        return null;
    }

    /**
     * get pre checkout
     *
     * @return PreCheckout|null
     */
    public function getPreCheckout()
    {
        if ($this->pre_checkout)
            return PreCheckout::create($this->pre_checkout);

        return null;
    }

    /**
     * get pass thread control
     *
     * @return PassThreadControl|null
     */
    public function getPassThreadControl()
    {
        if ($this->pass_thread_control)
            return PassThreadControl::create($this->pass_thread_control);

        return null;
    }

    /**
     * get take thread control
     *
     * @return TakeThreadControl|null
     */
    public function getTakeThreadControl()
    {
        if ($this->take_thread_control)
            return TakeThreadControl::create($this->take_thread_control);

        return null;
    }
}