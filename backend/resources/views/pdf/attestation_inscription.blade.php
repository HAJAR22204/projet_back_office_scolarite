<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1a5276;
            padding-bottom: 15px;
            margin-bottom: 30px;
        }
        .header .universite {
            font-size: 13px;
            font-weight: bold;
            color: #1a5276;
            text-transform: uppercase;
        }
        .header .faculte {
            font-size: 15px;
            font-weight: bold;
            color: #1a5276;
            text-transform: uppercase;
            margin-top: 5px;
        }
        .header .ville {
            font-size: 11px;
            color: #666;
            margin-top: 3px;
        }
        .titre {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 30px 0;
            color: #1a5276;
        }
        .contenu {
            line-height: 2;
            text-align: justify;
            margin: 20px 40px;
            font-size: 13px;
        }
        .contenu .info {
            font-weight: bold;
            color: #1a5276;
        }
        .footer {
            margin-top: 60px;
            text-align: right;
            margin-right: 40px;
        }
        .footer .date {
            font-size: 12px;
            margin-bottom: 10px;
        }
        .footer .signature {
            font-size: 12px;
            font-weight: bold;
        }
        .cachet {
            margin-top: 80px;
            text-align: center;
            color: #999;
            font-size: 10px;
            border-top: 1px solid #ddd;
            padding-top: 10px;
        }
        .numero {
            text-align: right;
            font-size: 11px;
            color: #666;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="universite">Université Cadi Ayyad</div>
        <div class="faculte">Faculté des Sciences et Techniques</div>
        <div class="ville">Marrakech</div>
    </div>

    <div class="numero">
        N° : {{ $demande->id }}/FST/{{ date('Y') }}
    </div>

    <div class="titre">Attestation d'Inscription</div>

    

</body>
</html>