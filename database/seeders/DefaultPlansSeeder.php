<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Plan;
use App\Models\Feature;

class DefaultPlansSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Bronze',
                'price' => 19.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    ['name' => 'Patients limit', 'value' => '200'],
                    ['name' => 'Storage', 'value' => '1 GB'],
                    ['name' => 'Appointment scheduling', 'value' => 'Yes'],
                    ['name' => 'Basic analytics', 'value' => 'Yes'],
                ]
            ],
            [
                'name' => 'Silver',
                'price' => 49.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    ['name' => 'Patients limit', 'value' => 'Unlimited'],
                    ['name' => 'Storage', 'value' => '10 GB'],
                    ['name' => 'Appointment scheduling', 'value' => 'Yes'],
                    ['name' => 'Advanced analytics', 'value' => 'Yes'],
                    ['name' => 'Prescription & billing', 'value' => 'Yes'],
                    ['name' => 'Multi-user roles', 'value' => 'Yes'],
                    ['name' => 'Priority support', 'value' => 'Yes'],
                ]
            ],
            [
                'name' => 'Gold',
                'price' => 99.99,
                'billing_cycle' => 'monthly',
                'features' => [
                    ['name' => 'Patients limit', 'value' => 'Unlimited'],
                    ['name' => 'Storage', 'value' => 'Unlimited'],
                    ['name' => 'Appointment scheduling', 'value' => 'Yes'],
                    ['name' => 'Advanced analytics', 'value' => 'Yes'],
                    ['name' => 'Prescription & billing', 'value' => 'Yes'],
                    ['name' => 'Multi-user roles', 'value' => 'Yes'],
                    ['name' => 'Custom branding & domain', 'value' => 'Yes'],
                    ['name' => 'API access', 'value' => 'Yes'],
                    ['name' => 'Advanced security & compliance', 'value' => 'Yes'],
                    ['name' => 'AI-based patient insights', 'value' => 'Yes'],
                    ['name' => 'Dedicated account manager', 'value' => 'Yes'],
                    ['name' => '24/7 support', 'value' => 'Yes'],
                ]
            ],
        ];

        foreach ($plans as $planData) {
            $plan = Plan::create([
                'name' => $planData['name'],
                'price' => $planData['price'],
                'billing_cycle' => $planData['billing_cycle']
            ]);

            foreach ($planData['features'] as $feature) {
                Feature::create([
                    'plan_id' => $plan->id,
                    'name' => $feature['name'],
                    'value' => $feature['value']
                ]);
            }
        }
    }
}
