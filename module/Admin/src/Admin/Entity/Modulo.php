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
 * @ORM\Entity(repositoryClass="Admin\Entity\Modulo")
 * @ORM\Entity
 * @ORM\Table(name="seg_modulos")
 * @property int $mod_id
 * @property string $mod_nome
 * @property string $mod_descricao
 * @property string $mod_icone
 * @property string $mod_ativo
 */
class Modulo implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $mod_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $mod_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $mod_descricao;

    /**
     * @ORM\Column(type="string")
     */
    protected $mod_icone;

    /**
     * @ORM\Column(type="integer")
     */
    protected $mod_ativo;

    /**
     * Returns the Id of the object.
     *
     * @return id
     */
    public function getId()
    {
        return $this->mod_id;
    }

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
     * @param $data
     */
    public function exchangeArray($data)
    {
        $this->mod_id = (isset($data['mod_id'])) ? $data['mod_id'] : null;
        $this->mod_nome = (isset($data['mod_nome'])) ? $data['mod_nome'] : null;
        $this->mod_descricao = (isset($data['mod_descricao'])) ? $data['mod_descricao'] : null;
        $this->mod_icone = (isset($data['mod_icone'])) ? $data['mod_icone'] : null;
        $this->mod_ativo = (isset($data['mod_ativo']));
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
                'name'     => 'mod_nome',
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
                'name'     => 'mod_descricao',
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
                'name'     => 'mod_icone',
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
                            'max'      => 45,
                        ),
                    ),
                ),
            )));
 
            $this->inputFilter = $inputFilter;        
        }
 
        return $this->inputFilter;
    } 
}