<?php

class Qwerly_API_Response
{

    const PROFILE = 'profile';
    const LOCATION = 'location';
    const NAME = 'name';
    const TWITTER_USERNAME = 'twitter_username';
    const WEBSITE = 'website';
    const QWERLY = 'qwerly_username';
    const SERVICES = 'services';

    private $_data;

    /**
     * Creates a new qwerly response.
     *
     * @param array $data The response data.
     */
    public function __construct(array $data)
    {
        $this->_data = $data;
    }

    /**
     * Retrieves the user's description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->_data[self::PROFILE][self::DESCRIPTION];
    }

    /**
     * Retrieves the user's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_data[self::PROFILE][self::NAME];
    }


    /**
     * Retrieves the user's location.
     *
     * @return string
     */
    public function getLocation()
    {
        return $this->_data[self::PROFILE][self::LOCATION];
    }

    /**
     * Retrieves the user's twitter username.
     *
     * @return string
     */
    public function getTwitter()
    {
        return $this->_data[self::PROFILE][self::TWITTER_USERNAME];
    }

    /**
     * Retrievs the user's website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->_data[self::PROFILE][self::WEBSITE];
    }

    /**
     * Retrieves the user's services.
     *
     * @return array
     */
    public function getServices()
    {
        return $this->_data[self::PROFILE][self::SERVICES];
    }

    /**
     * Retrieves the user's qwerly username.
     *
     * @return string
     */
    public function getQwerly()
    {
        return $this->_data[self::PROFILE][self::QWERLY];
    }

}
