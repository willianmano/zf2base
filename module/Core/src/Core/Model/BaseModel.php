<?php

namespace Core\Model;

use Core\Service\ModelService;

class BaseModel extends ModelService
{
   protected $entity;

   public function setEntity($entity){
      $this->entity = $entity;
      return $this;
   }

   /*
   * Carrega toda os itens
   */
   public function findAll()
   {
      $repository = $this->getEntityManager()->getRepository($this->entity);
      return $repository->findAll();
   }

   /*
   * Carrega todo os itens passando o id com oparametro
   */
   public function getById($id)
   {
      $data = $this->getEntityManager()->find($this->entity, $id);
      return $data;
   }

   //Salva
   public function save($data)
   {
      $repository = $this->getEntityManager();
      $repository->persist($data);
      $repository->flush();
   }

   //Update
   public function update($data, $id)
   {
      $repository = $this->getEntityManager();

      $update = $repository->find($this->entity, $id);
      $update->exchangeArray($data->getArrayCopy());
      $repository->flush();

      return $data;
   }

   //Delete
   public function delete($id)
   {
         $repository = $this->getEntityManager();

         $delete = $repository->find($this->entity, $id);
      try{
         $repository->remove($delete);
         $repository->flush();
      } catch(\Doctrine\DBAL\DBALException $e) {
         $this->flashMessenger()->setNamespace('error')->addMessage('Não foi possível excluir o(a) ' . $this->label . '!');
      }
      return true;
   }

   /*
   * Conta todos os itens
   */
   public function count()
   {
      $qb = $this->getEntityManager()->createQueryBuilder();
      $qb->select('count(e)')->from($this->entity, 'e');
      return $qb->getQuery()->getSingleScalarResult();
   }

   /*
   * Carrega os itens passando um campo e o valor
   * Ex. array($attributes => $value)
   */
   public function getByAttributes($array)
   {
      $data = $this->getEntityManager()->getRepository($this->entity)->findBy($array);
      return $data;
   }

   //Popula Select
   public function getAllItensToSelect($attributeId,$attributeLabel)
   {
      $repository = $this->getEntityManager()->getRepository($this->entity);
      $data = $repository->findAll();

      $obj = [];   
      foreach ($data as $key => $value) {
         $obj[$value->$attributeId] = $value->$attributeLabel;
      }
      return $obj;
   }
   public function getAllItensToSelectByAttributes($attributes, $attributeId, $attributeLabel) {
      $data = $this->getEntityManager()->getRepository($this->entity)->findBy($attributes);

      $obj = [];   
      foreach ($data as $key => $value) {
         $obj[$value->$attributeId] = $value->$attributeLabel;
      }
      return $obj;
   }
   public function getAllItensToSelectByAttributesJsonReturn($attributes, $attributeId, $attributeLabel) {
      $data = $this->getEntityManager()->getRepository($this->entity)->findBy($attributes);

      $obj = [];   
      foreach ($data as $key => $value) {
         $obj[] = array($attributeId => $value->$attributeId,  $attributeLabel => $value->$attributeLabel);
      }
      return $obj;
   }
}