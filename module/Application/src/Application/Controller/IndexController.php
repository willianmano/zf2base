<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Core\Controller\BaseController;
use Zend\View\Model\ViewModel;

class IndexController extends BaseController
{
    public function indexAction()
    {
        $session = $this->getService('Session')->offsetGet('zf2base_loggeduser');

        $conn = $this->getDbalConnection();

        $sql = "SELECT * from seg_modulos m
                INNER JOIN seg_perfis p ON p.prf_mod_id = m.mod_id
                INNER JOIN seg_perfis_usuarios pu ON pu.pru_prf_id = p.prf_id
                WHERE m.mod_ativo = 1 AND pu.pru_usr_id = :loggeduserid ";
        $data = array('loggeduserid' => $session->usr_id);

        $userModules = $conn->executeQuery($sql, $data)->fetchAll();
        
        return new ViewModel(
            array('userModules' => $userModules)
        );
    }
    public function testAction()
    {
        $em = $this->getEntityManager();
        $users = $em->getRepository('Application\Entity\Usuario')->findAll();

        // $conn = $this->getDbalConnection();
        // $sql = "SELECT * from seg_usuarios";
        // $users = $conn->executeQuery($sql, array())->fetchAll(\PDO::FETCH_CLASS);

    	return new ViewModel(array('usuarios' => $users));
    }
}
