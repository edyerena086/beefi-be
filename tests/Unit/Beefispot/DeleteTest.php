<?php

namespace Tests\Unit\Beefispot;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class DeleteTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
    private $url = 'dashboard/beefispot/delete';

    public function test_incorrect_beefispot_id()
    {
    	$response = $this->json('GET', $this->url.'/500');

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => false,
    			'message' => 'El punto ingresado no se encuentra en el sistema.'
    		]);
    }

    public function test_correct_beefispot_deleted()
    {
    	$spot = factory(\MetodikaTI\Beefispot::class)->create();

    	$response = $this->json('GET', $this->url.'/'.base64_encode($spot->id));

    	$response
    		->assertStatus(200)
    		->assertJson([
    			'status' => true
    		]);
    }
}
