<?php

class Page_planController extends Page_mainController
{

  public function indexAction()
  {
    $this->_view->list_industry = $this->getIndustry();
  }
  private function getIndustry()
  {
    $modelData = new Supplier_Model_DbTable_Dependindustries();
    $data = $modelData->getList();
    $array = array();
    foreach ($data as $key => $value) {
      $array[$value->id] = $value->name;
    }
    return $array;
  }
}
