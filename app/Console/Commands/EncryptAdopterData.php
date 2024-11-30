<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Child;
use Illuminate\Support\Facades\Crypt;


class EncryptAdopterData extends Command
{
    protected $signature = 'children:encrypt-data';
    protected $description = 'Encrypt adopter data for existing records';
    // ------------------------DELETE MUTATORS AND ACCESSORS BEFORE USING !!!! -------------------------------
    //
    //
    //
    //
    // -------------------------------------------------------------------------------------------------------
    public function handle()
    {
        $children = Child::all();

        foreach ($children as $child) {
            // Encrypt only if the data is not empty and not yet encrypted
            if (!self::isEncrypted($child->adopter_first_name) && !empty($child->adopter_first_name)) {
                $child->adopter_first_name = Crypt::encryptString($child->adopter_first_name);
            }

            if (!self::isEncrypted($child->adopter_last_name) && !empty($child->adopter_last_name)) {
                $child->adopter_last_name = Crypt::encryptString($child->adopter_last_name);
            }

            if (!self::isEncrypted($child->adopter_phone) && !empty($child->adopter_phone)) {
                $child->adopter_phone = Crypt::encryptString($child->adopter_phone);
            }

            if (!self::isEncrypted($child->adopter_email) && !empty($child->adopter_email)) {
                $child->adopter_email = Crypt::encryptString($child->adopter_email);
            }

            if (!self::isEncrypted($child->adopter_address) && !empty($child->adopter_address)) {
                $child->adopter_address = Crypt::encryptString($child->adopter_address);
            }

            // Save the record quietly to avoid updating timestamps unnecessarily
            $child->saveQuietly();

            // Log the encrypted record ID
            $this->info("Encrypted adopter ID: {$child->id}");
        }

        $this->info('Adopter data encrypted successfully!');
    }

    // Utility to check if data is already encrypted
    protected static function isEncrypted($data)
    {
        try {
            Crypt::decryptString($data);  // Try to decrypt the value
            return true;  // It is encrypted
        } catch (\Exception $e) {
            return false;  // It is not encrypted
        }
    }
}

