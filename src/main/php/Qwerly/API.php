<?php

class Qwerly_API
{

    const TWITTER       = 'twitter';
    const FACEBOOK_ID   = 'facebookId';
    const FACEBOOK_USERNAME = 'facebookName';
    const QWERLY        = 'qwerly';
    const TRY_AGAIN_LATER_CODE = 202;
    const NOT_FOUND_CODE = 404;

    private static $URLS = array(
        self::TWITTER        => '/twitter/%s',
        self::FACEBOOK_ID    => '/facebook/%d',
        self::FACEBOOK_USERNAME  => '/facebook/username/%s',
        self::QWERLY         => '/users/%s'
    );

    const BASE_URL = 'http://api.qwerly.com/v1';
    const API_KEY = '?api_key=%s';

    private $_apiKey;

    /**
     * @var Zend_Http_Client
     */
    private $_client;


    /**
     * Creates a new API instance.
     *
     * @param string $apiKey The qwerly API key to use.
     * @param Zend_Http_Client $client OPTIONAL. Http client to use.
     *                                 Meant for testing.
     */
    public function __construct($apiKey, Zend_Http_Client $client = null)
    {

        $this->_apiKey = $apiKey;
        $this->_client = $client ? $client : new Zend_Http_Client();
    }

    /**
     * Looks up an user by twitter username.
     *
     * @param string $username The twitter username to look.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByTwitterUsername($username)
    {
        return $this->_lookUpBy(self::TWITTER, $username);
    }

    /**
     * Looks up an user by facebook user id.
     *
     * @param int $id The user's facebook id.'
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByFacebookId($id)
    {
        return $this->_lookUpBy(self::FACEBOOK_ID, $id);
    }

    /**
     * Looks up an user by facebook name.
     *
     * @param string $name The user's facebook name.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByFacebookUsername($name)
    {
        return $this->_lookUpBy(self::FACEBOOK_USERNAME, $name);
    }

    /**
     * Looks up an user by qwerly name.
     *
     * @param string $name The user's qwerly name.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByQwerlyName($name)
    {
        return $this->_lookUpBy(self::QWERLY, $name);
    }

    /**
     * Looks up an user using the given service data.
     *
     * @param string $service Service to look up with.
     * @param mixed $data Data relevant to the service.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    private function _lookUpBy($service, $data)
    {
        $urlFormat = self::$URLS[$service];

        $url = self::BASE_URL
            . sprintf($urlFormat, urlencode($data))
            . sprintf(self::API_KEY, $this->_apiKey);

        $this->_client->setUri($url);

        $request = $this->_client->request();
        $data = Zend_Json::decode($request->getBody());

        if ($request->getStatus() != 200) {
            throw new Qwerly_API_ErrorException(
                $data['message'], $data['status']
            );
        }

        return new Qwerly_API_Response($data);
    }

}
