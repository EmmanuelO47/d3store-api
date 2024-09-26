<?php

namespace Database\Seeders;
use App\Models\States;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;


class StatesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        States::truncate();
        $states = [
            ["id"=>Str::uuid(), "code"=>"FC","name"=>"Federal Capital Territory","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"AB","name"=>"Abia","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"AD","name"=>"Adamawa", "created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"AK","name"=>"Akwa Ibom", "created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"AN","name"=>"Anambra","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"BA","name"=>"Bauchi","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"BY","name"=>"Bayelsa","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"BE","name"=>"Benue","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"CR","name"=>"Cross River","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"DE","name"=>"Delta","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"EB","name"=>"Ebonyi","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"ED","name"=>"Edo","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"EK","name"=>"Ekiti","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"EN","name"=>"Enugu","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"GO","name"=>"Gombe","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"IM","name"=>"Imo","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"JI","name"=>"Jigawa","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KD","name"=>"Kaduna","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KN","name"=>"Kano","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KA","name"=>"Katsina","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KE","name"=>"Kebbi","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KO","name"=>"Kogi","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"KW","name"=>"Kwara","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"LA","name"=>"Lagos","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"NA","name"=>"Nassarawa","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"NI","name"=>"Niger","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"OG","name"=>"Ogun","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"ON","name"=>"Ondo","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"OS","name"=>"Osun","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"OY","name"=>"Oyo","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"PL","name"=>"Plateau","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"RI","name"=>"Rivers","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"SO","name"=>"Sokoto","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"TA","name"=>"Taraba","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"YO","name"=>"Yobe","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
            ["id"=>Str::uuid(),"code"=>"ZA","name"=>"Zamfara","created_at" => Carbon::now()->format('Y-m-d H:i:s'),"updated_at" => Carbon::now()->format('Y-m-d H:i:s')],
        ];
        States::insert($states);
    }
}
