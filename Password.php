<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30-10-2017
 * Time: 14:21
 * @author: iamRahul1973.github.io
 * @package: My_Repo
 * @lib: password
 */


/**
 * Class Password
 * to secure the password instead of storing
 * it as plain text.
 */
class Password
{
    public $userPassword;

    public function __construct($userPassword)
    {
        $this->userPassword = $userPassword;
    }

    /**
     * @return bool
     * preventing the user from using certain common series of character
     * sequences in their password
     */

    public function pwd_series()
    {
        $seriesOne = 'qwertyuiopasdfghjklzxcvbnm';
        $seriesTwo = 'abcdefghijklmnopqrstuvwxyz';
        $seriesThree = 'zyxwvutsrqponmlkjihgfedcba';
        $seriesFour = '12345678910';

        // Alphabetic Series

        $i = 0;
        while ($i < 24)
        {
            $substr1 = substr($seriesOne,$i,3);
            $substr2 = substr($seriesTwo,$i,3);
            $substr3 = substr($seriesThree,$i,3);

            if(strpos(strtolower($this->userPassword),$substr1) !== false)
            {
                return false; // means the given password can't be used !
            }
            elseif(strpos(strtolower($this->userPassword),$substr2) !== false)
            {
                return false;
            }
            elseif(strpos(strtolower($this->userPassword),$substr3) != false)
            {
                return false;
            }
            $i++;
        }

        // Numeric Series

        $i = 0;
        while ($i < 9)
        {
            $substr4 = substr($seriesFour,$i,3);

            if(strpos(strtolower($this->userPassword),$substr4) != false)
            {
                return false;
            }
            $i++;
        }

        return true;
    }

    /**
     * @return bool
     * forcing the user to use at least one Uppercase letter, Lowercase letter,
     * one numeric digit and one special character
     * eg : imRahul@2017
     */

    public function pwd_strength()
    {
        if(preg_match('/[A-Z]/', $this->userPassword) && preg_match('/[a-z]/', $this->userPassword) && preg_match('/[0-9]/', $this->userPassword) && preg_match('/[\'!^£$%&*()}{@#~?><.,|=_+¬-]/', $this->userPassword))
        {
            return true;
        }
        else
        {
            /*
             * 'Sorry! Your Password must contain at least one Uppercase letter,
             * Lowercase letter,Digit and a special character !'
             */
            return false;
        }
    }

    /**
     * @return bool
     * performs both series checking and password strengthening
     * at the same time...
     */

    public function pwd_final()
    {
        $series = $this->pwd_series();
        $strength = $this->pwd_strength();

        if ($series && $strength)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
