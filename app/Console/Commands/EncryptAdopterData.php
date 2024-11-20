<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Child;
use Illuminate\Support\Facades\Crypt;

class EncryptAdopterData extends Command
{
    protected $signature = 'children:encrypt-data';
    protected $description = 'Encrypt adopter data for existing records';

    public function handle()
    {
        $children = Child::all();

        foreach ($children as $child) {
            // Encrypt only if the data is not yet encrypted
            if (!self::isEncrypted($child->adopter_first_name)) {
                $child->adopter_first_name = Crypt::encryptString($child->adopter_first_name);
                $child->adopter_last_name = Crypt::encryptString($child->adopter_last_name);
                $child->adopter_phone = Crypt::encryptString($child->adopter_phone);
                $child->adopter_email = Crypt::encryptString($child->adopter_email);
                $child->adopter_address = Crypt::encryptString($child->adopter_address);
                $child->saveQuietly();  // Avoid updating timestamps if not needed
            }
            $this->info("Encrypted adopter ID: {$child->id}");
        }

        $this->info('Adopter data encrypted successfully!');
    }

    // Utility to check if data is already encrypted
    protected static function isEncrypted($data)
    {
        try {
            Crypt::decryptString($data);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}
