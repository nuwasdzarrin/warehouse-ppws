<?php

namespace Tests\Feature;

use App\TransactionStatus;
use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TransactionStatusControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        if (!Route::has('transaction_statuses.index')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $transaction_statuses = factory(TransactionStatus::class, 5)->create();

        $response = $this->get(route('transaction_statuses.index')."?search=lorem");
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('transaction_statuses.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function testCreate()
    {
        if (!Route::has('transaction_statuses.create')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('transaction_statuses.create'));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('transaction_statuses.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        if (!Route::has('transaction_statuses.store')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->post(route('transaction_statuses.store'), factory(TransactionStatus::class)->make()->toArray());
        if (($errors = session()->get('errors')) && !$errors->isEmpty()) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response, $errors) { return json_encode($errors->toArray(), JSON_PRETTY_PRINT); });
            return;
        }
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testShow()
    {
        if (!Route::has('transaction_statuses.show')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $transaction_status = factory(TransactionStatus::class)->create();

        $response = $this->get(route('transaction_statuses.show', [ $transaction_status->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('transaction_statuses.show');
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testEdit()
    {
        if (!Route::has('transaction_statuses.edit')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $transaction_status = factory(TransactionStatus::class)->create();

        $response = $this->get(route('transaction_statuses.edit', [ $transaction_status->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('transaction_statuses.edit');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        if (!Route::has('transaction_statuses.update')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $transaction_status = factory(TransactionStatus::class)->create();

        $response = $this->put(route('transaction_statuses.update', [ $transaction_status->getKey() ]), factory(TransactionStatus::class)->make()->toArray());
        if (($errors = session()->get('errors')) && !$errors->isEmpty()) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response, $errors) { return json_encode($errors->toArray(), JSON_PRETTY_PRINT); });
            return;
        }
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     * @throws \Exception
     */
    public function testDestroy()
    {
        if (!Route::has('transaction_statuses.destroy')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);

        $transaction_status = factory(TransactionStatus::class)->create();

        $response = $this->delete(route('transaction_statuses.destroy', [ $transaction_status->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSessionMissing('errors');
        $response->assertStatus(302);
    }
}
