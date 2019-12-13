<?php

namespace Rorymcdaniel\Anonymizer\Console\Commands;

use Illuminate\Console\Command;
use Faker\Generator as Faker;

class AnonymizeUsers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'anonymize:users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Replaces real users email and names with fake email and names';
    /**
     * @var Faker
     */
    private $faker;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Faker $faker)
    {
        parent::__construct();
        $this->faker = $faker;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn("This command will modify your database. Be sure you have a backup!");
        if(!$this->confirm("Are you sure you wish to continue?")){
            return false;
        }
        $bar = $this->output->createProgressBar(User::count());
        $bar->start();
        foreach(User::all() as $user){
            $email = $this->faker->unique()->email;
            $hash = md5($email);
            $user->first_name = $this->faker->firstName;
            $user->last_name = $this->faker->lastName;
            $user->email = $email;
            $user->thumbnail_url = "http://www.gravatar.com/avatar/$hash?d=monsterid&f=y";
            $user->save();
            $bar->advance();
        }
        $bar->finish();
    }
}
