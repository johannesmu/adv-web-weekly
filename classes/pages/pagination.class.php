<?php
namespace pages;
class Pagination {
  private $total_pages;
  private $current_page;
  private $items_per_page;
  private $nav_items = array();
  public function __construct($page=1,$items_per_page,$total_items){
    $this -> $total_pages = ceil($total_items / $items_per_page);
  }
  private function generateNavItems(){
    $nav_item = "";
  }
}
?>