<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 19-07-2017
 * Time: 11:52
 */

// ============================================================
// GENERATING USER CREDENTIALS
// ============================================================

/**
 * For automatically creating a username and Password for the user
 * The user can take it or chose their own Credentials as well.
 *
 * These Credentials are created well within the rules of @see
 * UserInput.php => @class Password, a class that guides the user
 * to select strong log in credentials.
 */

/* --------------------------------------------------------- */

/**
 * @param string $strOne
 * @param string $strTwo
 *
 * If no parameter is passed in, we are using the generateRandomString
 * function to create the credential. This will be usually for creating
 * a password. If the 2 parameters are passed in (usually strOne will be
 * FirstName & strTwo will be LastName or initial) strTwo will be loaded
 * first, then strOne through ucword and we are appending it with the
 * result from the function generateRandomString().
 *
 * @return string
 */

function genCredential($strOne = '', $strTwo = '')
{
    if (empty($strOne) && empty($strTwo))
    {
        return generateRandomString();
    }
    else
    {
        $symbols = '@#$%*-+';
        $result  = strtolower($strTwo).ucwords($strOne);
        $result .= $symbols[rand(0, strlen($symbols) - 1)];
        $result .= generateRandomString(3,1,2,1);
        return $result;
    }
}

/**
 * @param int $lc no.of lowercase characters u need in the string
 * @param int $uc no.of uppercase characters u need in the string
 * @param int $dg no.of digits u need in the string
 * @param int $sm no.of symbols u need in the string
 *
 * We will take 5 random lowercase chars, 3 random uppercase chars,
 * 3 random digits & 3 random symbols from each repository to make
 * a random string. the no.of chars u need from each repository
 * can be passed in as parameters. the result string then will be
 * like eg: 'akhwbHSB840*@!'. Now we will shuffle these characters
 * to interchange their positions.
 *
 * @return string $result
 */

function generateRandomString($lc = 5, $uc = 3, $dg = 3, $sm = 3)
{
    // Character Repositories & Lengths
    $lower = 'abcdefghijklmnopqrstuvwxyz';
    $upper = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $digits = '0123456789';
    $symbol = '!@#$%^*-_+=\/';

    $lowLen = strlen($lower);
    $uppLen = strlen($upper);
    $digLen = strlen($digits);
    $symLen = strlen($symbol);

    $randStr = '';

    // Lowercase Characters
    for ($i = 0; $i < $lc; $i++)
    {
        $randStr .= $lower[rand(0, $lowLen - 1)];
    }

    // Uppercase Characters
    for ($i = 0; $i < $uc; $i++)
    {
        $randStr .= $upper[rand(0, $uppLen - 1)];
    }

    // Digits
    for ($i = 0; $i < $dg; $i++)
    {
        $randStr .= $digits[rand(0, $digLen - 1)];
    }

    //Symbols
    for ($i = 0; $i < $sm; $i++)
    {
        $randStr .= $symbol[rand(0, $symLen - 1)];
    }

    $result = str_shuffle($randStr);
    return $result;
}
