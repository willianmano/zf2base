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
 * @ORM\Entity(repositoryClass="Admin\Entity\Perfil")
 * @ORM\Entity
 * @ORM\Table(name="seg_perfis")
 * @property int $prf_id
 * @property string $prf_nome
 * @property string $prf_descricao
 */
class Perfil implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $prf_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $prf_mod_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $prf_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $prf_descricao;

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
        $this->prf_id = (isset($data['prf_id'])) ? $data['prf_id'] : 0;
        $this->prf_mod_id = (isset($data['prf_mod_id'])) ? $data['prf_mod_id'] : null;
        $this->prf_nome = (isset($data['prf_nome'])) ? $data['prf_nome'] : null;
        $this->prf_descricao = (isset($data['prf_descricao'])) ? $data['prf_descricao'] : null;
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

            // foi necessario adicionar por causa da configuracaod o form 
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_mod_id',
                'required' => true
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'prf_nome',
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
                'name'     => 'prf_descricao',
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
 
            $this->inputFilter = $inputFilter;        
        }
 
        return $this->inputFilter;
    } 
}