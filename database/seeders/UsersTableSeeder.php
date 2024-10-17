<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'is_admin' => true,
            'password' => bcrypt('admin'),
        ]);

        User::factory()->create([
            'name' => 'User',
            'email' => 'user@mail.com',
            'is_admin' => false,
            'password' => bcrypt('user'),
        ]);

        User::factory()->create([
            'name' => 'UserBlock',
            'email' => 'userblock@mail.com',
            'is_admin' => false,
            'is_active' => false,
            'password' => bcrypt('user'),
        ]);

        $users = User::factory()->count(20)->create();

        $events = Event::all();

        $users->each(function ($user) use ($events) {
            if ($events->count()) {
                $selectedEvents = $events->random(rand(1, 5));

                foreach ($selectedEvents as $event) {
                    $user->events()->attach($event->id, [
                        'created_at' => $event->event_date,
                        'updated_at' => $event->event_date,
                    ]);
                }
            }
        });


    }
}
