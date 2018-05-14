<?php

namespace Tests\Unit\Sponsor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class StoreTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'dashboard/sponsor/store';

    public function test_send_no_data()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422);
    }

    public function test_send_no_company_name()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'empresa' => [
	    			'El campo empresa es obligatorio.'
	    		]
    		]);
    }

    public function test_send_no_ad()
    {
    	$response = $this->json('POST', $this->url);

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'imagen' => [
	    			'El campo imagen es obligatorio.'
	    		]
    		]);
    }

    public function test_sponsor_success()
    {
    	$data = [
    		'empresa' => 'MetodikaTI',
    		'imagen' => UploadedFile::fake()->image('avatar.jpg')
    	];

    	$response = $this->json('POST', $this->url, $data);

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
