<?php

namespace NextDeveloper\IAM\WebSockets;

use NextDeveloper\IAM\Helpers\UserHelper;
use Ratchet\ConnectionInterface;
use Ratchet\WebSocket\MessageComponentInterface;

abstract class BaseHandler implements MessageComponentInterface
{
    public $me = null;

    function onOpen(ConnectionInterface $conn)
    {
        // TODO: Implement onOpen() method.
        dump('opened socket connection');
        //$this->verifyUser($conn);
    }

    function onClose(ConnectionInterface $conn)
    {
        // TODO: Implement onClose() method.
        dump('closed socket connection');
    }

    function onError(ConnectionInterface $conn, \Exception $e)
    {
        // TODO: Implement onError() method.
//        dump($e);
        dump('wehaveerror');
    }

    protected function verifyUser(ConnectionInterface $conn)
    {
        $this->me = UserHelper::me();
    }
}