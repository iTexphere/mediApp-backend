<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->insert([
			'first_name'	=>	'Medical Center',
			'last_name'		=>	'Booking',
            'email'         =>  'medical@booking.com',
			'medi_track'	=>	'yes',
	    	'created_at'	=>  Carbon::now(),
	    	'updated_at'	=>  Carbon::now(),
    	]);
    }
}
