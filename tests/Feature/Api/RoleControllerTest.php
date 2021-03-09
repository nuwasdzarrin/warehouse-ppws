<?php

namespace Tests\Feature\Api;

use App\Role;
use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RoleControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        if (!Route::has('api.roles.index')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $roles = factory(Role::class, 5)->create();

        $response = $this->getJson(route('api.roles.index')."?search=lorem");
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return void
     */
    public function testStore()
    {
        if (!Route::has('api.roles.store')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');
        $response = $this->postJson(route('api.roles.store'), factory(Role::class)->make()->toArray());
        if ($response->exception) {
            $this->expectOutputString('');
            if ($response->status() == 422)
                $this->setOutputCallback(function () use($response) { return json_encode(json_decode($response->content(), true)['errors'], JSON_PRETTY_PRINT); });
            else $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }

    /**
     * Display the specified resource.
     *
     * @return void
     */
    public function testShow()
    {
        if (!Route::has('api.roles.show')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $role = factory(Role::class)->create();

        $response = $this->getJson(route('api.roles.show', [ $role->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return void
     */
    public function testUpdate()
    {
        if (!Route::has('api.roles.update')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $role = factory(Role::class)->create();

        $response = $this->putJson(route('api.roles.update', [ $role->getKey() ]), factory(Role::class)->make()->toArray());
        if ($response->exception) {
            $this->expectOutputString('');
            if ($response->status() == 422)
                $this->setOutputCallback(function () use($response) { return json_encode(json_decode($response->content(), true)['errors'], JSON_PRETTY_PRINT); });
            else $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return void
     */
    public function testDestroy()
    {
        if (!Route::has('api.roles.destroy')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $role = factory(Role::class)->create();

        $response = $this->deleteJson(route('api.roles.destroy', [ $role->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }
}
