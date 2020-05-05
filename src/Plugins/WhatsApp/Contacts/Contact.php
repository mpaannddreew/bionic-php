<?php
/**
 * Created by PhpStorm.
 * User: mpande
 * Date: 5/3/20
 * Time: 8:36 PM
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
}