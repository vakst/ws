<?php
namespace TaskApp\Server;
use TaskApp\Interfaces\IFilter;

class FilterChain
{
   private $filterList = array();

   /**
    * Add IFilter to chain
    * @param IFilter $filter 
    * @return FilterChain
    */
   public function addFilter(IFilter $filter)
   {
      $this->filterList[] = $filter;
      return $this;
   }

   /**
    * Filter array $data
    * @param array $data 
    * @return array
    */
   public function execute($data)
   {
      foreach ($this->filterList as $filter) {
      	$data = $filter->execute($data);
      }

      return $data;
   }
}