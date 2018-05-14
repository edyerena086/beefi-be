<?php

namespace Tests\Unit\Front\ClientPromotion;

use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StoreTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'client/promotions/store';

    public function test_send_no_data()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422);
    }

    public function test_send_no_icon()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'icono' => [
	    			'El campo icono es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_end_date()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'fechaDeExpiracion' => [
	    			'El campo fecha de expiracion es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_end_date_format()
    {
    	$response = $this->json('POST', $this->url, ['fechaDeExpiracion' => '000']);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'fechaDeExpiracion' => [
	    			'El campo fecha de expiracion no es una fecha válida.'
	    		]
    		]);
    }

    public function test_send_no_end_date_after_today()
    {
    	$response = $this->json('POST', $this->url, ['fechaDeExpiracion' => '2018-03-19']);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'fechaDeExpiracion' => [
	    			'El campo fecha de expiracion debe ser una fecha posterior a hoy.'
	    		]
    		]);
    }

    public function test_send_no_promotion_text()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'textoDePromocion' => [
	    			'El campo texto de promocion es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_total_cupons()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'numeroDeCupones' => [
	    			'El campo numero de cupones es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_gender()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'genero' => [
	    			'El campo genero es obligatorio.'
	    		]
    		]);
    }

    /*public function test_send_no_gender_correct()
    {
    	$response = $this->json('POST', $this->url, ['genero' => 4]);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'genero' => [
	    			'El campo genero no existe.'
	    		]
    		]);
    }*/

    public function test_send_no_total_tables()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'numeroDeMesas' => [
	    			'El campo numero de mesas es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_url()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'url' => [
	    			'El campo url es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_bwallet()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'bwallet' => [
	    			'El campo bwallet es obligatorio.'
	    		]
    		]);
    }

    public function test_store_success()
    {
    	$data = [
    		'icono' => UploadedFile::fake()->image('avatar.jpg'),
    		'fechaDeExpiracion' => '2018-04-13',
    		'textoDePromocion' => 'Esta es una prueba',
    		'numeroDeCupones' => 10,
    		'genero' => 3,
    		'numeroDeMesas' => 10,
    		'url' => 'http://metodika.com.mx',
    		'bwallet' => 2
    	];

    	$response = $this->json('POST', $this->url, $data);

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
