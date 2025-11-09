<?php

namespace App\Console\Commands;

use App\Mail\PopularPersonMail;
use App\Models\Person;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class CheckPopularPeople extends Command
{
    protected $signature = 'app:check-popular-people';

    protected $description = 'Notify the admin when a person reaches the like milestone';

    public function handle(): int
    {
        $threshold = (int) config('services.popular_people.threshold', 50);
        $adminEmail = config('mail.admin_address', 'admin@example.com');

        $popularPeople = Person::where('likes_count', '>=', $threshold)->get();

        if ($popularPeople->isEmpty()) {
            $this->info('No popular people found at this time.');

            return Command::SUCCESS;
        }

        foreach ($popularPeople as $person) {
            Mail::to($adminEmail)->send(new PopularPersonMail($person));
            $this->info(sprintf('Notification sent for %s (%d likes)', $person->name, $person->likes_count));
        }

        return Command::SUCCESS;
    }
}
