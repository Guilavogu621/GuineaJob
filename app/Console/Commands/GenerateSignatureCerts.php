<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SignatureService;

class GenerateSignatureCerts extends Command
{
    protected $signature = 'guineajob:generate-certs';
    protected $description = 'Génère les certificats RSA pour la signature électronique des contrats';

    public function handle(SignatureService $signatureService)
    {
        $this->info('Génération des certificats en cours...');
        
        try {
            $signatureService->generateCertificates();
            $this->info('Succès : Les certificats ont été générés dans storage/app/certs/');
        } catch (\Exception $e) {
            $this->error('Erreur : ' . $e->getMessage());
        }
    }
}
