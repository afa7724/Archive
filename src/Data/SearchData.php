<?php
namespace App\Data;

use DateTimeImmutable;
use Symfony\Component\Validator\Constraints as Assert;

class SearchData
{
     

   /**
    * Undocumented variable
    *
    * @var integer
    */
    public $page = 1;

    /**
     * 
     *
     * @var String
     */

     public $q;
    

 
    
   
    /**
     * Undocumented variable
     *
     * @var  Category|null
     */
    public $filiere;
     
    /**
     * @var integer|null
     */
    public $typearchive;


  
}