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
 * Qwerly API implementation.
 */
class Qwerly_API
{

    const TWITTER              = 'twitter';
    const FACEBOOK_ID          = 'facebookId';
    const FACEBOOK_USERNAME    = 'facebookName';
    const QWERLY               = 'qwerly';
    const EMAIL                = 'email';
    
    const TRY_AGAIN_LATER_CODE = 202;
    const NOT_FOUND_CODE       = 404;

    private static $URLS = array(
        self::TWITTER           => '/twitter/%s',
        self::FACEBOOK_ID       => '/facebook/%d',
        self::FACEBOOK_USERNAME => '/facebook/username/%s',
        self::QWERLY            => '/users/%s',
        self::EMAIL             => '/email/%s'
    );

    const BASE_URL = 'http://api.qwerly.com/v1';
    const API_KEY  = '?api_key=%s';

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

        if (empty($apiKey)) {
            throw new Qwerly_API_ErrorException('The API key can\'t be null');
        }

        $this->_apiKey = $apiKey;
        $this->_client = $client ? $client : new Zend_Http_Client();
    }

    /**
     * Looks up an user by twitter username.
     *
     * @param string|array $username The twitter username or list of usernames to look.
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
     * @param int|array $id The user's facebook id or list of ids to look
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
     * @param string $name|arrat The user's facebook name or list of names to look.
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
     * @param string|array $name The user's qwerly name or list of names to look.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByQwerlyName($name)
    {
        return $this->_lookUpBy(self::QWERLY, $name);
    }

    /**
     * Looks up an user by e-mail address.
     * 
     * @param string|array $email The user's e-mail address or list of e-mail addresses to look.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_NotFoundException
     */
    public function lookUpByEmail($email)
    {
        return $this->_lookUpBy(self::EMAIL, $email);
    }
    
    /**
     * Looks up an user using the given service data.
     *
     * @param string $service Service to look up with.
     * @param mixed $data Data relevant to the service.
     * @return Qwerly_API_Response|null
     * @throws Qwerly_API_ErrorException
     * @throws Qwerly_API_NotFoundException
     */
    private function _lookUpBy($service, $data)
    {
        $batch = false;
        $urlFormat = self::$URLS[$service];

        if (is_array($data)) {
            $data = implode(',', $data);
            $batch = true;
        }
        
        $url = self::BASE_URL
            . sprintf($urlFormat, urlencode($data))
            . sprintf(self::API_KEY, $this->_apiKey);

        $this->_client->setUri($url);

        $request = $this->_client->request();
        $data = Zend_Json::decode($request->getBody());
        
        if ($request->getStatus() == self::TRY_AGAIN_LATER_CODE
            || $request->getStatus() == self::NOT_FOUND_CODE) {
            throw new Qwerly_API_NotFoundException(
                $data['message'], $data['status']
            );
        } else if ($request->getStatus() == 400) {
            throw new Qwerly_API_ErrorException(
                $data['message'], $data['status']
            );
        } else if (!$request->isSuccessful()) {
            throw new Qwerly_API_ErrorException($request->getBody());
        }
        
        if ($batch) {
            return new Qwerly_API_Response_Batch($data);
        } else {
            return new Qwerly_API_Response_User($data);
        }
    }

}
