<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface; 


/**
 * Users Table.
 *
 * @ORM\Entity(repositoryClass="Admin\Entity\Usuario")
 * @ORM\Entity
 * @ORM\Table(name="seg_usuarios")
 * @property int $usr_id
 * @property string $usr_usuario
 * @property string $usr_senha
 */
class Usuario implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $usr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $usr_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $usr_email;

    /**
     * @ORM\Column(type="string")
     */
    protected $usr_telefone;

    /**
     * @ORM\Column(type="string")
     */
    protected $usr_usuario;

    /**
     * @ORM\Column(type="string")
     */
    protected $usr_senha;

    /**
     * @ORM\Column(type="integer")
     */
    protected $usr_ativo;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) 
    {
        return $this->$property;
    }
 
    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) 
    {
        $this->$property = $value;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() 
    {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    
    public function exchangeArray($data)
    {
        $this->usr_id = (isset($data['usr_id'])) ? $data['usr_id'] : null;
        $this->usr_nome = (isset($data['usr_nome'])) ? $data['usr_nome'] : null;
        $this->usr_email = (isset($data['usr_email'])) ? $data['usr_email'] : null;
        $this->usr_telefone = (isset($data['usr_telefone'])) ? $data['usr_telefone'] : null;
        $this->usr_usuario = (isset($data['usr_usuario'])) ? $data['usr_usuario'] : null;
        $this->usr_senha = (isset($data['usr_senha'])) ? $data['usr_senha'] : null;
        $this->usr_ativo = (isset($data['usr_ativo'])) ? $data['usr_ativo'] : 0;
    }

    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new \Exception("Not used");
    }

    public function getInputFilter()
    {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
 
            $factory = new InputFactory();
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_nome',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 150,
                        ),
                    ),
                ),
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_usuario',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 15,
                        ),
                    ),
                ),
            )));
 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'usr_senha',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 1,
                            'max'      => 100,
                        ),
                    ),
                ),
            )));
 
            $this->inputFilter = $inputFilter;        
        }
 
        return $this->inputFilter;
    } 
}