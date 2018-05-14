<?php

namespace Tests\Unit\Sponsor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UpdateTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'dashboard/sponsor/update';

    public function test_send_no_data()
    {
    	$response = $this->json('POST', $this->url.'/500');

    	$response
    		->assertStatus(422);
    }

    public function test_send_no_company_name()
    {
    	$response = $this->json('POST', $this->url.'/500');

    	$response
    		->assertStatus(422)
    		->assertJson([
    			'empresa' => [
	    			'El campo empresa es obligatorio.'
	    		]
    		]);
    }

    public function test_sponsor_success_no_image()
    {
    	$spot = factory(\MetodikaTI\Sponsor::class)->create();

    	$data = [
    		'empresa' => 'MetodikaTI'
    	];

    	$response = $this->json('POST', $this->url.'/'.base64_encode($spot->id), $data);

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }

    public function test_sponsor_success_with_image()
    {
    	$spot = factory(\MetodikaTI\Sponsor::class)->create();

    	$data = [
    		'empresa' => 'MetodikaTI',
    		'imagen' => UploadedFile::fake()->image('avatar.jpg')
    	];

    	$response = $this->json('POST', $this->url.'/'.base64_encode($spot->id), $data);

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
