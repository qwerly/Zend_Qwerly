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
 * Qwerly_API test
 */
class Qwerly_APITest extends PHPUnit_Framework_TestCase
{

    const TEST_RESPONSE = '{ "profile":{ "description":"Random dude","location":"Buenos Aires, Argentina","name":"Franco","twitter_username":"zfran","qwerly_username":null,"services":[{ "type":"twitter","url":"http://twitter.com/zfran","username":"zfran"},{ "type":"klout","url":"http://klout.com/zfran","username":"zfran"}]},"public_url":"http://qwerly.com/twitter/zfran","status":200}';
    const TEST_RESPONSE_ERROR =
        '{"message":"Profile not found","status":404}';
    /**
     * Tests the constructor.
     *
     * @return void
     */
    public function testConstructor()
    {
        $caught = false;

        try {
            $foo = new Qwerly_API(null);
        } catch (Qwerly_API_ErrorException $e) {
            $this->assertEquals(
                $e->getMessage(),
                'The API key can\'t be null'
            );

            $caught = true;
        }

        $this->assertTrue($caught, 'Exception wasn\'t rised');

    }

    public function testLookUpByTwitterUsername()
    {
        $key = 'abcdef0123456789';

        $adapter = new Zend_Http_Client_Adapter_Test();
        $response = new Zend_Http_Response(200, array(), self::TEST_RESPONSE);
        $adapter->setResponse($response);

        $client = new Zend_Http_Client(
            null,
            array(
                'adapter' => $adapter
            )
        );

        $api = new Qwerly_API($key, $client);
        $ret = $api->lookUpByTwitterUsername('test');

        $this->assertEquals(
            'http://api.qwerly.com:80/v1/twitter/test?api_key=' . $key,
            $client->getUri()->getUri()
        );

        $this->assertTrue($ret instanceof Qwerly_API_Response);
        $this->assertEquals('Random dude', $ret->getDescription());
        $this->assertEquals('Buenos Aires, Argentina', $ret->getLocation());
        $this->assertEquals('Franco', $ret->getName());
        $this->assertEquals('zfran', $ret->getTwitter());
        $this->assertNull($ret->getWebsite());
        $this->assertNull($ret->getFacebook());
        $this->assertNull($ret->getQwerly());
        $arr = $ret->getServices();

        $this->assertEquals(
            array(
                'type' => 'twitter',
                'url' => 'http://twitter.com/zfran',
                'username' => 'zfran'
            ),
            $arr[0]
        );

        $response = new Zend_Http_Response(
            404, array(), self::TEST_RESPONSE_ERROR
        );

        $adapter->setResponse($response);

        $caught = false;

        try {
            $api->lookUpByFacebookUsername('asd');
        } catch (Qwerly_API_ErrorException $e) {
            $this->assertEquals(
                'Profile not found',
                $e->getMessage()
            );

            $this->assertEquals(404, $e->getCode());

            $caught = true;
        }

        $this->assertTrue($caught);
    }
}
