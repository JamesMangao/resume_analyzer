<?php

namespace App\Services;

use PhpOffice\PhpWord\PhpWord;

class ResumeDocxService
{
    public static function generate(string $markdown): PhpWord
    {
        $phpWord = new PhpWord();

        $section = $phpWord->addSection([
            'marginTop' => 900,
            'marginBottom' => 900,
            'marginLeft' => 900,
            'marginRight' => 900,
        ]);

        foreach (explode("\n", $markdown) as $line) {
            $line = trim($line);

            if (str_starts_with($line, '## ')) {
                $section->addText(
                    substr($line, 3),
                    ['bold' => true, 'size' => 14],
                    ['spaceBefore' => 300, 'spaceAfter' => 200]
                );
            } elseif (str_starts_with($line, '- ')) {
                $section->addListItem(
                    substr($line, 2),
                    0,
                    ['size' => 11],
                    'bullet'
                );
            } elseif ($line !== '') {
                $section->addText($line, ['size' => 11]);
            }
        }

        return $phpWord;
    }
}
