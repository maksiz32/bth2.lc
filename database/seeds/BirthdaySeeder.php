<?php
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Birthday;

class BirthdaySeeder extends Seeder
{
    public function run()
    {
        DB::statement("SET foreign_key_checks=0");
        Birthday::truncate();
        DB::statement("SET foreign_key_checks=1");
        factory(Birthday::class, 30)->create();
    }
}
