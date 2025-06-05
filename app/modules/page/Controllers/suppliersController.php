<?php

class Page_suppliersController extends Page_mainController
{

  public $mainModel;

  /**
   * $route  url del controlador base
   * @var string
   */
  protected $route;

  /**
   * $pages cantidad de registros a mostrar por pagina]
   * @var integer
   */
  protected $pages ;

  /**
   * $namefilter nombre de la variable a la fual se le van a guardar los filtros
   * @var string
   */
  protected $namefilter;

  /**
   * $_csrf_section  nombre de la variable general csrf  que se va a almacenar en la session
   * @var string
   */
  protected $_csrf_section = "page_listasuppliers";

  /**
   * $namepages nombre de la pvariable en la cual se va a guardar  el numero de seccion en la paginacion del controlador
   * @var string
   */
  protected $namepages;

  public function init()
  {
    $this->mainModel = new Page_Model_DbTable_Listasuppliers();
    $this->namefilter = "parametersfilterlistasuppliers";
    $this->route = "/page/suppliers";
    $this->namepages ="pages_listasuppliers";
    $this->namepageactual ="page_actual_listasuppliers";
    $this->_view->route = $this->route;
    if(Session::getInstance()->get($this->namepages)){
      $this->pages = Session::getInstance()->get($this->namepages);
    } else {
      $this->pages = 20;
    }
    parent::init();
  }

  public function indexAction()
  {
    $this->filters();
    $this->_view->csrf = Session::getInstance()->get('csrf')[$this->_csrf_section];
    $filters =(object)Session::getInstance()->get($this->namefilter);
        $this->_view->filters = $filters;
    $filters = $this->getFilter();

    $client_id = $_SESSION['client']->id;
    $clientModel = new Page_Model_DbTable_Clients();
    $client = $clientModel->getById($client_id);
    $pais = $client->country;
    $ciudad = $client->city;

    $order = " CASE WHEN country='".$pais."' AND city='".$ciudad."' THEN 1 WHEN country='".$pais."' AND city!='".$ciudad."' AND city IS NOT NULL THEN 2 WHEN country='".$pais."' AND city IS NULL THEN 3 ELSE 4 END ";
    $list = $this->mainModel->getList($filters,$order);
    $amount = $this->pages;
    $page = $this->_getSanitizedParam("page");
    if (!$page && Session::getInstance()->get($this->namepageactual)) {
        $page = Session::getInstance()->get($this->namepageactual);
        $start = ($page - 1) * $amount;
    } else if(!$page){
      $start = 0;
        $page=1;
      Session::getInstance()->set($this->namepageactual,$page);
    } else {
      Session::getInstance()->set($this->namepageactual,$page);
        $start = ($page - 1) * $amount;
    }
    $this->_view->register_number = count($list);
    $this->_view->pages = $this->pages;
    $this->_view->totalpages = ceil(count($list)/$amount);
    $this->_view->page = $page;
    $this->_view->lists = $lists = $this->mainModel->getListPages($filters,$order,$start,$amount);
    $this->_view->csrf_section = $this->_csrf_section;

    $this->_view->list_industry = $list_industry = $this->getIndustry();   
    $this->_view->list_segments = $list_segments = $this->getSegments2();   
    $this->_view->countries = $this->getCountry();

    //cobertura geografica maximo 5 ubicaciones desde o general a lo particular
    $geolocationModel = new Administracion_Model_DbTable_Suppliergeolocation();
    $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();
    foreach($lists as $supplier){
      $supplier_id = $supplier->id;
      $supplier->geolocations = $geolocationModel->getList(" supplier_id='$supplier_id' ", " level*1 ASC, name ASC LIMIT 5 ");

      $experiences = $this->getExperiences($supplier_id);
      $supplier->experience_list = $experiences;
      
      $array_industrias=array();
      foreach($experiences as $experience){
        if($list_industry[$experience->industry]){
          $array_industrias[] = $list_industry[$experience->industry];
        }
      }



      $array_industrias = array_unique($array_industrias);
      asort($array_industrias);
      $supplier->experiencias = $array_industrias;

      $user = $userSupplierModel->getList(" supplier_id='$supplier_id' ","")[0];
      $supplier->user = $user;

      $supplier->segments = $this->getSegmentsArray($supplier_id);
      $supplier->industries = $this->getIndustryArray($supplier_id);      

    }
    $this->_view->lists = $lists;

  }

  public function getIndustryArray($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $array = array();
    $id = $supplierId ?? $supplierSession->id;
    $industriesModel = new Administracion_Model_DbTable_Supplierindustries();
    $segmentsModel = new Administracion_Model_DbTable_Suppliersegments();
    if($id) {
      $industries = $industriesModel->getList("supplier_id = $id", "");
      foreach($industries as $value){
        $array[]=$value->industry_id;
      }
    }
    $array = array_unique($array);
    return $array;
  } 

