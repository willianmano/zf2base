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
 * @ORM\Entity(repositoryClass="Admin\Entity\CategoriaRecurso")
 * @ORM\Entity
 * @ORM\Table(name="seg_categorias_recursos")
 * @property int $ctr_id
 * @property string $ctr_nome
 * @property string $ctr_descricao
 * @property string $ctr_icone
 */
class CategoriaRecurso implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $ctr_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_descricao;

    /**
     * @ORM\Column(type="string")
     */
    protected $ctr_icone;

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
        $this->ctr_id = (isset($data['ctr_id'])) ? $data['ctr_id'] : null;
        $this->ctr_nome = (isset($data['ctr_nome'])) ? $data['ctr_nome'] : null;
        $this->ctr_descricao = (isset($data['ctr_descricao'])) ? $data['ctr_descricao'] : null;
        $this->ctr_icone = (isset($data['ctr_icone'])) ? $data['ctr_icone'] : null;
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
                'name'     => 'ctr_nome',
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
                'name'     => 'ctr_descricao',
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
                'name'     => 'ctr_icone',
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