<?php 

class ShopItemCest
{
    use Helper\ManyToManyTrait;

    static protected $createdId = 0;
    static protected $createdSubs = [];

    static protected $countItems = 3;

    static protected $route = '/shops';
    static protected $subroute = '/items';
    
    static protected $before = false;

}
