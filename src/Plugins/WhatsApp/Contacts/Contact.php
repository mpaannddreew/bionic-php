<?php

/*
 * This file is part of Bionic.
 *
 * (c) Mpande Andrew <andrewmvp007@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Andre\Bionic\Plugins\WhatsApp\Contacts;

use Andre\Bionic\AbstractMessage;

class Contact extends AbstractMessage
{
    protected $profile = [];

    protected $wa_id;

    protected $addresses = [];

    protected $birthday;

    protected $contact_image;

    protected $emails = [];

    protected $ims = [];

    protected $name = [];

    protected $org = [];

    protected $phones = [];

    protected $urls = [];

    /**
     * @var string
     */
    protected $user_id;

    /**
     * @return Profile
     */
    public function getProfile()
    {
        return Profile::create($this->profile);
    }

    /**
     * @return mixed
     */
    public function getWaId()
    {
        return $this->wa_id;
    }

    /**
     * @return array
     */
    public function getAddresses()
    {
        return $this->addresses;
    }

    /**
     * @return mixed
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * @return mixed
     */
    public function getContactImage()
    {
        return $this->contact_image;
    }

    /**
     * @return array
     */
    public function getEmails()
    {
        return $this->emails;
    }

    /**
     * @return array
     */
    public function getIms()
    {
        return $this->ims;
    }

    /**
     * @return array
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getOrg()
    {
        return $this->org;
    }

    /**
     * @return array
     */
    public function getPhones()
    {
        return $this->phones;
    }

    /**
     * @return array
     */
    public function getUrls()
    {
        return $this->urls;
    }

    /**
     * The user's business-scoped user ID (BSUID)
     *
     * @return string|null
     */
    public function getUserId()
    {
        return $this->user_id;
    }
}
