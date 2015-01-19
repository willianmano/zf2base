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
 * @ORM\Entity(repositoryClass="Admin\Entity\Permissao")
 * @ORM\Entity
 * @ORM\Table(name="seg_permissoes")
 * @property int $prm_id
 * @property string $prm_rcs_id
 * @property string $prm_nome
 * @property string $prm_descricao
 */
class Permissao implements InputFilterAwareInterface 
{

    protected $inputFilter;
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $prm_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $prm_rcs_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $prm_nome;

    /**
     * @ORM\Column(type="string")
     */
    protected $prm_descricao;

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
        $this->prm_id = (isset($data['prm_id'])) ? $data['prm_id'] : 0;
        $this->prm_rcs_id = (isset($data['prm_rcs_id'])) ? $data['prm_rcs_id'] : null;
        $this->prm_nome = (isset($data['prm_nome'])) ? $data['prm_nome'] : null;
        $this->prm_descricao = (isset($data['prm_descricao'])) ? $data['prm_descricao'] : null;
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
                'name'     => 'prm_id',
                'required' => false
            )));
            $inputFilter->add($factory->createInput(array(
                'name'     => 'prm_rcs_id',
                'required' => true
            )));

            $inputFilter->add($factory->createInput(array(
                'name'     => 'prm_nome',
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
                'name'     => 'prm_descricao',
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