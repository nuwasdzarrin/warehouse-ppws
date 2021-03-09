<?php

namespace Tests\Feature\Api;

use App\Institution;
use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InstitutionControllerTest extends TestCase
{
    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function testIndex()
    {
        if (!Route::has('api.institutions.index')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $institutions = factory(Institution::class, 5)->create();

        $response = $this->getJson(route('api.institutions.index')."?search=lorem");
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
        if (!Route::has('api.institutions.store')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');
        $response = $this->postJson(route('api.institutions.store'), factory(Institution::class)->make()->toArray());
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
        if (!Route::has('api.institutions.show')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $institution = factory(Institution::class)->create();

        $response = $this->getJson(route('api.institutions.show', [ $institution->getKey() ]));
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
        if (!Route::has('api.institutions.update')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $institution = factory(Institution::class)->create();

        $response = $this->putJson(route('api.institutions.update', [ $institution->getKey() ]), factory(Institution::class)->make()->toArray());
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
        if (!Route::has('api.institutions.destroy')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user, 'api');

        $institution = factory(Institution::class)->create();

        $response = $this->deleteJson(route('api.institutions.destroy', [ $institution->getKey() ]));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertSuccessful();
    }
}
