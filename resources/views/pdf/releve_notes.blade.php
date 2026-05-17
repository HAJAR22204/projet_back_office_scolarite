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
        .titre {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-decoration: underline;
            text-transform: uppercase;
            margin: 20px 0;
            color: #1a5276;
        }
        .infos-etudiant {
            background-color: #f2f3f4;
            padding: 15px;
            margin: 20px 0;
            border-left: 4px solid #1a5276;
        }
        .infos-etudiant p {
            margin: 5px 0;
        }
        .info {
            font-weight: bold;
            color: #1a5276;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        table thead {
            background-color: #1a5276;
            color: white;
        }
        table thead th {
            padding: 10px;
            text-align: left;
            font-size: 12px;
        }
        table tbody tr:nth-child(even) {
            background-color: #f2f3f4;
        }
        table tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
            font-size: 12px;
        }
        .moyenne-box {
            background-color: #1a5276;
            color: white;
            padding: 10px 20px;
            text-align: right;
            font-weight: bold;
            font-size: 14px;
            margin-top: 10px;
        }
        .resultat {
            text-align: center;
            font-size: 14px;
            font-weight: bold;
            margin-top: 15px;
            padding: 10px;
        }
        .valide {
            color: green;
            border: 2px solid green;
        }
        .non-valide {
            color: red;
            border: 2px solid red;
        }
        .footer {
            margin-top: 40px;
            text-align: right;
        }
        .cachet {
            margin-top: 60px;
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

    <div class="titre">Relevé de Notes - Semestre {{ $demande->semestre }}</div>

    

</body>
</html>