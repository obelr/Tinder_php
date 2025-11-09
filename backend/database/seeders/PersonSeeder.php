<?php

namespace Database\Seeders;

use App\Models\Person;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    public function run(): void
    {
        Person::factory()
            ->count(40)
            ->sequence(
                ['name' => '에스더', 'age' => 30, 'pictures' => ['https://images.unsplash.com/photo-1544723795-3fb6469f5b39'], 'location' => 'Seoul'],
                ['name' => '지유', 'age' => 28, 'pictures' => ['https://images.unsplash.com/photo-1524504388940-b1c1722653e1'], 'location' => 'Busan'],
                ['name' => '민서', 'age' => 27, 'pictures' => ['https://images.unsplash.com/photo-1487412912498-0447578fcca8'], 'location' => 'Incheon'],
                ['name' => '수아', 'age' => 26, 'pictures' => ['https://images.unsplash.com/photo-1469334031218-e382a71b716b'], 'location' => 'Daegu'],
            )
            ->create();
    }
}
