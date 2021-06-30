<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Route;
use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProductImportExcelControllerTest extends TestCase
{
    /**
     * Invoke single action controller.
     *
     * @return void
     */
    public function test()
    {
        if (!Route::has('product_import_excel')) { $this->expectNotToPerformAssertions(); return; }
        $user = factory(User::class)->create();

        $this->actingAs($user);
        $response = $this->get(route('product_import_excel'));
        if ($response->exception) {
            $this->expectOutputString('');
            $this->setOutputCallback(function () use($response) { return $response->exception; });
            return;
        }
        $response->assertViewIs('product_import_excel');
    }
}
