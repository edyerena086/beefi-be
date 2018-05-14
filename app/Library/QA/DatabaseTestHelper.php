<?php

namespace MetodikaTI\Library\QA;

use MetodikaTI\User;
use MetodikaTI\Client;


class DatabaseTestHelper
{
    public static function cleanTableUserForClient($email)
    {
        $user = User::where('email', '=', $email)->first();

        if ($user != null) {
            //Remove client record
            $client = Client::where('user_id', '=', $user->id)->first();

            if ($client != null) {
                if ($client->delete()) {
                    $user->delete();
                }
            }
        }
    }
}