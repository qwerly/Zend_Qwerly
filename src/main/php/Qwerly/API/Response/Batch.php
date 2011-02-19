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
 * Qwerly's batch response object.
 */
class Qwerly_API_Response_Batch
{

    private $_found = array();
    private $_notFound = array();
    private $_tryAgainLater = array();
    
    /**
     * Creates a new batch response.
     * 
     * @param array $data The batch response data.
     */
    public function __construct(array $data)
    {
        // Don't even bother looking at this.
        // Will sort out users later.
        unset($data['status']);
        
        foreach ($data as $identifier => $item) {
            
            switch ($item['status']) {
                case Qwerly_API::NOT_FOUND_CODE:
                    $this->_notFound[] = $identifier;
                    break;
                    
                case Qwerly_API::TRY_AGAIN_LATER_CODE:
                    $this->_tryAgainLater[] = $identifier;
                    break;
                default:
                    // The user was found!
                    $this->_found[] = new Qwerly_API_Response_User($item);
            }
            
        }
    }
    
    /**
     * Retrieves the list of found users in the batch lookup.
     * 
     * @return array
     */
    public function getFoundUsers()
    {
        return $this->_found;
    }
    
    /**
     * Retrieves the list of not found users in the batch lookup.
     * 
     * @return array
     */
    public function getNotFoundUsers()
    {
        return $this->_notFound;
    }
    
    /**
     * Retrieves the list of users that should be looked up later.
     * 
     * @return array
     */
    public function getTryAgainLaterUsers()
    {
        return $this->_tryAgainLater;
    }
    
}