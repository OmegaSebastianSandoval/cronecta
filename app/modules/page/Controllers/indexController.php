<?php

/**
 *
 */

class Page_indexController extends Page_mainController
{

  public function indexAction()
  {
    //$this->_view->banner = $this->template->banner("1");
    //$this->_view->contenido = $this->template->getContentseccion("1");
    $this->partialsHome();
  }

  public function buyerAction()
  {
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");
  }




}
