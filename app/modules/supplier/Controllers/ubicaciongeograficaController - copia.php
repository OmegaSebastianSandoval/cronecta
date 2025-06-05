<?php

/**
 *
 */

class Supplier_ubicaciongeograficaController extends Supplier_mainController
{

  public function searchAction(){
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit","500M");

    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");

    $q = $this->_getSanitizedParam("q");

    $paises_json = $this->getCountry();

    $paises = array();
    $regiones = array();
    $ciudades = array();

    foreach($paises_json as $value){

      if(strpos($value['name'],$q)!==false){
        $paises[]= $pais= $value['name'];
      }
      if(strpos($value['subregion'],$q)!==false){
        $regiones[]= $region = $value['subregion'];
      }
      
      $array_estados=$value['states'];
      
      foreach($array_estados as $estado){
        if(strpos($estado['name'],$q)!==false){
          $estados[]=$estado['name'];
        }
        
        $array_ciudades = $estado['cities'];
        foreach($array_ciudades as $ciudad){
          if(strpos($ciudad['name'],$q)!==false){
            $ciudades[]=$ciudad['name'];
          }
        }
      }

      //$pais_region[$region][]=$value;

    }

    $regiones = array_unique($regiones);

    $items = array();   
    $i=0;
    foreach($regiones as $value){
      $items[] = array("id"=>$value, "text"=>$value);
    }
    foreach($paises as $value){
      $items[] = array("id"=>$value, "text"=>$value);
    }
    foreach($estados as $value){
      $items[] = array("id"=>$value, "text"=>$value);
    }
    foreach($ciudades as $value){
      $items[] = array("id"=>$value, "text"=>$value);
    } 
    

    //$items = array_unique($items);
    //asort($items);  

    $res['results']=$items;
    echo json_encode($res);

  }

  public function indexAction()
  {
    ini_set("memory_limit","500M");
    $this->_view->banner = $this->template->banner("1");
    $this->_view->contenido = $this->template->getContentseccion("1");

    $paises_json = $this->getCountry();

    $paises = array();
    $regiones = array();
    $ciudades = array();

    foreach($paises_json as $value){
      $paises[]= $pais= $value['name'];
      $regiones[]= $region = $value['subregion'];
      
      $array_estados=$value['states'];
      foreach($array_estados as $estado){
        $estados[]=$estado['name'];
        
        $array_ciudades = $estado['cities'];
        foreach($array_ciudades as $ciudad){
          $ciudades[]=$ciudad['name'];
        }
      }

      //$pais_region[$region][]=$value;

    }

    $regiones = array_unique($regiones);

    /*
    $items = array();    
    foreach($regiones as $value){
      $items[]=$value;
    }
    foreach($paises as $value){
      $items[]=$value;
    }
    foreach($estados as $value){
      $items[]=$value;
    }
    foreach($ciudades as $value){
      //$items[]=$value;
    } 
        
    $items = array_unique($items);
    asort($items);  
    */
    asort($regiones);  

    unset($paises_json);   

    $this->_view->items = $items;
    $this->_view->regiones = $regiones;
    $this->_view->pais_region = $pais_region;


    $supplier_id = $_SESSION['supplier']->id;
    //$supplier_id = 1;
    $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
    $geolocations = $geolocationModel->getList(" supplier_id='$supplier_id' "," name ASC ");
    $this->_view->geolocations = $geolocations;
  }


  public function get_paisesAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit","500M");
    $paises_json = $this->getCountry();
    $region = $this->_getSanitizedParam("region");

    foreach($paises_json as $value){
      $subregion = $value['subregion'];
      if($subregion==$region){
        $paises[]= $pais= $value['name'];
      }
    }

    $div_paises='';
    foreach($paises as $pais){
      $pais_md5 = md5($pais);
      $div_paises.='<li class="mb-1 paises"><a class="dropdown-item" href="#" onclick="get_estados(\''.$pais_md5.'\')">'.$pais.' <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\''.$pais.'\');" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>';
    }

    $res['paises']=$div_paises;
    echo json_encode($res);

  }

  public function get_estadosAction()
  {
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit","500M");
    $paises_json = $this->getCountry();
    $pais_md52 = $this->_getSanitizedParam("pais");

    foreach($paises_json as $value){
        $pais= $value['name'];
        $pais_md5 = md5($pais);
        if($pais_md5==$pais_md52){
          $array_estados=$value['states'];
          foreach($array_estados as $estado){
            $estados[]=$estado['name'];
          }
          break;
        }
    }

    $div_estados='';
    foreach($estados as $estado){
      $estado_md5 = md5($estado);
      $div_estados.='<li class="mb-1 estados"><a class="dropdown-item" href="#" onclick="get_ciudades(\''.$estado_md5.'\',\''.$pais_md52.'\')">'.$estado.' <i class="fas fa-chevron-right flecha"></i></a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\''.$estado.'\');" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>';
    }

    $res['estados']=$div_estados;
    echo json_encode($res);

  }


  public function get_ciudadesAction()
  {
    //error_reporting(E_ERROR);
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit","500M");
    $paises_json = $this->getCountry();
    $pais_md52 = $this->_getSanitizedParam("pais");
    $estado_md52 = $this->_getSanitizedParam("estado");

    foreach($paises_json as $value){
        $pais= $value['name'];
        $pais_md5 = md5($pais);
        if($pais_md5==$pais_md52){
          $array_estados=$value['states'];
          foreach($array_estados as $estado){
            $estado1 = $estado['name'];
            $estado_md5 = md5($estado1);
            if($estado_md5==$estado_md52){
              $array_ciudades = $estado['cities'];
              foreach($array_ciudades as $ciudad){
                $ciudades[]=$ciudad['name'];
              }
              break;            
            }
          }
          break;
        }
    }

    $div_ciudades='';
    foreach($ciudades as $ciudad){
      $div_ciudades.='<li class="mb-1 estados"><a class="dropdown-item" href="#">'.$ciudad.'</a> <button type="button" class="btn btn-sm btn-primary" onclick="agregar(\''.$ciudad.'\');" title="Agregar" data-bs-toggle="tooltip" data-bs-placement="top"><i class="fas fa-plus-circle"></i></button></li>';
    }

    $res['ciudades']=$div_ciudades;
    echo json_encode($res);

  }    

  public function worldwideAction()
  {
    $this->setLayout('blanco');
    $valor = $this->_getSanitizedParam("valor");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier_id = $_SESSION['supplier']->id;

    if($valor!="" and $supplier_id!=""){
      $supplierModel->editField($supplier_id,"worldwide",$valor);
    }

  }  

  public function agregar_ubicacionAction()
  {
    $this->setLayout('blanco');
    $valor = $this->_getSanitizedParam("valor");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier_id = $_SESSION['supplier']->id;
    //$supplier_id=1;

    if($valor!="" and $supplier_id!=""){
      $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
      $data['supplier_id'] = $supplier_id;
      $data['name'] = $valor;
      $geolocationModel->insert($data);
    }

  } 

  public function borrar_ubicacionAction()
  {
    $this->setLayout('blanco');
    $valor = $this->_getSanitizedParam("valor");

    $supplierModel = new Administracion_Model_DbTable_Supplier();
    $supplier_id = $_SESSION['supplier']->id;
    //$supplier_id=1;

    if($valor!="" and $supplier_id!=""){
      $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
      $data['supplier_id'] = $supplier_id;
      $data['name'] = $valor;
      $geolocationModel->insert($data);
    }

  }      

}