<?php

namespace Tests\Unit\Beefispot;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StoreTest extends TestCase
{
	use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'dashboard/beefispot/store';

    public function test_send_no_data()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422);
    }

    public function test_send_no_title()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'titulo' => [
	    			'El campo titulo es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_description()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'descripcion' => [
	    			'El campo descripcion es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_latitud()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'latitud' => [
	    			'El campo latitud es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_longitud()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'longitud' => [
	    			'El campo longitud es obligatorio.'
	    		]
    		]);
    }

    public function test_create_new_beefispot()
    {
    	$data = [
    		'titulo' => 'Punto de prueba',
    		'descripcion' => 'Este es un texto de descripción',
    		'latitud' => 25.686613,
    		'longitud' => -100.316116
    	];

    	$response = $this->json('POST', $this->url, $data);

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
