<?php

use App\Doctor;
use App\Plan;
use App\Specialization;
use App\Star;
use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Carbon\Carbon;


class DoctorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $avatars = [
            'avatar/1.png',
            'avatar/2.png',
            'avatar/3.png',
            'avatar/4.png',
            'avatar/5.png',
            'avatar/6.png',
            'avatar/7.png',
            'avatar/8.png',
            'avatar/9.png',
            'avatar/10.png',
        ];
        $cvs = [
            'cv/1.pdf',
            'cv/2.pdf',
            'cv/3.pdf',
            'cv/4.pdf',
            'cv/5.pdf',
            'cv/6.pdf',
        ];



        $faker = \Faker\Factory::create('it_IT');

        $users = User::all();
        $stars = Star::all()->pluck('id');
        $specializations = Specialization::all()->pluck('id');
        $plans = Plan::all()->pluck('id');


        foreach ($users as $user) {

            $doctor = new Doctor();
            $doctor->user_id = $user->id;

            $doctor->name = $faker->firstName();
            $doctor->surname = $faker->lastName();
            $doctor->address = $faker->address();
            $doctor->services = $faker->paragraphs(rand(10, 20), true);
            $doctor->photo = $faker->randomElement($avatars);
            $doctor->cv = $faker->randomElement($cvs);
            $doctor->telephone = $faker->phoneNumber();

            $fullName = $doctor->name . ' ' . $doctor->surname;
            $doctor->slug = Str::slug($fullName);

            $doctor->save();

            $starIds = $stars->shuffle()->all();
            $doctor->stars()->sync($starIds);

            $specializationIds = $specializations->shuffle()->take(rand(1, 2))->all();
            $doctor->specializations()->sync($specializationIds);

            //plans
            // $plansArr = Plan::all();
            // $currentDateTime = Carbon::now();
            

            // foreach ($plansArr as $value) {
            //     if ($value->id === 1) {
            //         $newDateTime = Carbon::now()->addHour(24);
            //     } elseif ($value->id === 2) {
            //         $newDateTime = Carbon::now()->addHour(72);
            //     } elseif ($value->id === 3) {
            //         $newDateTime = Carbon::now()->addHour(144);
            //     }
            // }

            // $planArray = Plan::all();
            // foreach ($planArray as $value ) {
            //     $duration = $value->duration;
            // }


        // $planIds = $plans->shuffle()->take(rand(0, 5))->all();
        //     $doctor->plans()->attach($planIds, [
        //         'starting_date' => $currentDateTime,
        //         'expiration_date' => $newDateTime,

        //     ]);
        $sponsorType= rand(1,3);


                switch ($sponsorType) {
                    case 1:
                        $planId['plan_id'] = '1';
                        $startDate = Carbon::now();
                        $expireDate= Carbon::now()->addHour(24);
                        break;
                    case 2:
                        $planId['plan_id'] = '2';
                        $startDate = Carbon::now();
                        $expireDate= Carbon::now()->addHour(72);
                        break;
                    case 3:
                        $planId['plan_id'] = '3';
                        $startDate = Carbon::now();
                        $expireDate= Carbon::now()->addHour(144);
                        break;
                }
                $planId = $plans->shuffle()->take(rand(0, 5))->all();
                $doctor->plans()->attach($planId['plan_id'],  [
                    'starting_date' => $startDate,
                    'expiration_date' => $expireDate]);
        }
    }
}
