<?php

/**
 *
 */

class Page_profileController extends Page_mainController
{

  public function indexAction()
  {
    //$this->_view->banner = $this->template->banner("1");
    //$this->_view->contenido = $this->template->getContentseccion("1");

    $this->_view->list_country = $this->getCountry();
    $this->_view->list_industry = $this->getIndustry();    

    $this->mis_intereses();

    $client_id = $_SESSION['client']->id;
    $clientModel = new Page_Model_DbTable_Clients();
    $this->_view->content = $clientModel->getById($client_id);
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

  public function itemsAction(){

    $this->setLayout('blanco');
    header('Content-Type: application/json; charset=utf-8');
    ini_set("memory_limit","500M");

    $sectorsModel= new Administracion_Model_DbTable_Commercialsectors();
    $segmentsModel= new Administracion_Model_DbTable_Commercialsegments();
    $familyModel= new Administracion_Model_DbTable_Commercialfamilies();
    $classModel= new Administracion_Model_DbTable_Commercialclasses();
    $productModel= new Administracion_Model_DbTable_Commercialproducts();

    $this->_view->sectors = $sectors = $sectorsModel->getList(""," name ASC ");
    $this->_view->segments = $segments = $segmentsModel->getList(""," segment_name ASC ");
    $this->_view->families = $families = $familyModel->getList(""," family_name ASC ");
    $this->_view->clases = $clases = $classModel->getList(""," class_name ASC ");
    $this->_view->products = $products = $productModel->getList(""," product_name ASC ");

    $items = array();
    foreach($sectors as $value){
      $items[] = array("id"=>'1_'.$value->id, "text"=>$value->name);
    }
    foreach($segments as $value){
      $items[] = array("id"=>'2_'.$value->id, "text"=>$value->name);
    } 
    foreach($families as $value){
      $items[] = array("id"=>'3_'.$value->id, "text"=>$value->name);
    }
    foreach($clases as $value){
      $items[] = array("id"=>'4_'.$value->id, "text"=>$value->name);
    } 
    foreach($products as $value){
      $items[] = array("id"=>'5_'.$value->id, "text"=>$value->name);
    }       
    //$items = array_unique($items);
    //asort($items);

    $res['results']=$items;
    //$res['pagination']=array("more"=>true);

    echo json_encode($res);

  }

  public function mis_intereses(){
    $interestModel = new Administracion_Model_DbTable_Clientinterests();
    $client_id = $_SESSION['client']->id;
    $this->_view->selectedSectors = $selectedSectors = $interestModel->getList("client_id='$client_id' AND level='1' ");
    $this->_view->selectedSegment = $selectedSegment =  $interestModel->getList("client_id='$client_id' AND level='2' ");
    $this->_view->selectedFamily = $selectedFamily = $interestModel->getList("client_id='$client_id' AND level='3' ");
    $this->_view->selectedClass = $selectedClass = $interestModel->getList("client_id='$client_id' AND level='4' ");
    $this->_view->selectedProduct = $selectedProduct = $interestModel->getList("client_id='$client_id' AND level='5' ");

    $sectorsModel= new Administracion_Model_DbTable_Commercialsectors();
    $segmentsModel= new Administracion_Model_DbTable_Commercialsegments();
    $familyModel= new Administracion_Model_DbTable_Commercialfamilies();
    $classModel= new Administracion_Model_DbTable_Commercialclasses();
    $productModel= new Administracion_Model_DbTable_Commercialproducts();

    
    $this->_view->sectors = $sectors = $sectorsModel->getList(""," name ASC ");
    $this->_view->segments = $segments = $segmentsModel->getList(""," segment_name ASC ");
    $this->_view->families = $families = $familyModel->getList(""," family_name ASC ");
    $this->_view->clases = $clases = $classModel->getList(""," class_name ASC ");
    $this->_view->products = $products = $productModel->getList(""," product_name ASC ");
    

    
    $items = array();
    foreach($sectors as $value){
      $items['1_'.$value->id]=$value->name;
    }
    foreach($segments as $value){
      $items['2_'.$value->segment_code]=$value->segment_name;
    } 
    foreach($families as $value){
      $items['3_'.$value->family_code]=$value->family_name;
    }
    foreach($clases as $value){
      $items['4_'.$value->class_code]=$value->class_name;
    } 
    foreach($products as $value){
      $items['5_'.$value->product_code]=$value->product_name;
    }                

    $items = array_unique($items);
    asort($items);
    $this->_view->items = $items;
    

    //segmentos filtrados
    $f1=" (1=0 ";
    foreach($selectedSectors as $value){
      if($value->code!=""){
        $f1.=" OR sector_id='".$value->code."' ";
      }
    }
    $f1.=" ) ";
    $this->_view->segments_filtro = $segmentsModel->getList("$f1","");

    //familias filtrados
    $f1=" (1=0 ";
    foreach($selectedSegment as $value){
      if($value->code!=""){
        $f1.=" OR segment_code='".$value->code."' ";
      }
    }
    $f1.=" ) ";    
    $this->_view->family_filtro = $familyModel->getList("$f1","");

    //clases filtrados
    $f1=" (1=0 ";
    foreach($selectedFamily as $value){
      if($value->code!=""){
        $f1.=" OR family_code='".$value->code."' ";
      }
    }
    $f1.=" ) ";    
    $this->_view->class_filtro = $classModel->getList("$f1",""); 

    //productos filtrados
    $f1=" (1=0 ";
    foreach($selectedClass as $value){
      if($value->code!=""){
        $f1.=" OR class_code='".$value->code."' ";
      }
    }
    $f1.=" ) ";    
    $this->_view->product_filtro = $productModel->getList("$f1","");        


  }

  public function addinterestAction(){
    header('Content-Type: application/json; charset=utf-8');
    $this->setLayout('blanco');
    $valores = $this->_getSanitizedParam("valores");
    $nivel = $this->_getSanitizedParam("nivel");
    $client_id = $this->_getSanitizedParam("client_id");

    $interestModel = new Administracion_Model_DbTable_Clientinterests();

    $array_valores = explode(",",$valores);
    foreach($array_valores as $value){
      if($value!=""){
        $aux2 = explode("_",$value);
        $data['client_id'] = $client_id;
        $data['code'] = $aux2[0];
        $data['name'] = $aux2[1];
        $data['level'] = $nivel;
        $interestModel->insert($data);     
      }
    }

    
    $seleccionados = '';
    $selectedItems = $interestModel->getList("client_id='$client_id' AND level='$nivel' ");
    foreach($selectedItems as $interest){
      $seleccionados.='<span class="badge rounded-pill text-dark border-2 border-info interest1 me-1 mb-2 interest'.$interest->id.'">'.$interest->name.' <i class="fa fa-times" onclick="removeInterest('.$interest->id.')"></i></span>';
    }

    $res['seleccionados']=$seleccionados;
    echo json_encode($res);

  }

  public function removeinterestAction(){
    $this->setLayout('blanco');
    $id = $this->_getSanitizedParam("id");

    $interestModel = new Administracion_Model_DbTable_Clientinterests();
    if($id>0){
      $interestModel->deleteRegister($id);
    }

  }  


  public function additemAction(){
    $this->setLayout('blanco');
    $buscador = $this->_getSanitizedParam("buscador"); 
    $aux = explode("_",$buscador);
    $nivel = $aux[0];
    $codigo = $aux[1];

    $interestModel = new Administracion_Model_DbTable_Clientinterests();
    $sectorsModel= new Administracion_Model_DbTable_Commercialsectors();
    $segmentsModel= new Administracion_Model_DbTable_Commercialsegments();
    $familyModel= new Administracion_Model_DbTable_Commercialfamilies();
    $classModel= new Administracion_Model_DbTable_Commercialclasses();
    $productModel= new Administracion_Model_DbTable_Commercialproducts();

    //print_r($_POST);

    if($nivel==1){
      $sector = $sectorsModel->getById($codigo);
      $data['client_id'] = $_SESSION['client']->id;
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $interestModel->insert($data);       
    }
    if($nivel==2){
      $segmento = $segmentsModel->getList(" segment_code='$codigo' ","")[0];
      $data['client_id'] = $_SESSION['client']->id;
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $interestModel->insert($data);  

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $interestModel->insert($data);             
    }
    if($nivel==3){

      $familia = $familyModel->getList(" family_code='$codigo' ","")[0];
      $data['client_id'] = $_SESSION['client']->id;
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $interestModel->insert($data);       

      $segment_code = $familia->segment_code;
      $segmento = $segmentsModel->getList(" segment_code='$segment_code' ","")[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $interestModel->insert($data);  

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $interestModel->insert($data);             
    }

    if($nivel==4){

      $clase = $classModel->getList(" class_code='$codigo' ","")[0];
      $data['client_id'] = $_SESSION['client']->id;
      $data['code'] = $clase->class_code;
      $data['name'] = $clase->class_name;
      $data['level'] = 4;
      $interestModel->insert($data);   

      $family_code = $clase->family_code;
      $familia = $familyModel->getList(" family_code='$family_code' ","")[0];
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $interestModel->insert($data);       

      $segment_code = $familia->segment_code;
      $segmento = $segmentsModel->getList(" segment_code='$segment_code' ","")[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $interestModel->insert($data);  

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $interestModel->insert($data);             
    } 

    if($nivel==5){

      $producto = $productModel->getList(" product_code='$codigo' ","")[0];
      $data['client_id'] = $_SESSION['client']->id;
      $data['code'] = $producto->product_code;
      $data['name'] = $producto->product_name;
      $data['level'] = 5;
      $interestModel->insert($data);

      $class_code = $producto->class_code;
      $clase = $classModel->getList(" class_code='$class_code' ","")[0];
      $data['code'] = $clase->class_code;
      $data['name'] = $clase->class_name;
      $data['level'] = 4;
      $interestModel->insert($data);   

      $family_code = $clase->family_code;
      $familia = $familyModel->getList(" family_code='$family_code' ","")[0];
      $data['code'] = $familia->family_code;
      $data['name'] = $familia->family_name;
      $data['level'] = 3;
      $interestModel->insert($data);       

      $segment_code = $familia->segment_code;
      $segmento = $segmentsModel->getList(" segment_code='$segment_code' ","")[0];
      $data['code'] = $segmento->segment_code;
      $data['name'] = $segmento->segment_name;
      $data['level'] = 2;
      $interestModel->insert($data);  

      $sector = $sectorsModel->getById($segmento->sector_id);
      $data['code'] = $sector->id;
      $data['name'] = $sector->name;
      $data['level'] = 1;
      $interestModel->insert($data);           
    }        


    header("Location:/page/profile/?tab=2");

  }


  public function saveAction(){
    error_reporting(E_ERROR);
    $this->setLayout('blanco');
    $data = $this->getData();
    $clientModel = new Page_Model_DbTable_Clients();
    $client_id = $_SESSION['client']->id;

    $errors = [];
    if (empty($data['nit'])) {
      $errors['nit'] = 'El documento es obligatorio';
    } else {
      $exist = $clientModel->getList("nit = '" . $data['nit'] . "' AND id!='$client_id' ", "");
      if ($exist) {
        $errors['nit'] = 'El documento ya existe';
      }
    }

    if (empty($data['email'])) {
      $errors['email'] = 'El correo personal es obligatorio';
    } else {
      $exist = $clientModel->getList("email = '" . $data['email'] . "' AND id!='$client_id' ", "");
      if ($exist) {
        $errors['email'] = 'El correo personal ya existe';
      }
    } 

    if (empty($data['bussinesEmail'])) {
      $errors['bussinesEmail'] = 'El correo corporativo es obligatorio';
    } else {
      $exist = $clientModel->getList("bussinesEmail = '" . $data['bussinesEmail'] . "' AND id!='$client_id'", "");
      if ($exist) {
        $errors['bussinesEmail'] = 'El correo corporativo ya existe';
      }
    }

    if (empty($data['company_nit'])) {
      $errors['company_nit'] = 'El documento de la empresa es obligatorio';
    } else {
      $exist = $clientModel->getList("company_nit = '" . $data['company_nit'] . "' AND id!='$client_id'", "");
      if ($exist) {
        $errors['company_nit'] = 'El documento de la empresa ya existe';
      }
    }


    if (empty($data['company'])) {
      $errors['company'] = 'El nombre de la empresa es obligatorio';
    } else {
      $exist = $clientModel->getList("company = '" . $data['company'] . "' AND id!='$client_id'", "");
      if ($exist) {
        $errors['company'] = 'El nombre de la empresa ya existe';
      }
    }            

    // Si hay errores, devuelvo de una vez
    if (is_countable($errors) && count($errors) > 0) {
      $errorList = '<ul style="text-align:left; margin:0; padding-left:20px;">';
      foreach ($errors as $msg) {
        // escapa cualquier carácter especial
        $errorList .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
      }
      $errorList .= '</ul>';
      echo json_encode([
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'html' => $errorList,
        'text' => 'Error al guardar el registro.',
        'data' => $data,

      ]);
      exit;
    }

    
    $clientModel->editField($client_id,"name",$data['name']);
    $clientModel->editField($client_id,"lastname",$data['lastname']);
    $clientModel->editField($client_id,"whatsapp",$data['whatsapp']);
    $clientModel->editField($client_id,"phone",$data['phone']);
    $clientModel->editField($client_id,"country",$data['country']);
    $clientModel->editField($client_id,"state",$data['state']);
    $clientModel->editField($client_id,"city",$data['city']);
    $clientModel->editField($client_id,"company",$data['company']);
    $clientModel->editField($client_id,"industry_id",$data['industry_id']);
    $clientModel->editField($client_id,"company_country",$data['company_country']);
    $clientModel->editField($client_id,"company_state",$data['company_state']);
    $clientModel->editField($client_id,"company_city",$data['company_city']);
    $clientModel->editField($client_id,"position",$data['position']);
    $clientModel->editField($client_id,"area",$data['area']);
    $clientModel->editField($client_id,"updated_at",date("Y-m-d H:i:s"));

    if($client_id>0){

      echo json_encode([
        'success' => true,
        'title' => 'Éxito',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Registro guardado exitosamente',
        //'redirect' => '/page/profile'
      ]);
      exit;

    }else{
      //error
    }

  }


  public function getData(){

    $data = array();
    $data['documentType'] = $this->_getSanitizedParam("documentType");
    $data['nit'] = $this->_getSanitizedParam("nit");
    $data['name'] = $this->_getSanitizedParam("name");
    $data['lastname'] = $this->_getSanitizedParam("lastname");
    $data['email'] = $this->_getSanitizedParam("email");
    $data['bussinesEmail'] = $this->_getSanitizedParam("bussinesEmail");
    $data['whatsapp'] = $this->_getSanitizedParam("whatsapp");
    $data['phone'] = $this->_getSanitizedParam("phone");
    $data['city'] = $this->_getSanitizedParam("city");
    $data['company'] = $this->_getSanitizedParam("company");
    $data['position'] = $this->_getSanitizedParam("position");
    $data['area'] = $this->_getSanitizedParam("area");
    $data['country'] = $this->_getSanitizedParam("country");
    $data['state'] = $this->_getSanitizedParam("state");
    $data['password'] = $this->_getSanitizedParam("password");
    $data['phoneCode'] = $this->_getSanitizedParam("phoneCode");
    $data['industry_id'] = $this->_getSanitizedParam("industry_id");
    $data['nit_type'] = $this->_getSanitizedParam("nit_type");
    $data['company_nit'] = $this->_getSanitizedParam("company_nit");
    $data['company_country'] = $this->_getSanitizedParam("company_country");
    $data['company_city'] = $this->_getSanitizedParam("company_city");
    $data['company_state'] = $this->_getSanitizedParam("company_state");

    if($data['whatsapp']==""){
      $data['whatsapp']=0;
    }
    if($data['phone']==""){
      $data['phone']=0;
    }    

    return $data;

  }


  public function save_documentsAction(){
    error_reporting(E_ERROR);
    $this->setLayout('blanco');
    $clientModel = new Page_Model_DbTable_Clients();
    $client_id = $_SESSION['client']->id;

    $content = $clientModel->getById($client_id);
    
    $uploadDocument =  new Core_Model_Upload_Document();
    if($_FILES['rut']['name'] != ''){
      if($content->rut){
        $uploadDocument->delete($content->rut);
      }
      $data['rut'] = $uploadDocument->upload("rut");
    } else {
      $data['rut'] = $content->rut;
    }
    $clientModel->editField($client_id,"rut",$data['rut']);

    if($_FILES['commerce']['name'] != ''){
      if($content->commerce){
        $uploadDocument->delete($content->commerce);
      }
      $data['commerce'] = $uploadDocument->upload("commerce");
    } else {
      $data['commerce'] = $content->commerce;
    }
    $clientModel->editField($client_id,"commerce",$data['commerce']);


      echo json_encode([
        'success' => true,
        'title' => 'Éxito',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Documentos guardados',
        'rut' => $data['rut'],
        'commerce' => $data['commerce'],
        //'redirect' => '/page/profile'
      ]);
      exit;

  }


  public function change_passwordAction(){
    error_reporting(E_ERROR);
    $this->setLayout('blanco');
    $clientModel = new Page_Model_DbTable_Clients();
    $client_id = $_SESSION['client']->id;

    $password = $this->_getSanitizedParam("password");
    $confirmPassword = $this->_getSanitizedParam("confirmPassword");
    
    $errors = [];    
    if($password==""){
      $errors['password'] = 'La contraseña es obligatoria';
    }
    if($confirmPassword==""){
      $errors['confirmPassword'] = 'Debe confirmar la contraseña';
    }
    if($password!=$confirmPassword){
      $errors['confirmPassword2'] = 'Las contraseñas no son iguales';
    }

    // Si hay errores, devuelvo de una vez
    if (is_countable($errors) && count($errors) > 0) {
      $errorList = '<ul style="text-align:left; margin:0; padding-left:20px;">';
      foreach ($errors as $msg) {
        // escapa cualquier carácter especial
        $errorList .= '<li>' . htmlspecialchars($msg, ENT_QUOTES, 'UTF-8') . '</li>';
      }
      $errorList .= '</ul>';
      echo json_encode([
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'html' => $errorList,
        'text' => 'Error al guardar el registro.',
        'data' => $data,

      ]);
      exit;
    }
      
      $password_codificado = password_hash($password, PASSWORD_DEFAULT);
      $clientModel->editField($client_id,"password",$password_codificado);

      echo json_encode([
        'success' => true,
        'title' => 'Éxito',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Contraseña actualizada'
      ]);
      exit;    


  }


}
