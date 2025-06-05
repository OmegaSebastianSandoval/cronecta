 <div class="container mx-auto my-10">
   <div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-4">
     <!-- Logo -->
     <div class="text-center mb-6">
       <img src="https://cronecta.com/storage/images/cronecta.png" alt="Logo de Cronecta" class="mx-auto h-16">
     </div>
     <!-- Título -->
     <h1 class="text-2xl font-bold text-center text-gray-800 mb-3">Verificación Fallida</h1>

     <!-- Mensaje de error -->
     <p class="text-center text-red-500 mb-3">El código de verificación es inválido o ha expirado.</p>

     <!-- Botón de redirección -->
     <div class="mt-8 text-center">
       <?php if ($this->userId) { ?>
         <button id="reenviarOtp" class="btn-blue">
           Reenviar correo para la validación
         </button>
       <?php } else { ?>
         <a href="/page/register" class="btn-blue">
           Ir al registro
         </a>
       <?php } ?>
     </div>
   </div>
 </div>
 <script>
   document.getElementById('reenviarOtp').addEventListener('click', async function() {
     document.getElementById('reenviarOtp').innerText = 'Reenviando...';
     document.getElementById('reenviarOtp').disabled = true;
     const url = '/page/verifyemail/resendotp';
     const formData = new FormData();
     formData.append('userId', <?= json_encode($this->userId) ?>);
     formData.append('otpCode', <?= json_encode($this->otpCode) ?>);
     try {
       const resp = await fetch(url, {
         method: 'POST',
         body: formData
         // No pongas headers → fetch lo hace automáticamente para multipart/form-data
       });

       if (!resp.ok) throw new Error(`HTTP ${resp.status}`);

       const json = await resp.json();

       if (json.success) {
         showAlert({
           title: json.title || 'Correo reenviado',
           text: json.text || 'Se ha reenviado exitosamente el código de verificación.',
           icon: json.icon || 'success',
           confirmButtonText: "Continuar",
           redirect: json.redirect

         });
       } else {
         showAlert({
           title: json.title || 'Error',
           text: json.text || 'No se pudo reenviar el correo.',
           icon: json.icon || 'error',
           confirmButtonText: "Continuar",
           redirect: json.redirect


         });
       }
     } catch (error) {
       console.error('Error al reenviar OTP:', error);
       showAlert({
         title: 'Error de red',
         text: 'No fue posible conectar con el servidor.',
         icon: 'error'
       });
     }
   });
 </script>
 <style>
   header,
   footer {
     display: none !important;
   }

   .main-general {
     display: flex;
     align-items: center;
     margin: 0 !important;
   }
    body.swal2-height-auto {
     height: 100% !important;
   }
 </style>