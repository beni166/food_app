<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanOldInvoices extends Command
{
    protected $signature = 'invoices:clean';
    protected $description = 'Supprime les anciennes factures PDF de plus de 1 heure';

    public function handle()
    {
        $files = Storage::files('public/factures');

        foreach ($files as $file) {
            if (Storage::lastModified($file) < now()->subHours(1)->timestamp) {
                Storage::delete($file);
                $this->info("Supprimé : $file");
            }
        }

        $this->info('Nettoyage terminé.');
    }
}
