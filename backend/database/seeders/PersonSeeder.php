<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        $photoSet = [
            'https://images.unsplash.com/photo-1524504388940-b1c1722653e1?q=80&w=1887&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=1887&auto=format&fit=crop',
            'https://images.unsplash.com/photo-1524503033411-c9566986fc8f?q=80&w=1887&auto=format&fit=crop',
        ];

        Person::factory()
            ->count(40)
            ->sequence(
                ['name' => '에스더', 'age' => 30, 'pictures' => $photoSet, 'location' => 'Seoul'],
                ['name' => '지유', 'age' => 28, 'pictures' => $photoSet, 'location' => 'Busan'],
                ['name' => '민서', 'age' => 27, 'pictures' => $photoSet, 'location' => 'Incheon'],
                ['name' => '수아', 'age' => 26, 'pictures' => $photoSet, 'location' => 'Daegu'],
            )
            ->create();
    }
}
