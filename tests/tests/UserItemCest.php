<?php 

class UserItemCest
{
    use Helper\ManyToManyTrait;

    static protected $createdId = 0;
    static protected $createdSubs = [];

    static protected $countItems = 3;

    static protected $route = '/users';
    static protected $subroute = '/items';
    
    static protected $before = false;

}
