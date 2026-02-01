<?php

namespace App\Services;

use App\Models\SubmissionFile;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use PhpOffice\PhpWord\IOFactory;

class TextExtractionService
{
    /**
     * Extract text from a submission file.
     */
    public function extractText(SubmissionFile $file): ?string
    {
        // Explicitly use the 'public' disk root if that's where files are stored
        $path = public_path('uploads/' . $file->file_path);

        // Fallback for dev environments or different disk configs
        if (!file_exists($path)) {
            $path = Storage::path($file->file_path);
        }

        if (!file_exists($path)) {
            \Log::error('Text extraction failed: File not found at ' . $path);
            return null;
        }

        try {
            $mimeType = $file->mime_type;
            $extension = strtolower(pathinfo($file->original_name, PATHINFO_EXTENSION));

            \Log::info("Attempting extraction for: {$file->original_name} (MIME: {$mimeType}, Ext: {$extension})");

            // Handle PDF
            if ($mimeType === 'application/pdf' || $extension === 'pdf') {
                return $this->extractFromPdf($path);
            }

            // Handle Word
            if (
                in_array($mimeType, [
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/msword',
                    'application/octet-stream' // Fallback for some doc files
                ]) || in_array($extension, ['doc', 'docx'])
            ) {
                return $this->extractFromWord($path);
            }

            // Handle Plain Text
            if ($mimeType === 'text/plain' || $extension === 'txt') {
                return file_get_contents($path);
            }

            \Log::warning("Unsupported file type for extraction: {$mimeType} / {$extension}");
            return null;
        } catch (\Exception $e) {
            \Log::error('Text extraction failed: ' . $e->getMessage(), [
                'file' => $file->original_name,
                'path' => $path,
                'trace' => $e->getTraceAsString()
            ]);
            return null;
        }
    }

    private function extractFromPdf(string $path): string
    {
        $parser = new Parser();
        $pdf = $parser->parseFile($path);
        return $pdf->getText();
    }

    private function extractFromWord(string $path): string
    {
        $phpWord = null;

        try {
            // Try automatic detection first
            $phpWord = IOFactory::load($path);
        } catch (\Exception $e) {
            \Log::warning("Default Word loader failed for {$path}, trying alternative readers: " . $e->getMessage());

            // If it's a binary .doc file, IOFactory::load might fail if it's not a ZIP (DOCX)
            // Try MsDoc reader specifically for legacy binary formats
            try {
                $reader = IOFactory::createReader('MsDoc');
                if ($reader->canRead($path)) {
                    $phpWord = $reader->load($path);
                }
            } catch (\Exception $msDocError) {
                \Log::warning("MsDoc reader also failed: " . $msDocError->getMessage());
            }

            // If still null, try RTF (sometimes RTFs are renamed to .doc)
            if (!$phpWord) {
                try {
                    $reader = IOFactory::createReader('RTF');
                    if ($reader->canRead($path)) {
                        $phpWord = $reader->load($path);
                    }
                } catch (\Exception $rtfError) {
                    \Log::warning("RTF reader failed: " . $rtfError->getMessage());
                }
            }
        }

        if (!$phpWord) {
            throw new \Exception("Could not identify Word document format for extraction.");
        }

        $content = '';
        foreach ($phpWord->getSections() as $section) {
            foreach ($section->getElements() as $element) {
                if (method_exists($element, 'getText')) {
                    $content .= $element->getText() . "\n";
                } elseif (method_exists($element, 'getElements')) {
                    // Handle nested elements (like tables or cells)
                    foreach ($element->getElements() as $child) {
                        if (method_exists($child, 'getText')) {
                            $content .= $child->getText() . " ";
                        }
                    }
                    $content .= "\n";
                }
            }
        }
        return $content;
    }
}
