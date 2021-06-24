<?php
require_once 'model.php';

class News extends Model
{
    protected $table = 'news';
    
    public function __construct()
    {
        parent::__construct();
    }
}
