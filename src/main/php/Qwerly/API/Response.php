<?php
/**
 * Qwerly API
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/canddi/Zend_Qwerly/blob/master/LICENSE.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to hello@canddi.com so we can send you a copy immediately.
 *
 */

/**
 * Qwerly's response object.
 */
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
