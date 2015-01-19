<?php
namespace Core\Service;

use Zend\Crypt\Password\Bcrypt;
use Zend\Session\Container as SessionContainer;

class AuthService extends BaseService
{
    public function authenticate($params)
    {
        if (!isset($params['usr_usuario']) || $params['usr_usuario'] == '' || !isset($params['usr_senha']) ||  $params['usr_senha'] == '') {
            return false;
        }

        $em = $this->getEntityManager();
        $user = $em->getRepository('Admin\Entity\Usuario')->findBy(array('usr_usuario' => $params['usr_usuario']));
        $user = current($user);

        if ( !is_null($user) ) {
            $bcrypt = new Bcrypt();
            $verify = $bcrypt->verify($params['usr_senha'], $user->usr_senha);

            if ($verify) {
                $user->usr_senha = null;
                $session = $this->getServiceManager()->get('Session');
                $session->offsetSet('zf2base_loggeduser', $user);

                return true;
            }
        }
        return false;
    }
    public function isLogged()
    {
        $session = $this->getServiceManager()->get('Session');
        $user = $session->offsetGet('zf2base_loggeduser');
        if ( isset($user) ) {
            return true;
        }
        return false;
    }
    public function logout()
    {
        //$auth = new AuthenticationService();
        $session = $this->getServiceManager()->get('Session');
        $session->offsetUnset('zf2base_loggeduser');
        //$auth->clearIdentity();
        
        return true;
    }
}