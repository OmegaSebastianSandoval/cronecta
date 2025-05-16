<?php

/**
 *
 */

class Supplier_dashboardController extends Supplier_mainController
{

  public $botonPanel = 1;

  public function indexAction()
  {
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");
  }
}
