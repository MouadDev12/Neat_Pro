<?php

namespace Database\Seeders;

use App\Models\AppNotification;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class DashboardSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        // Products
        $categories = ['Electronics', 'Clothing', 'Books', 'Home & Garden', 'Sports'];
        foreach (range(1, 20) as $i) {
            Product::create([
                'name'        => $faker->words(3, true),
                'description' => $faker->sentence(),
                'price'       => $faker->randomFloat(2, 10, 500),
                'stock'       => $faker->numberBetween(0, 200),
                'category'    => $faker->randomElement($categories),
                'active'      => $faker->boolean(80),
            ]);
        }

        // Customers
        $countries = ['USA', 'France', 'Germany', 'UK', 'Canada', 'Morocco', 'Spain'];
        foreach (range(1, 30) as $i) {
            Customer::create([
                'name'        => $faker->name(),
                'email'       => $faker->unique()->safeEmail(),
                'phone'       => $faker->phoneNumber(),
                'company'     => $faker->company(),
                'country'     => $faker->randomElement($countries),
                'status'      => $faker->randomElement(['active', 'inactive', 'lead']),
                'total_spent' => $faker->randomFloat(2, 0, 10000),
            ]);
        }

        // Orders & Transactions
        $customers = Customer::all();
        $statuses  = ['pending', 'processing', 'shipped', 'delivered', 'cancelled'];
        $methods   = ['card', 'paypal', 'bank'];

        foreach (range(1, 50) as $i) {
            $customer = $customers->random();
            $total    = $faker->randomFloat(2, 20, 2000);

            $order = Order::create([
                'order_number' => 'ORD-' . strtoupper($faker->unique()->bothify('??####')),
                'customer_id'  => $customer->id,
                'total'        => $total,
                'status'       => $faker->randomElement($statuses),
                'created_at'   => $faker->dateTimeBetween('-12 months', 'now'),
            ]);

            Transaction::create([
                'reference'   => 'TXN-' . strtoupper($faker->unique()->bothify('??######')),
                'order_id'    => $order->id,
                'customer_id' => $customer->id,
                'amount'      => $total,
                'type'        => 'credit',
                'status'      => $order->status === 'delivered' ? 'completed' : $faker->randomElement(['pending', 'completed', 'failed']),
                'method'      => $faker->randomElement($methods),
                'created_at'  => $order->created_at,
            ]);
        }

        // Notifications for admin
        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $notifTypes = [
                ['title' => 'New Order Received', 'message' => 'Order #ORD-001 has been placed.', 'type' => 'info'],
                ['title' => 'Payment Confirmed', 'message' => 'Transaction TXN-001 completed.', 'type' => 'success'],
                ['title' => 'Low Stock Alert', 'message' => 'Product "Widget Pro" is running low.', 'type' => 'warning'],
                ['title' => 'Failed Transaction', 'message' => 'Transaction TXN-002 failed.', 'type' => 'danger'],
                ['title' => 'New Customer', 'message' => 'A new customer registered.', 'type' => 'info'],
            ];
            foreach ($notifTypes as $n) {
                AppNotification::create(array_merge($n, ['user_id' => $admin->id]));
            }
        }
    }
}
