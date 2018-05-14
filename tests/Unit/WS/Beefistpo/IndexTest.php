<?php

namespace Tests\Unit\WS\Beefistpo;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class IndexTest extends TestCase
{
	use WithoutMiddleware;
	use DatabaseMigrations;
	private $url = '/api/beefispot/';

	public function test_get_zero_beefispots()
	{
		$response = $this->json('POST', $this->url);

		$response
			->assertStatus(200)
			->assertJson([
				'hasData' => false
			]);
	}

	public function test_get_beefispots()
	{
		$beefispots = factory(\MetodikaTI\Beefispot::class, 3)->create();

		$response = $this->json('POST', $this->url);

		$response
			->assertStatus(200)
			->assertJson([
				'hasData' => true
			]);
	}
}
