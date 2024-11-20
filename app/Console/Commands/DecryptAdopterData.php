<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Child;
use Illuminate\Support\Facades\Crypt;

class DecryptAdopterData extends Command
{
    protected $signature = 'children:decrypt-data';
    protected $description = 'Decrypt adopter data for existing records';

    public function handle()
    {
       $children = Child::all(); // Correctly fetch adopters

        foreach ($children as $child) {
            try {
                // Decrypt only if data exists
                if (!empty($child->adopter_first_name)) {
                    $child->adopter_first_name = Crypt::decryptString($child->adopter_first_name);
                }
                if (!empty($child->adopter_last_name)) {
                    $child->adopter_last_name = Crypt::decryptString($child->adopter_last_name);
                }
                if (!empty($child->adopter_phone)) {
                    $child->adopter_phone = Crypt::decryptString($child->adopter_phone);
                }
                if (!empty($child->adopter_email)) {
                    $child->adopter_email = Crypt::decryptString($child->adopter_email);
                }
                if (!empty($child->adopter_address)) {
                    $child->adopter_address = Crypt::decryptString($child->adopter_address);
                }

                $child->saveQuietly(); // Save changes without updating timestamps
                $this->info("Decrypted adopter ID: {$child->id}");
            } catch (\Exception $e) {
                // Log or display error for the specific record
                $this->error("Failed to decrypt adopter ID: {$child->id}. Error: {$e->getMessage()}");
            }
        }

        $this->info('Adopter data decryption completed successfully!');
    }
}
