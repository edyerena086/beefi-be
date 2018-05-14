<?php
/**
 * Created by PhpStorm.
 * User: Bruno1
 * Date: 06/04/2017
 * Time: 04:28 PM
 */

namespace MetodikaTI\Library;


class Pastora
{
    public static function passwordGenerator()
    {
        $password = "";

        for ($i = 1; $i <= 9; $i++) {
            switch (rand(1,3)) {
                case 1:
                    $password = $password.chr(rand(97, 122));
                    break;
                case 2:
                    $password = $password.rand(1, 9);
                    break;

                case 3:
                    $password = $password.chr(rand(65, 90));
                    break;
            }
        }

        return $password;
    }

}