<?php

namespace Tests\Feature;

use App\Meal;
use App\Order;
use App\Enums\OrderStatus;
use App\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class OrderApiTest extends TestCase
{
    use DatabaseTransactions;

    /**
     * @test
     */
    public function can_get_all_orders()
    {
        $foods = ['Veggie Yam', 'Grilled Akara', 'Bacon Bread'];

        $data = [];

        foreach($foods as $food) {
            $order = factory(Order::class)->create([
                'cart' => json_encode([
                    factory(Meal::class)->make(['name' => $food])
                ])
            ]);

            array_push($data, $order);
        }

        $this->signIn();
        $response = $this->json('GET', route('apiV1.orders.index'));

        $response->assertOk();

        foreach ($data as $order) {
            $response->assertSee($order->user_id);
            $response->assertSee($order->total_amount);
            $response->assertSee($order->status);
            $response->assertSee($order->address);
        }
    }

    /**
     * @test
     */
    public function can_create_an_order()
    {
        $data = factory(Order::class)->make([
            'status' => OrderStatus::PENDING,
            'cart' => json_encode([
                factory(Meal::class)->make(['name' => 'Oyam'])
            ])
        ])->toArray();

        $user = $this->signIn('customer');
        $response = $this->json('POST', route('apiV1.orders.store'), $data);

        $response->assertOk()
                ->assertSee($data['status'])
                ->assertSee($data['address'])
                ->assertSee($user->id);

        $data['cart'] = json_encode($data['cart']);
        $data['user_id'] = $user->id;

        $this->assertDatabaseHas('orders', $data);
    }


    /**
     * @test
     */
    public function can_update_order_status()
    {
        $order = factory(Order::class)->create();
        $driver = factory(User::class)->create();
        $data = [
            'status' => OrderStatus::DELIVERED,
            'driver_id' => $driver->id
        ];

        $this->signIn();
        $response = $this->json('PUT', route('apiV1.orders.update', $order->id), $data);

        $response->assertOk()
                ->assertSee($data['status'])
                ->assertSee($data['driver_id']);

        $this->assertDatabaseHas('orders', [
            'id' => $order->id,
            'status' => OrderStatus::DELIVERED,
            'driver_id' => $driver->id
        ]);
    }

    /**
     * @test
     */
    public function an_order_can_be_deleted()
    {
        $data = factory(Order::class)->create();

        $this->signIn();
        $response = $this->json('DELETE', route('apiV1.orders.destroy', $data->id));

        $response->assertOk();
        $this->assertDatabaseMissing('orders', $data->toArray());
    }

}
