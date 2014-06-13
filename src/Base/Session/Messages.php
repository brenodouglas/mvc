<?php
namespace Base\Session;

use Base\Session\Interfaces\Messages as MessagesInterface;
use Base\Session\Session;
use Base\Session\Storage;

/**
 * Description of Messages
 *
 * @author bdouglas
 */
class Messages implements MessagesInterface
{
    const NAME = 'messsages';

    public static function addFlashMessage($key, $message)
    {
        $session = new Session();
        $session->addAttr($key, $message);
        
        $storage = new Storage(self::NAME);
        $storage->addSession($key, $session);
    }

    public static function getFlashMessage($key)
    {
        $storage = new Storage(self::NAME);
        $session = $storage->getSession($key);
        
        if(! $storage->unsetSession($key,true)){
            return false;
        }
        
        return $session->getAttr($key);
    }

}
