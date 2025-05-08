<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

  public function indexAction()
  {
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");
  }
}
