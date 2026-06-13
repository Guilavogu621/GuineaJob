<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Exception;

class SignatureService
{
    private string $privateKeyPath;
    private string $certPath;

    public function __construct()
    {
        $this->privateKeyPath = storage_path('app/certs/private-key.pem');
        $this->certPath = storage_path('app/certs/cert.pem');
    }

    /**
     * Générer les certificats de la plateforme (une seule fois)
     */
    public function generateCertificates(): void
    {
        if (file_exists($this->privateKeyPath)) {
            return;
        }

        $config = [
            "digest_alg" => "sha256",
            "private_key_bits" => 2048,
            "private_key_type" => OPENSSL_KEYTYPE_RSA,
        ];

        // Créer la clé privée
        $res = openssl_pkey_new($config);
        openssl_pkey_export($res, $privateKey);

        // Créer le certificat auto-signé
        $dn = [
            "countryName" => "GN",
            "stateOrProvinceName" => "Conakry",
            "localityName" => "Conakry",
            "organizationName" => "GuinéaJob",
            "organizationalUnitName" => "IT",
            "commonName" => "guineajob.com",
            "emailAddress" => "admin@guineajob.com"
        ];

        $csr = openssl_csr_new($dn, $res, array('digest_alg' => 'sha256'));
        $x509 = openssl_csr_sign($csr, null, $res, $days = 3650, array('digest_alg' => 'sha256'));
        openssl_x509_export($x509, $certout);

        // Sauvegarder
        file_put_contents($this->privateKeyPath, $privateKey);
        file_put_contents($this->certPath, $certout);
    }

    /**
     * Signer un document
     */
    public function signDocument(string $filePath): string
    {
        if (!file_exists($this->privateKeyPath)) {
            $this->generateCertificates();
        }

        // Récupérer le contenu du fichier (depuis le disque public ou local)
        $documentContent = Storage::disk('public')->get($filePath);
        
        // Calculer le hash
        $hash = hash('sha256', $documentContent, true);
        
        // Charger la clé privée
        $privateKey = openssl_pkey_get_private(file_get_contents($this->privateKeyPath));
        
        // Signer le hash
        openssl_sign($hash, $signature, $privateKey, OPENSSL_ALGO_SHA256);
        
        $signatureBase64 = base64_encode($signature);
        
        // Sauvegarder la signature dans un fichier détaché .sig
        $sigPath = 'contrats/signatures/' . basename($filePath) . '.sig';
        Storage::disk('public')->put($sigPath, json_encode([
            'signature' => $signatureBase64,
            'algorithm' => 'sha256WithRSAEncryption',
            'signed_at' => now()->toIso8601String(),
            'file_name' => basename($filePath),
            'signer' => 'GuinéaJob Platform'
        ]));
        
        return $signatureBase64;
    }

    /**
     * Vérifier l'intégrité d'un document
     */
    public function verifySignature(string $filePath, string $sigPath): bool
    {
        if (!Storage::disk('public')->exists($filePath) || !Storage::disk('public')->exists($sigPath)) {
            return false;
        }

        $documentContent = Storage::disk('public')->get($filePath);
        $sigData = json_decode(Storage::disk('public')->get($sigPath), true);
        
        $hash = hash('sha256', $documentContent, true);
        $signature = base64_decode($sigData['signature']);
        
        $publicKey = openssl_pkey_get_public(file_get_contents($this->certPath));
        
        return openssl_verify($hash, $signature, $publicKey, OPENSSL_ALGO_SHA256) === 1;
    }
}
