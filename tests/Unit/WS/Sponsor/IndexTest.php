<?php

namespace Tests\Unit\WS\Sponsor;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class IndexTest extends TestCase
{
    use WithoutMiddleware;
	use DatabaseMigrations;
	private $url = '/api/sponsor/';

	public function test_get_zero_sponsor()
	{
		$response = $this->json('POST', $this->url);

		$response
			->assertStatus(200)
			->assertJson([
				'hasData' => false
			]);
	}

	public function test_get_sponsor()
	{
		$beefispots = factory(\MetodikaTI\Sponsor::class)->create();

		$response = $this->json('POST', $this->url);

		$response
			->assertStatus(200)
			->assertJson([
				'hasData' => true
			]);
	}
}
