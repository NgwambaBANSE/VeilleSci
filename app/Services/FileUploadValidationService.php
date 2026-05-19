<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Validation\ValidationException;

/**
 * Service de Validation des Uploads de Fichiers
 * 
 * Sécurise les uploads en:
 * - Validant le type MIME réel (pas juste l'extension)
 * - Vérifiant les dimensions des images
 * - Scannant les malwares potentiels
 * - Limitant les tailles
 */
class FileUploadValidationService
{
    /**
     * Types MIME autorisés par catégorie
     */
    private const ALLOWED_MIMES = [
        'image' => ['image/jpeg', 'image/png', 'image/webp'],
        'document' => ['application/pdf'],
        'csv' => ['text/csv', 'text/plain'],
    ];

    /**
     * Tailles maximales en bytes
     */
    private const MAX_SIZES = [
        'image' => 2048 * 1024,      // 2MB
        'document' => 5120 * 1024,   // 5MB
        'csv' => 10240 * 1024,       // 10MB
    ];

    /**
     * Résolutions minimales pour les images
     */
    private const MIN_DIMENSIONS = [
        'image' => ['width' => 100, 'height' => 100],
    ];

    /**
     * Valider un upload d'image de profil
     */
    public static function validateProfilePhoto(UploadedFile $file): bool
    {
        return self::validateFile($file, 'image', [
            'min_width' => 100,
            'min_height' => 100,
            'max_width' => 4000,
            'max_height' => 4000,
        ]);
    }

    /**
     * Valider un upload de CV (PDF)
     */
    public static function validateCV(UploadedFile $file): bool
    {
        return self::validateFile($file, 'document');
    }

    /**
     * Valider un fichier général
     */
    public static function validateFile(
        UploadedFile $file,
        string $category,
        array $options = []
    ): bool {
        // 1. Vérifier que la catégorie est autorisée
        if (!isset(self::ALLOWED_MIMES[$category])) {
            throw ValidationException::withMessages([
                'file' => "Catégorie de fichier '$category' non autorisée.",
            ]);
        }

        // 2. Vérifier le type MIME réel (pas juste l'extension)
        $mimeType = $file->getMimeType();
        if (!in_array($mimeType, self::ALLOWED_MIMES[$category])) {
            throw ValidationException::withMessages([
                'file' => "Type MIME non autorisé: {$mimeType}. "
                        . "Autorisés: " . implode(', ', self::ALLOWED_MIMES[$category]),
            ]);
        }

        // 3. Vérifier la taille maximale
        $maxSize = self::MAX_SIZES[$category];
        if ($file->getSize() > $maxSize) {
            throw ValidationException::withMessages([
                'file' => "Fichier trop volumineux. "
                        . "Max: " . self::formatBytes($maxSize) 
                        . ", Reçu: " . self::formatBytes($file->getSize()),
            ]);
        }

        // 4. Vérifier les dimensions pour les images
        if ($category === 'image' && isset($options['min_width'])) {
            $dimensions = getimagesize($file->getPathname());
            if ($dimensions === false) {
                throw ValidationException::withMessages([
                    'file' => "Impossible de lire les dimensions de l'image. "
                            . "Le fichier peut être corrompu.",
                ]);
            }

            [$width, $height] = $dimensions;

            if (isset($options['min_width']) && $width < $options['min_width']) {
                throw ValidationException::withMessages([
                    'file' => "Largeur d'image insuffisante. "
                            . "Min: {$options['min_width']}px, Reçu: {$width}px",
                ]);
            }

            if (isset($options['min_height']) && $height < $options['min_height']) {
                throw ValidationException::withMessages([
                    'file' => "Hauteur d'image insuffisante. "
                            . "Min: {$options['min_height']}px, Reçu: {$height}px",
                ]);
            }

            if (isset($options['max_width']) && $width > $options['max_width']) {
                throw ValidationException::withMessages([
                    'file' => "Largeur d'image trop grande. "
                            . "Max: {$options['max_width']}px, Reçu: {$width}px",
                ]);
            }

            if (isset($options['max_height']) && $height > $options['max_height']) {
                throw ValidationException::withMessages([
                    'file' => "Hauteur d'image trop grande. "
                            . "Max: {$options['max_height']}px, Reçu: {$height}px",
                ]);
            }
        }

        // 5. Vérifier les signatures de fichiers (magic numbers)
        if (!self::verifyFileSignature($file, $category)) {
            throw ValidationException::withMessages([
                'file' => "Le fichier n'est pas un véritable " 
                        . ucfirst($category) . " ou il est corrompu.",
            ]);
        }

        // 6. Scanner les malwares potentiels
        if (self::detectMalware($file)) {
            throw ValidationException::withMessages([
                'file' => "Fichier suspect détecté. L'upload a été bloqué pour des raisons de sécurité.",
            ]);
        }

        return true;
    }

    /**
     * Vérifier la signature du fichier (magic numbers)
     */
    private static function verifyFileSignature(UploadedFile $file, string $category): bool
    {
        $path = $file->getPathname();
        $handle = fopen($path, 'rb');
        if (!$handle) {
            return false;
        }

        $bytes = fread($handle, 12);
        fclose($handle);

        // Vérifier les signatures selon la catégorie
        if ($category === 'image') {
            return self::verifyImageSignature($bytes);
        } elseif ($category === 'document') {
            return self::verifyPdfSignature($bytes);
        }

        return true;
    }

    /**
     * Vérifier la signature d'une image
     */
    private static function verifyImageSignature(string $bytes): bool
    {
        $hex = bin2hex($bytes);

        // PNG: 89504e47
        if (strpos($hex, '89504e47') === 0) {
            return true;
        }

        // JPEG: FFD8FF
        if (strpos($hex, 'ffd8ff') === 0) {
            return true;
        }

        // WebP: RIFF...WEBP
        if (strpos($hex, '52494646') === 0 && strpos($hex, '57454250') > 0) {
            return true;
        }

        return false;
    }

    /**
     * Vérifier la signature d'un PDF
     */
    private static function verifyPdfSignature(string $bytes): bool
    {
        // PDF: 25504446 (%PDF)
        return strpos(bin2hex($bytes), '25504446') === 0;
    }

    /**
     * Détecter les malwares potentiels
     */
    private static function detectMalware(UploadedFile $file): bool
    {
        $content = file_get_contents($file->getPathname());

        // Pattern dangereux pour les images
        $dangerousPatterns = [
            '<?php', '<?=', 'shell_exec', 'system(',
            'exec(', 'passthru(', 'eval(', 'base64_decode',
            'gzuncompress', 'gzinflate', 'gzdecode',
        ];

        foreach ($dangerousPatterns as $pattern) {
            if (stripos($content, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Formater les bytes en unité lisible
     */
    private static function formatBytes(int $bytes): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= 1 << (10 * $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
