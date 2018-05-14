<?php

namespace Tests\Unit\Sponsor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'dashboard/sponsor/delete';

    public function test_incorrect_sponsor_id()
    {
    	$response = $this->json('GET', $this->url.'/500');

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => false,
    			'message' => 'El sponsor ingresado no se encuentra en el sistema.'
    		]);
    }

    public function test_correct_sponsor_deleted()
    {
    	$spot = factory(\MetodikaTI\Sponsor::class)->create();

    	$response = $this->json('GET', $this->url.'/'.base64_encode($spot->id));

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
