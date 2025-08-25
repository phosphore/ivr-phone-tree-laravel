<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;

class IvrControllerTest extends TestCase
{
    use WithoutMiddleware;

    public function test_welcome_contains_age_options()
    {
        $response = $this->post(route('welcome'));
        $response->assertSee('Vuole proseguire col percorso digitale');
    }

    public function test_age_option_one_leads_to_main_menu()
    {
        $response = $this->post(route('age-response'), ['Digits' => '1']);
        $response->assertSee('Ottima scelta');
    }

    public function test_main_menu_is_accessible()
    {
        $response = $this->post(route('main-menu'));
        $response->assertSee('Menu principale');
    }

    public function test_star_returns_to_main_menu()
    {
        $response = $this->post(route('main-response'), ['Digits' => '*']);
        $response->assertSee('Torna al menu principale');
        $response->assertSee('/ivr/main-menu');
    }
}
