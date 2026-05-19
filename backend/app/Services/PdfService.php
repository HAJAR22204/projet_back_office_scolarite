<?php

namespace App\Services;

use App\Models\Demande;
use App\Models\DocumentDemande;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class PdfService
{
    protected $apogeeService;

    public function __construct(ApogeeService $apogeeService)
    {
        $this->apogeeService = $apogeeService;
    }

    public function genererDocument(Demande $demande)
    {
        $etudiant = $this->apogeeService->getInfosEtudiant($demande->code_apogee);
        $filiere = $this->apogeeService->getFiliere($etudiant->FILIERE_CODE);
        $annee_universitaire = $this->apogeeService->getAnneeUniversitaireActuelle();

        switch ($demande->type_document) {
            case 'attestation_inscription':
                return $this->genererAttestationInscription($demande, $etudiant, $filiere, $annee_universitaire);

            case 'certificat_scolarite':
                return $this->genererCertificatScolarite($demande, $etudiant, $filiere, $annee_universitaire);

            case 'releve_notes':
                return $this->genererReleveNotes($demande, $etudiant, $filiere, $annee_universitaire);

            case 'diplome_deust':
                return $this->genererDiplomeDeust($demande, $etudiant, $filiere);

            default:
                return null;
        }
    }

    private function genererAttestationInscription($demande, $etudiant, $filiere, $annee_universitaire)
    {
        $pdf = Pdf::loadView('pdf.attestation_inscription', [
            'demande' => $demande,
            'etudiant' => $etudiant,
            'filiere' => $filiere,
            'annee_universitaire' => $annee_universitaire,
        ]);

        return $this->sauvegarderPdf($pdf, $demande, 'attestation_inscription');
    }

    private function genererCertificatScolarite($demande, $etudiant, $filiere, $annee_universitaire)
    {
        $pdf = Pdf::loadView('pdf.certificat_scolarite', [
            'demande' => $demande,
            'etudiant' => $etudiant,
            'filiere' => $filiere,
            'annee_universitaire' => $annee_universitaire,
        ]);

        return $this->sauvegarderPdf($pdf, $demande, 'certificat_scolarite');
    }

    private function genererReleveNotes($demande, $etudiant, $filiere, $annee_universitaire)
    {
        $notes = $this->apogeeService->getNotesParSemestre($demande->code_apogee, $demande->semestre);
        $moyenne = $this->apogeeService->getMoyenneSemestre($demande->code_apogee, $demande->semestre);

        $pdf = Pdf::loadView('pdf.releve_notes', [
            'demande' => $demande,
            'etudiant' => $etudiant,
            'filiere' => $filiere,
            'annee_universitaire' => $annee_universitaire,
            'notes' => $notes,
            'moyenne' => $moyenne,
        ]);

        return $this->sauvegarderPdf($pdf, $demande, 'releve_notes_s' . $demande->semestre);
    }

    private function genererDiplomeDeust($demande, $etudiant, $filiere)
    {
        $toutes_notes = $this->apogeeService->getToutesLesNotes($demande->code_apogee);
        $toutes_moyennes = $this->apogeeService->getToutesMoyennesSemestres($demande->code_apogee);
        $moyenne_generale = $this->apogeeService->getMoyenneGenerale($demande->code_apogee);
        $diplome = $this->apogeeService->getDiplome($demande->code_apogee);

        $notes_par_semestre = [];
        foreach ($toutes_notes as $note) {
            $notes_par_semestre[$note->SEMESTRE][] = $note;
        }

        $moyennes_semestres = [];
        foreach ($toutes_moyennes as $moyenne) {
            $moyennes_semestres[$moyenne->SEMESTRE] = $moyenne;
        }

        $pdf = Pdf::loadView('pdf.diplome_deust', [
            'demande' => $demande,
            'etudiant' => $etudiant,
            'filiere' => $filiere,
            'notes_par_semestre' => $notes_par_semestre,
            'moyennes_semestres' => $moyennes_semestres,
            'moyenne_generale' => $moyenne_generale,
            'diplome' => $diplome,
        ]);

        return $this->sauvegarderPdf($pdf, $demande, 'diplome_deust');
    }

    private function sauvegarderPdf($pdf, $demande, $type)
    {
        $nomFichier = $type . '_' . $demande->code_apogee . '_' . time() . '.pdf';
        $chemin = 'documents/' . $nomFichier;

        $pdf->save(storage_path('app/public/' . $chemin));

        $document = DocumentDemande::create([
            'demande_id' => $demande->id,
            'nom' => $nomFichier,
            'chemin_fichier' => $chemin,
            'date_generation' => Carbon::now(),
        ]);

        return $document;
    }
}