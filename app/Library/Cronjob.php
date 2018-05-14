<?php

namespace MetodikaTI\Library;

use Carbon\Carbon;
use MetodikaTI\User;
use MetodikaTI\FinalUserPromotion;

class Cronjob
{
	public function sendPushReminder()
	{
		$allPromotions = FinalUserPromotion::where('end_date', '>', Carbon::now())->get();
	}
}