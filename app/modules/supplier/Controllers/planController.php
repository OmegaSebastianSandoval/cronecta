<?php

/**
 *
 */

class Supplier_planController extends Supplier_mainController
{

  public $botonPanel = 4;

  protected $_csrf_section = "supplier_profile";

  public function init()
  {
    $user = Session::getInstance()->get("user");
    $supplier = Session::getInstance()->get("supplier");

    if (!$user || !$supplier) {
      header('Location: /supplier/login');
      exit;
    }
    parent::init();
  }

  #region IndexAction
  public function indexAction()
  {
    $this->_view->list_oprtunityStatus = $this->getOportunities();

  }

}