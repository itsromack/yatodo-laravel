<?php

use Illuminate\Database\Seeder;

use App\Task;
use App\User;
use Faker\Generator as Faker;

class TasksSeeder extends Seeder
{
    protected $faker;

    public function __construct(Faker $faker)
    {
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 0;
        while ($i++ < 10)
        {
            $item = $this->faker->sentence;
            $random_id = rand(1, User::count());
            $user = User::find($random_id);
            Task::createTask(
                $user->getId(),
                $item,
                $this->faker->date,
                rand(0, 1)
            );
        }
    }
}
