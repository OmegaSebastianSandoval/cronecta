<?php

/**
 *
 */

class Page_verifyemailController extends Page_mainController
{

  public function indexAction()
  {
    // $this->setLayout('blanco');

    $this->partialsNoUser();

    $userId = $this->decrypt($this->_getSanitizedParam("user"));
    $otpCode = $this->decrypt($this->_getSanitizedParam("otp"));
    /*     echo $userId;
    echo "<br>";
    echo $otpCode; */
    if (!$userId || !$otpCode) {
      $this->_view->contenido = $this->_view->getRoutPHP('modules/page/Views/verifyemail/fail1.php');
      return;
    }
    $clientModel = new Page_Model_DbTable_Clients();
    $otpsModel = new Administracion_Model_DbTable_Otps();
    $user = $clientModel->getById($userId);
    if (!$user || ($user->email_verified_at && $user->email_verified_at != '0000-00-00 00:00:00')) {
      $this->_view->contenido = $this->_view->getRoutPHP('modules/page/Views/verifyemail/fail2.php');

      return;
    }
    $otpExist = $otpsModel->getList("
    otp = '$otpCode' 
    AND user_id = '$user->id' ")[0];
    if (!$otpExist) {
      $this->_view->contenido = $this->_view->getRoutPHP('modules/page/Views/verifyemail/fail2.php');
      return;
    }



    $now = date('Y-m-d H:i:s');

    $otpData = $otpsModel->getList("
    otp = '$otpCode' 
    AND user_id = '$user->id' 
    AND user_type = '1' 
    AND ('$now' BETWEEN created_at AND expires_at)
  ")[0];


    //codigo vencido
    if (!$otpData) {
      $this->_view->userId = $userId;
      $this->_view->otpCode = $otpCode;

      $this->_view->contenido = $this->_view->getRoutPHP('modules/page/Views/verifyemail/fail3.php');
      return;
    }


    //validar

    $clientModel->editField($user->id, "email_verified_at", date("Y-m-d H:i:s"));


    // $otpsModel->editField($otpData->id, "updated_at", date("Y-m-d H:i:s"));
    $otpsUser = $otpsModel->getList("otp = '$otpCode' AND user_id = '$user->id'  AND user_type = '1'");
    foreach ($otpsUser  as  $value) {
      $otpsModel->deleteRegister($value->id);
    }
    $this->_view->contenido = $this->_view->getRoutPHP('modules/page/Views/verifyemail/success.php');
    return;
  }
  public function resendotpAction()
  {

    $userId = $this->_getSanitizedParam("userId");
    $otp = $this->_getSanitizedParam("otpCode");

    if (!$userId || !$otp) {
      $res = [
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro, datos incompletos, contacte con el administrador.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    }

    //Desactivar el otp anterior
    $otpsModel = new Administracion_Model_DbTable_Otps();
    $otpOld = $otpsModel->getList("otp = '$otp' AND user_id = '$userId' AND user_type='1'  ")[0];
    if (!$otpOld) {
      $res = [
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro, código no encontrado, contacte con el administrador.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    }
    // $otpsModel->editField($otpOld->id, "updated_at", date("Y-m-d H:i:s"));
    $otpsModel->deleteRegister($otpOld->id);


    $clientModel = new Page_Model_DbTable_Clients();
    $user = $clientModel->getById($userId);

    if (!$user) {
      $res = [
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro, usuario no encontrado, contacte con el administrador.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    }

    // Generar un OTP de 6 dígitos
    $otpCode = rand(100000, 999999);

    $otpData = [
      'user_id' => $user->id,
      'otp' => $otpCode,
      'user_type' => '1',
      'email' => $user->email,
      'created_at' => date('Y-m-d H:i:s'),
      'expires_at' => date('Y-m-d H:i:s', strtotime('+30 minutes')),
      'updated_at' => date('Y-m-d H:i:s'),
    ];
    $otpModel = new Administracion_Model_DbTable_Otps();
    $idOtp = $otpModel->insert($otpData);

    if (!$idOtp) {
      $res = [
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al guardar el registro, contacte con el administrador.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    }


    $otp = $otpModel->getById($idOtp);

    $otpEncrypted = $this->encrypt($otpCode);
    $userEncrypted = $this->encrypt($user->id);

    $ruta = RUTA_BUYER . "verifyemail?otp=$otpEncrypted&user=$userEncrypted";

    $mailModel = new Core_Model_Sendingemail($this->_view);
    $boolMail = $mailModel->sendOtp($user, $otp, $ruta);

    if ($boolMail == 1) {
      $res = [
        'title' => 'Éxito',
        'status' => 'success',
        'icon' => 'success',
        'text' => 'Correo enviado exitosamente.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    } else {
      $res = [
        'title' => 'Error',
        'status' => 'error',
        'icon' => 'error',
        'text' => 'Error al enviar el correo, contacte con el administrador.',
        'redirect' => '/supplier/login'
      ];
      echo json_encode($res);
      exit;
    }
  }
}
