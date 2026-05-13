<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Demande;
use App\Services\ApogeeService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use App\Services\PdfService;
use App\Mail\DocumentPretMail;
use App\Mail\DemandeRefuseeMail;
use Illuminate\Support\Facades\Mail;

class DemandeController extends Controller
{
    protected $apogeeService;
    protected $pdfService;

    public function __construct(ApogeeService $apogeeService, PdfService $pdfService)
    {
        $this->apogeeService = $apogeeService;
        $this->pdfService = $pdfService;
    }

    public function index(Request $request)
    {
        $query = Demande::with(['traitePar', 'document']);

        if ($request->has('statut')) {
            $query->where('statut', $request->statut);
        }

        if ($request->has('type_document')) {
            $query->where('type_document', $request->type_document);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'like', "%{$search}%")
                  ->orWhere('prenom', 'like', "%{$search}%")
                  ->orWhere('cne', 'like', "%{$search}%")
                  ->orWhere('code_apogee', 'like', "%{$search}%");
            });
        }

        if ($request->has('date_debut') && $request->has('date_fin')) {
            $query->whereBetween('date_creation', [
                $request->date_debut,
                $request->date_fin
            ]);
        }

        $demandes = $query->orderBy('date_creation', 'desc')->paginate(10);

        return response()->json($demandes, 200);
    }

    public function store(Request $request)
    {
       $validator = Validator::make($request->all(), [
        'cne' => 'required|string',
        'code_apogee' => 'required|integer',
        'nom' => 'required|string|max:255',
        'prenom' => 'required|string|max:255',
        'email' => 'required|email|max:100',
        'type_document' => 'required|in:attestation_inscription,certificat_scolarite,releve_notes,diplome_deust,retrait_bac',
        'semestre' => 'required_if:type_document,releve_notes|integer|in:1,2,3,4|nullable',
        'type_retrait' => 'required_if:type_document,retrait_bac|in:temporaire,definitif|nullable',
        'commentaire' => 'nullable|string|max:1000',
    ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $demande = Demande::create([
            'cne' => $request->cne,
            'code_apogee' => $request->code_apogee,
            'nom' => $request->nom,
            'prenom' => $request->prenom,
            'email' => $request->email,
            'date_creation' => Carbon::now(),
            'statut' => 'en_attente',
            'type_document' => $request->type_document,
            'semestre' => $request->semestre,
            'type_retrait' => $request->type_retrait,
            'commentaire' => $request->commentaire,
        ]);

        $demande->load(['traitePar', 'document']);

        return response()->json([
            'message' => 'Demande créée avec succès',
            'demande' => $demande
        ], 201);
    }

    public function show($id)
    {
        $demande = Demande::with(['traitePar', 'document'])->find($id);

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        return response()->json($demande, 200);
    }

    public function valider(Request $request, $id)
{
    $demande = Demande::find($id);

    if (!$demande) {
        return response()->json(['message' => 'Demande non trouvée'], 404);
    }

    if ($demande->statut !== 'en_attente' && $demande->statut !== 'en_cours') {
        return response()->json(['message' => 'Cette demande ne peut pas être validée'], 400);
    }

    $etudiantApogee = $this->apogeeService->verifierEtudiant(
        $demande->cne,
        $demande->code_apogee,
        $demande->nom,
        $demande->prenom
    );

    if (!$etudiantApogee) {
        $demande->update([
            'statut' => 'refusee',
            'date_traitement' => Carbon::now(),
            'traite_par' => $request->user()->id,
            'motif_refus' => 'Informations incorrectes. Vérifiez votre CNE, code Apogée, nom et prénom.',
        ]);

        Mail::to($demande->email)->send(new DemandeRefuseeMail($demande));

        return response()->json([
            'message' => 'Étudiant non trouvé dans Apogée. Email de refus envoyé.',
            'demande' => $demande
        ], 404);
    }

    $demande->update([
        'statut' => 'prete',
        'date_traitement' => Carbon::now(),
        'traite_par' => $request->user()->id,
    ]);

    if ($demande->type_document !== 'retrait_bac') {
        $this->pdfService->genererDocument($demande);
    }

    Mail::to($demande->email)->send(new DocumentPretMail($demande));

    $demande->load(['traitePar', 'document']);

    return response()->json([
        'message' => 'Demande validée. Document prêt. Email envoyé.',
        'demande' => $demande
    ], 200);
}

    public function refuser(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'motif_refus' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $demande = Demande::find($id);

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        if ($demande->statut !== 'en_attente' && $demande->statut !== 'en_cours') {
            return response()->json(['message' => 'Cette demande ne peut pas être refusée'], 400);
        }

        $demande->update([
            'statut' => 'refusee',
            'date_traitement' => Carbon::now(),
            'traite_par' => $request->user()->id,
            'motif_refus' => $request->motif_refus,
        ]);

        $demande->load(['traitePar', 'document']);

        return response()->json([
            'message' => 'Demande refusée',
            'demande' => $demande
        ], 200);
    }

    public function mettreEnCours(Request $request, $id)
    {
        $demande = Demande::find($id);

        if (!$demande) {
            return response()->json(['message' => 'Demande non trouvée'], 404);
        }

        if ($demande->statut !== 'en_attente') {
            return response()->json(['message' => 'Seules les demandes en attente peuvent être mises en cours'], 400);
        }

        $demande->update([
            'statut' => 'en_cours',
            'traite_par' => $request->user()->id,
        ]);

        $demande->load(['traitePar', 'document']);

        return response()->json([
            'message' => 'Demande mise en cours de traitement',
            'demande' => $demande
        ], 200);
    }

    public function statistiques()
    {
        $stats = [
            'total' => Demande::count(),
            'en_attente' => Demande::where('statut', 'en_attente')->count(),
            'en_cours' => Demande::where('statut', 'en_cours')->count(),
            'prete' => Demande::where('statut', 'prete')->count(),
            'refusee' => Demande::where('statut', 'refusee')->count(),
            'par_type' => [
                'attestation_inscription' => Demande::where('type_document', 'attestation_inscription')->count(),
                'certificat_scolarite' => Demande::where('type_document', 'certificat_scolarite')->count(),
                'releve_notes' => Demande::where('type_document', 'releve_notes')->count(),
                'diplome_deust' => Demande::where('type_document', 'diplome_deust')->count(),
                'retrait_bac' => Demande::where('type_document', 'retrait_bac')->count(),
            ],
        ];

        return response()->json($stats, 200);
    }
}