  public function getSegmentsArray($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $array = array();
    $id = $supplierId ?? $supplierSession->id;
    $industriesModel = new Administracion_Model_DbTable_Supplierindustries();
    $segmentsModel = new Administracion_Model_DbTable_Suppliersegments();
    if($id) {
      $industries = $industriesModel->getList("supplier_id = $id", "");
      foreach ($industries as $industry) {
        $segments = $segmentsModel->getList("industry_id = $industry->id AND supplier_id = $id ", "");
        foreach($segments as $value){
          $array[]=$value->segment_id;
        }
      }
    }
    $array = array_unique($array);
    return $array;
  }  

  public function getExperiences($supplierId = null)
  {
    $supplierSession = Session::getInstance()->get("supplier");
    $id = $supplierId ?? $supplierSession->id;
    $supplierExperiencesModel = new Administracion_Model_DbTable_Supplierexperiences();
    $experiences = $supplierExperiencesModel->getList("supplier_id = $id", "");
    return $experiences;
  }  

  public function getIndustry()
  {
    $modelData = new Supplier_Model_DbTable_Dependindustries();
    $data = $modelData->getList();
    $array = array();
    foreach ($data as $key => $value) {
      $array[$value->id] = $value->name;
    }
    return $array;
  }

  public function getSegments2()
  {
    $modelData = new Administracion_Model_DbTable_Dependindustrysegments();
    $data = $modelData->getList();
    $array = array();
    foreach ($data as $key => $value) {
      $array[$value->id] = $value->name;
    }
    return $array;
  }  


  public function get_segmentosAction()
  {
    error_reporting(E_ERROR);
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    $industrias = $this->_getSanitizedParam("industrias");

    $aux = explode(",",$industrias);
    $f1=" (1=0 ";
    foreach($aux as $value){
      if($value){
        $f1.=" OR industry_id='$value' ";
      }
    }
    $f1.=" ) ";

    $filters=(object)Session::getInstance()->get($this->namefilter);
    $seleccionado2 = $filters->segments;

    $segmentsModel = new Administracion_Model_DbTable_Dependindustrysegments();
    $opciones = $segmentsModel->getList("$f1", "");

    $div_opciones = '<option value=""></option>';
    foreach ($opciones as $opcion) {
      $seleccionado='';
      if($seleccionado2==$opcion->id){
        $seleccionado='selected';
      }
      $div_opciones .= '<option value="'.$opcion->id.'" '.$seleccionado.' >'.$opcion->name.'</option>';
    }

    $res['opciones'] = $div_opciones;
    echo json_encode($res);
  } 

  public function get_ciudadesAction()
  {
    //error_reporting(E_ERROR);
    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit", "500M");
    $paises_json = $this->getCountry();
    $pais = $this->_getSanitizedParam("pais");
    $pais_md52 = md5($pais);

    foreach ($paises_json as $value) {
      $pais = $value['name'];
      $pais_md5 = md5($pais);
      if ($pais_md5 == $pais_md52) {
        $array_estados = $value['states'];
        foreach ($array_estados as $estado) {
          $array_ciudades = $estado['cities'];
          foreach ($array_ciudades as $ciudad) {
            $ciudades[] = $ciudad['name'];
          }
        }
        break;
      }
    }

    asort($ciudades);

    $filters=(object)Session::getInstance()->get($this->namefilter);
    $seleccionado2 = html_entity_decode($filters->city);    

    $div_ciudades = '<option value=""></option>';
    foreach ($ciudades as $ciudad) {

      $seleccionado='';
      if($seleccionado2==$ciudad){
        $seleccionado='selected';
      }

      $div_ciudades .= '<option value="'.$ciudad.'" '.$seleccionado.' >'.$ciudad.'</option>';
    }

    $res['ciudades'] = $div_ciudades;
    echo json_encode($res);
  }


