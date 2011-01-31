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
    const DESCRIPTION = 'description';
    const FACEBOOK_ID = 'facebook_id';

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
        return isset($this->_data[self::PROFILE][self::DESCRIPTION]) ?
                    $this->_data[self::PROFILE][self::DESCRIPTION] : null;
    }

    /**
     * Retrieves the user's name.
     *
     * @return string
     */
    public function getName()
    {
        return isset($this->_data[self::PROFILE][self::NAME]) ?
                    $this->_data[self::PROFILE][self::NAME] : null;
    }


    /**
     * Retrieves the user's location.
     *
     * @return string
     */
    public function getLocation()
    {
        return isset($this->_data[self::PROFILE][self::LOCATION]) ?
                    $this->_data[self::PROFILE][self::LOCATION] : null;
    }

    /**
     * Retrieves the user's twitter username.
     *
     * @return string
     */
    public function getTwitter()
    {
        return isset($this->_data[self::PROFILE][self::TWITTER_USERNAME]) ?
                    $this->_data[self::PROFILE][self::TWITTER_USERNAME] : null;
    }

    /**
     * Retrievs the user's website.
     *
     * @return string
     */
    public function getWebsite()
    {
        return isset($this->_data[self::PROFILE][self::WEBSITE]) ?
                    $this->_data[self::PROFILE][self::WEBSITE] : null;
    }

    /**
     * Retrieves the user's services.
     *
     * @return array
     */
    public function getServices()
    {
        return isset($this->_data[self::PROFILE][self::SERVICES]) ?
                    $this->_data[self::PROFILE][self::SERVICES] : null;
    }

    /**
     * Retrieves the user's qwerly username.
     *
     * @return string
     */
    public function getQwerly()
    {
        return isset($this->_data[self::PROFILE][self::QWERLY]) ?
                    $this->_data[self::PROFILE][self::QWERLY] : null;
    }

    /**
     * Retrieves the user's facebook id.
     *
     * @return int
     */
    public function getFacebook()
    {
        return isset($this->_data[self::PROFILE][self::FACEBOOK_ID]) ?
                    $this->_data[self::PROFILE][self::FACEBOOK_ID] : null;
    }

}
