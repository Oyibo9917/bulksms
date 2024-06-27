<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BirthdayTemplatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'content' => 'May this birthday be filled with lots of happy hours and also your life with many happy birthdays, that are yet to come. Happy birthday.',
                'active' => 1,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'Wishing you a beautiful day with good health and happiness forever. Happy birthday!',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'May the days ahead of you be filled with prosperity, great health and above all joy in its truest and purest form. Happy birthday!',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'Special day, special person and special celebration. May all your dreams and desires come true. Happy birthday.',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'May this birthday be filled with lots of happy hours and also your life with many happy birthdays, that are yet to come. Happy birthday.',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'May this year be a breakthru year for you! We hope that all ur stars keep shining n your biggest dreams come true. HAPPY BIRTHDAY',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ],
            [
                'content' => 'We wish you good health and peace as you age. We hope that all ur stars keep shining  and your biggest dreams come true. HAPPY BIRTHDAY',
                'active' => 0,
                'type' => 'BIRTHDAY',
            ]
        ];

        // Insert data into the table
        DB::table('messages')->insert($data);
    }
}