    protected function getFilter()
    {
      error_reporting(E_ERROR);
      $filtros = " 1 = 1 ";

      
      
      $segmentsModel = new Administracion_Model_DbTable_Dependindustrysegments();
      $industryModel = new Supplier_Model_DbTable_Dependindustries();
      $interestModel = new Administracion_Model_DbTable_Supplierclassification();

        if (Session::getInstance()->get($this->namefilter)!="") {
            $filters =(object)Session::getInstance()->get($this->namefilter);
            if ($filters->keyWords != '') {

                $filters->keyWords = $this->limpiar($filters->keyWords);

                //filtro segmentos
                $filtro_segmentos = " ( 1=0 ";
                $existe = $segmentsModel->getSuppliers(" industry_segments.name LIKE '%".$filters->keyWords."%' ","");
                foreach($existe as $value){
                  if($value->id!=""){
                    $filtro_segmentos.=" OR suppliers.id='".$value->id."' ";
                  }
                }    
                $filtro_segmentos.=" ) ";

                //filtro industria
                $filtro_industria = " ( 1=0 ";
                $existe = $industryModel->getSuppliers(" industries.name LIKE '%".$filters->keyWords."%' ","");
                foreach($existe as $value){
                  if($value->id!=""){
                    $filtro_industria.=" OR suppliers.id='".$value->id."' ";
                  }
                }    
                $filtro_industria.=" ) ";  

                //filtro actividades
                $filtro_actividades = " ( 1=0 ";
                $existe = $interestModel->getList(" name LIKE '%".$filters->keyWords."%' ","");
                foreach($existe as $value){
                  if($value->supplier_id!=""){
                    $filtro_actividades.=" OR suppliers.id='".$value->supplier_id."' ";
                  }
                }    
                $filtro_actividades.=" ) ";                                            

                $filtros = $filtros." AND (commercial_activity LIKE '%".$filters->keyWords."%' OR keywords LIKE '%".$filters->keyWords."%' OR company_name LIKE '%".$filters->keyWords."%' OR $filtro_segmentos OR $filtro_industria OR $filtro_actividades )
                ";

            }

            if ($filters->segments != '') {
                //filtro segmentos
                $filtro_segmentos = " ( 1=0 ";
                $existe = $segmentsModel->getSuppliers(" industry_segments.id = '".$filters->segments."' ","");
                foreach($existe as $value){
                  if($value->id!=""){
                    $filtro_segmentos.=" OR suppliers.id='".$value->id."' ";
                  }
                }    
                $filtro_segmentos.=" ) "; 

                $filtros.=" AND $filtro_segmentos ";              
            }


            if ($filters->industry != '') {
                //filtro industria
                $filtro_industria = " ( 1=0 ";
                $existe = $industryModel->getSuppliers(" industries.id = '".$filters->industry."' ","");
                foreach($existe as $value){
                  if($value->id!=""){
                    $filtro_industria.=" OR suppliers.id='".$value->id."' ";
                  }
                } 
                $filtro_industria.=" ) "; 

                $filtros.=" AND $filtro_industria ";              
            }

            if ($filters->country != '') {
              $filtros.=" AND country = '".$filters->country."' ";        
            }

            if ($filters->city != '') {
              $filtros.=" AND city = '".$filters->city."' ";        
            }  

            if ($filters->is_legal_entity != '') {
              $filtros.=" AND is_legal_entity = '".$filters->is_legal_entity."' ";        
            } 

            if ($filters->completeness != '') {
              $userSupplierModel = new Administracion_Model_DbTable_Supplierusers();
              if($filters->completeness==1){ //completo
                $existe = $userSupplierModel->getList(" completeness='100' ","");
              }
              if($filters->completeness==2){ //en proceso
                $existe = $userSupplierModel->getList(" completeness!='100' OR completeness IS NULL ","");
              }

              //filtro completeness
              $filtro_completeness = " ( 1=0 ";
              foreach($existe as $value){
                if($value->id!=""){
                  $filtro_completeness.=" OR suppliers.id='".$value->supplier_id."' ";
                }
              } 
              $filtro_completeness.=" ) "; 

              $filtros.=" AND $filtro_completeness ";

            }              



        }
        return $filtros;
    }

    public function limpiar($x){
      $x = html_entity_decode($x);
      $mal = array("á","é","í","ó","ú","Á","É","Í","Ó","Ú");
      $bien = array("a","e","i","o","u","A","E","I","O","U");
      $x = str_replace($mal,$bien,$x);
      return $x;
    }

    protected function filters()
    {
        if ($this->getRequest()->isPost()== true) {
          Session::getInstance()->set($this->namepageactual,1);
          $parramsfilter = array();
          $parramsfilter['keyWords'] =  $this->_getSanitizedParam("keyWords");
          $parramsfilter['industry'] =  $this->_getSanitizedParam("industry");
          $parramsfilter['segments'] =  $this->_getSanitizedParam("segments");
          $parramsfilter['country'] =  $this->_getSanitizedParam("country");
          $parramsfilter['city'] =  $this->_getSanitizedParam("city");
          $parramsfilter['is_legal_entity'] =  $this->_getSanitizedParam("is_legal_entity");
          $parramsfilter['completeness'] =  $this->_getSanitizedParam("completeness");
          

          Session::getInstance()->set($this->namefilter, $parramsfilter);
        }
        if ($this->_getSanitizedParam("cleanfilter") == 1) {
            Session::getInstance()->set($this->namefilter, '');
            Session::getInstance()->set($this->namepageactual,1);
        }
    }

}