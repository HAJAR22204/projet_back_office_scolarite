<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #1a5276;
            color: white;
            padding: 30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 20px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 13px;
            opacity: 0.8;
        }
        .body {
            padding: 30px;
            color: #333;
        }
        .body p {
            line-height: 1.8;
            font-size: 14px;
        }
        .alert-success {
            background-color: #d4efdf;
            border-left: 4px solid #27ae60;
            padding: 15px;
            margin: 20px 0;
            border-radius: 4px;
        }
        .alert-success p {
            margin: 0;
            color: #1e8449;
            font-weight: bold;
        }
        .info-box {
            background-color: #f2f3f4;
            padding: 15px;
            border-radius: 4px;
            margin: 20px 0;
        }
        .info-box p {
            margin: 5px 0;
            font-size: 13px;
        }
        .info-box strong {
            color: #1a5276;
        }
        .footer {
            background-color: #f4f4f4;
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Université Cadi Ayyad</h1>
            <p>Faculté des Sciences et Techniques - Marrakech</p>
        </div>

        <div class="body">
            <p>Bonjour <strong>{{ $demande->prenom }} {{ $demande->nom }}</strong>,</p>

            <div class="alert-success">
                <p> Votre document est prêt à être récupéré !</p>
            </div>

            <p>Nous avons le plaisir de vous informer que votre demande de 
            <strong>{{ str_replace('_', ' ', $demande->type_document) }}</strong> 
            a été traitée avec succès.</p>

            

            <p>Vous pouvez récupérer votre document au guichet de la scolarité :</p>
            <p>
                 <strong>Faculté des Sciences et Techniques</strong><br>
                 <strong>Munissez-vous de votre carte d'étudiant</strong>
            </p>

            <p>Cordialement,<br>
            <strong>Service de Scolarité</strong><br>
            Faculté des Sciences et Techniques - Université Cadi Ayyad</p>
        </div>

        <div class="footer">
            Cet email a été envoyé automatiquement, merci de ne pas y répondre.
        </div>
    </div>
</body>
</html>