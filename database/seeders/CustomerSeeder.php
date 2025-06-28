<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {           
        // You can also create specific customers
        Customer::create([
            'user_id' => 1, // Assuming user with ID 1 exists
            'name' => 'Griffin Armstrong',
            'email' => 'bill.dicki@example.com',
            'phone' => '123456789',
            'address' => '123 Main St, City',
        ]);
        
        Customer::create([
            'user_id' => 2, // Assuming user with ID 1 exists
            'name' => 'Otilia Hills',
            'email' => 'mccullough.dwight@example.com',
            'phone' => '123456789',
            'address' => '123 Main St, City',
        ]);
    }
}
