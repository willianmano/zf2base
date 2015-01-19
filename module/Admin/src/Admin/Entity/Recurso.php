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
 * @ORM\Entity(repositoryClass="Admin\Entity\Recurso")
 * @ORM\Entity
 * @ORM\Table(name="seg_recursos")
 * @property int $rcs_id
 * @property int $rcs_mod_id
 * @property int $rcs_ctr_id
 * @property string $rcs_nome
 * @property string $rcs_descricao
 * @property string $rcs_icone
 * @property string $rcs_ativo
 */
class Recurso implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $rcs_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rcs_mod_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $rcs_ctr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_descricao;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_icone;

    /**
     * @ORM\Column(type="string")
     */
    protected $rcs_ativo;

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
        $this->rcs_id = (isset($data['rcs_id'])) ? $data['rcs_id'] : 0;
        $this->rcs_mod_id = (isset($data['rcs_mod_id'])) ? $data['rcs_mod_id'] : 0;
        $this->rcs_ctr_id = (isset($data['rcs_ctr_id'])) ? $data['rcs_ctr_id'] : 0;
        $this->rcs_nome = (isset($data['rcs_nome'])) ? $data['rcs_nome'] : null;
        $this->rcs_descricao = (isset($data['rcs_descricao'])) ? $data['rcs_descricao'] : null;
        $this->rcs_icone = (isset($data['rcs_icone'])) ? $data['rcs_icone'] : null;
        $this->rcs_ativo = (isset($data['rcs_ativo'])) ? $data['rcs_ativo'] : 0;
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
                'name'     => 'rcs_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_mod_id',
                'required' => true
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_ctr_id',
                'required' => true
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_nome',
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
                'name'     => 'rcs_descricao',
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
                'name'     => 'rcs_icone',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'rcs_ativo',
                'required' => false
            )));
 
            $this->inputFilter = $inputFilter;        
        }
 
        return $this->inputFilter;
    } 
}