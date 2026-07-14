<?php

namespace App\Support;

class RwandaLocations
{
    public static function provinces(): array
    {
        return [
            'Kigali City' => 'Kigali City',
            'Northern' => 'Northern',
            'Southern' => 'Southern',
            'Eastern' => 'Eastern',
            'Western' => 'Western',
        ];
    }

    public static function districts(): array
    {
        return [
            'Kigali City' => [
                'Gasabo' => 'Gasabo',
                'Kicukiro' => 'Kicukiro',
                'Nyarugenge' => 'Nyarugenge',
            ],
            'Northern' => [
                'Musanze' => 'Musanze',
                'Gicumbi' => 'Gicumbi',
                'Burera' => 'Burera',
                'Rulindo' => 'Rulindo',
                'Gakenke' => 'Gakenke',
            ],
            'Southern' => [
                'Huye' => 'Huye',
                'Muhanga' => 'Muhanga',
                'Nyanza' => 'Nyanza',
                'Gisagara' => 'Gisagara',
                'Nyamagabe' => 'Nyamagabe',
                'Nyaruguru' => 'Nyaruguru',
                'Kamonyi' => 'Kamonyi',
            ],
            'Eastern' => [
                'Rwamagana' => 'Rwamagana',
                'Kayonza' => 'Kayonza',
                'Ngoma' => 'Ngoma',
                'Kirehe' => 'Kirehe',
                'Bugesera' => 'Bugesera',
                'Nyagatare' => 'Nyagatare',
                'Gatsibo' => 'Gatsibo',
            ],
            'Western' => [
                'Rubavu' => 'Rubavu',
                'Rusizi' => 'Rusizi',
                'Nyamasheke' => 'Nyamasheke',
                'Karongi' => 'Karongi',
                'Rutsiro' => 'Rutsiro',
                'Ngororero' => 'Ngororero',
                'Nyabihu' => 'Nyabihu',
            ],
        ];
    }

    public static function districtsFor(?string $province): array
    {
        if ($province === null) {
            return [];
        }

        return self::districts()[$province] ?? [];
    }
}
