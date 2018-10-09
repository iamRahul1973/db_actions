<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 12-06-2017
 * Time: 16:52
 */

/**
 * This function receives the integer id to be passed to the
 * next page via url. it takes the id as an argument and
 * converts it into a string that may be not easy to hack... ;-) ;-)
 * [Oh ! that's what i think... ha ha ;-) ;-) ]
 *
 * the array $alphabet consists of capital and small alphabetical
 * numbers as elements. we use strtotime to generate dynamic number
 * and will add the passed id with it. Then the sum will be split into
 * 3 sub strings. Then we'll create a converted string that will mix
 * up the number and string generated from the $alphabet array.
 * So instead of passing the actual id, we will pass this string to
 * the destination...
 *
 * @param int $passValue
 * @return string
 */

function convertIntURL ($passValue)
{
    $alphabet = str_split("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz");
    shuffle($alphabet);

    $numToSandwich = strtotime("last monday");

    $target_array = array_rand($alphabet, 10);
    $sandwich = $passValue + $numToSandwich;

    $sandwichOne = substr($sandwich,0,3);
    $sandwichTwo = substr($sandwich,3,3);
    $sandwichThree = substr($sandwich,6);

    $convertedString = '';

    $i = 0;
    foreach ($target_array as $key)
    {
        $i++;
        $convertedString .= $alphabet[$key];
        if ($i == 3)
        {
            $convertedString .= $sandwichOne;
        }
        elseif ($i == 6)
        {
            $convertedString .= $sandwichTwo;
        }
        elseif ($i == 9)
        {
            $convertedString .= $sandwichThree;
        }
    }

    return $convertedString;
}

/**
 * Here we will receive the converted string as the argument.
 * All the characters other than the numbers [0-9] will be
 * replaced. Then the dynamic number we used to create the string
 * will be subtracted from the number and we will get the actual
 * id here....
 *
 * @param $input
 * @return mixed
 */

function revertURL($input)
{
    $sandwichedNumber = strtotime("last monday");
    $number = preg_replace("/[^0-9]+/", "", $input);
    $result = $number - $sandwichedNumber;
    return $result;
}
