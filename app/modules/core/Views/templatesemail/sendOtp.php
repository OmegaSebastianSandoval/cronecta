<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verificar Cuenta</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            color: #333333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .content {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 1px solid #dddddd;
            border-radius: 5px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .logo {
            text-align: center;
            margin-bottom: 10px;
        }

        .logo img {
            max-width: 150px;
        }

        .header {
            background-color: #204697;
            /* Azul oscuro */
            color: #ffffff;
            padding: 10px;
            text-align: center;
            border-top-left-radius: 5px;
            border-top-right-radius: 5px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
        }

        .body {
            padding: 20px;
        }

        .body p {
            font-size: 16px;
            line-height: 1.5;
            color: #333333;
        }

        .button {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px;
            background-color: #377abe;
            /* Azul claro */
            color: #ffffff !important;
            text-align: center;
            text-decoration: none;
            border-radius: 5px;
            font-size: 18px;
        }

        .footer {
            text-align: center;
            padding: 10px;
            background-color: #f7f7f7;
            border-bottom-left-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .footer p {
            font-size: 12px;
            color: #999999;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="logo">
                <img src="https://cronecta.com/storage/images/cronecta.png" alt="Logo de Cronecta">
            </div>
            <div class="header">
                <h1>Verificar Cuenta</h1>
            </div>
            <div class="body">
                <p>Hola,</p>
                <p>Gracias por registrarte como <?= $this->type ?>. Para verificar tu correo electrónico y poder ingresar, haz clic en el siguiente enlace:</p>
                <a href="<?= $this->url ?>" class="button">Verificar mi cuenta</a>
                <p>Este enlace expirará en 30 minutos.</p>
                <p>Si no realizas la verificación de tu correo, tu registro será eliminado.</p>
            </div>
            <div class="footer">
                <p>Gracias,<br> Cronecta</p>
            </div>
        </div>
    </div>
</body>

</html>