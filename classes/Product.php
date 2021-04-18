<?php


class Product extends Service {


  public static function all(){
    return [
      ['name' => 'phone' , 'price' => 700 ],
      ['name' => 'note' , 'price' => 20 ],
      ['name' => 'book' , 'price' => 49 ],
    ];
  }


}
