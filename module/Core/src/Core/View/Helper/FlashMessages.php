<?php

namespace Core\View\Helper;
use Zend\View\Helper\AbstractHelper;

class FlashMessages extends AbstractHelper
{

    protected $flashMessenger;

    public function setFlashMessenger( $flashMessenger )
    {
        $this->flashMessenger = $flashMessenger ;
    }
    public function __invoke( )
    {
        $namespaces = array( 
            'danger' ,'success', 'info','warning' 
        );
        // messages as string
        $messageString = '';
        foreach ( $namespaces as $ns ) {

            $this->flashMessenger->setNamespace( $ns );

            $messages = array_merge(
                $this->flashMessenger->getMessages(),
                $this->flashMessenger->getCurrentMessages()
            );

            if ( ! $messages ) continue;

            $messageString .= "<p class='flashmessages bg-$ns'>";
            $messageString .= implode( '<br />', $messages );
            $messageString .= '</p>';
        }

        return $messageString ;
    }
}