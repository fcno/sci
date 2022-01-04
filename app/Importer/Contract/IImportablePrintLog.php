<?php

namespace App\Importer\Contract;

interface IImportablePrintLog
{
    /**
     * Importa os logs de impressão que estão no File System.
     */
    public function run(): void;
}
