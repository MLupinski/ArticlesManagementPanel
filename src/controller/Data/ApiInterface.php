<?php

namespace Src\Controller\Data;

interface ApiInterface 
{
        
    /**
     * get all
     *
     * @return mixed
     */
    public function getAll();    
    /**
     * add
     *
     * @return ArticlesInterface
     */
    public function add();    
    /**
     * edit
     *
     * @return ArticlesInterface
     */
    public function update();    
    /**
     * delete
     *
     * @return ArticlesInterface
     */
    public function delete();
}