
<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30-10-2017
 * Time: 14:30
 * @author: iamRahul1973.github.io
 * @package: My_Repo
 * @lib: validation
 */


/**
 * Class Validation
 * @package custom
 *
 * -------------------------------
 * Custom Form Validation function
 * -------------------------------
 *
 * For this class to work properly you have to submit an associative array.
 * If you pass in a numeric array with numeric keys and values to be validated
 * the class will mis-behave.
 *
 * The key of every element should be a corresponding string value that can be
 * used by this class to validate the array elements.
 *
 * Right : array('email' => 'rahulkr1973@gmail.com')
 * Wrong : array(0 => 'rahulkr1973@gmail.com')
 */

class Validation
{
    /**
     * @var array|string $data
     * array or string to be validated
     */
    public $data;

    /**
     * @var string|array $exclude
     * the elements of the array that need not be validated
     */
    public $exclude;

    /**
     * @var string $rule
     * if the $data is not an array, we have to define which
     * rule to apply on that field data.
     */
    public $rule;

    /**
     * @var string $email
     */
    public $email;

    /**
     * @var int|string $phone
     */
    public $phone;

    /**
     * @var string $string
     */
    public $string;

    /**
     * @var string $url
     */
    public $url;

    /**
     * @var int $date
     */
    public $date;

    /**
     * @param array|string $data
     */

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * performs "required" validation and returns
     * false if any of the element is empty.
     * @return bool
     */

    public function requireAll()
    {
        foreach ($this->data as $key => $value)
        {
            if (!empty($this->exclude) && in_array($value, $this->exclude))
            {
                continue;
            }

            if (empty($value))
            {
                return false;
            }
        }
        return true;
    }

    /**
     * @param string $email
     * validating the email
     * @return mixed
     */

    public function validateEmail($email)
    {
        $this->email = $email;
        return (filter_var($this->email, FILTER_VALIDATE_EMAIL));
    }

    /**
     * @param string|int $phone
     * validating the phone number
     * @return int
     */

    public function validatePhone($phone)
    {
        $this->phone = $phone;
        return preg_match('/^[0-9]{10}$/', $this->phone);
    }

    /**
     * @param string $string
     * validates a string. Only alphabets and whitespace allowed !
     * @return bool
     */

    public function validateAlpha($string)
    {
        $this->string = $string;
        $this->string = strpos($this->string, ' ') ? str_replace(' ', '', $this->string) : $this->string;
        return (ctype_alpha($this->string));
    }

    /**
     * @param string $url
     * validates a website url
     * @return int
     */

    public function validateURL($url)
    {
        $this->url = $url;
        return (preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$this->url));
    }

    // ============================================================
    // DATE VALIDATION FOLLOWS
    // ============================================================

    /**
     * @param int $year
     * to check if the given year is a leap year or not !
     * @return bool
     */

    public function isLeapYear($year)
    {
        return (($year % 4 == 0) and (($year % 100 !=0) or ($year % 400 == 0))) ? true : false;
    }

    /**
     * @param int $date
     * @param int $month
     * @param int $year
     * checks if the given date is a valid one or not !
     * @return bool
     */

    public function validateMonth($date, $month, $year)
    {
        if ($month > 12 || $date > 31)
        {
            return false;
        }

        // all months have at least 28 days in it !
        if ($date <= 28)
        {
            return true;
        }

        // months with 30 days
        $monthsOf30 = array(4, 6, 9, 11);

        if (in_array($month, $monthsOf30))
        {
            return ($date == 31) ? false : true;
        }
        elseif ($month == 2)
        {
            if ($date > 29)
            {
                return false;
            }
            elseif ($date == 29)
            {
                return $this->isLeapYear($year);
            }
            else
            {
                return true;
            }
        }
        return true;
    }

    /**
     * @param string $date
     * @param string $format
     * Validating the format of a given date
     * @return bool
     */

    public function validateDateFormat($date, $format = 'MM-DD-YY')
    {
        $this->date = $date;

        // looking for the delimiter
        if (strpos($this->date, '-') !== false)
        {
            $delimiter = '-';
        }
        elseif (strpos($this->date, '/') !== false)
        {
            $delimiter = '/';
        }
        else
        {
            //trigger_error('Unknown delimiter in the date string provided !');
            return false;
        }

        $exploded = explode($delimiter, $this->date);

        // add more date formats below if you wish to !

        switch ($format)
        {
            case 'YY-MM-DD' :
                if (($exploded[0] >= 1000) && ($exploded[1] <= 12) && ($exploded[2] <= 31))
                {
                    $result = $this->validateMonth($exploded[2],$exploded[1],$exploded[0]);
                }
                else
                {
                    $result = false;
                }
                break;

            case 'DD-MM-YY' :
                if (($exploded[0] <= 31) && ($exploded[1] <= 12) && ($exploded[2] >= 1000))
                {
                    $result = $this->validateMonth($exploded[0], $exploded[1], $exploded[2]);
                }
                else
                {
                    $result = false;
                }
                break;

            case 'MM-DD-YY' :
                if (($exploded[0] <= 12) && ($exploded[1] <= 31) && ($exploded[2] >= 1000))
                {
                    $result = $this->validateMonth($exploded[1], $exploded[0], $exploded[2]);
                }
                else
                {
                    $result = false;
                }
                break;

            default :
                $result = false;
                break;
        }

        return $result;
    }

    // ============================================================
    // DATE VALIDATION ENDS & FINAL VALIDATE FUNCTION
    // ============================================================

    /**
     * @param string|array $exclude
     * @param string       $rule
     *
     * @return array|bool|int|mixed
     */

    public function validate($exclude = '', $rule = '')
    {
        $this->exclude = $exclude;
        $this->rule = $rule;

        if (!empty($this->exclude))
        {
            foreach ($this->exclude as $key => $value)
            {
                unset($this->data[$key]);
            }
        }

        $errors = array();

        if (is_array($this->data))
        {
            if (!$this->requireAll())
            {
                $errors['require'] = 'Please fill all mandatory fields !';
                return $errors;
            }

            $possibleAlpha = array('first', 'last'); // name

            foreach ($this->data as $key => $value)
            {
                if (in_array($key, $possibleAlpha))
                {
                    if (!$this->validateAlpha($value))
                    {
                        $errors[$key] = 'Only letters and white space allowed';
                    }
                }

                if ($key == 'email')
                {
                    if (!$this->validateEmail($value))
                    {
                        $errors[$key] = 'Invalid email address !';
                    }
                }
                elseif ($key == 'phone')
                {
                    if (!$this->validatePhone($value))
                    {
                        $errors[$key] = 'Invalid phone number !';
                    }
                }
                elseif ($key == 'url' || $key == 'website')
                {
                    if (!$this->validateURL($value))
                    {
                        $errors[$key] = 'Invalid URL given !';
                    }
                }
                elseif ($key == 'dob' || $key == 'date')
                {
                    if (!$this->validateDateFormat($value))
                    {
                        $errors[$key] = 'Invalid date given !';
                    }
                }
                elseif ($key == 'password' || $key == 'username')
                {
                    $pwdObj = new Password($value);
                    if (!$pwdObj->pwd_final())
                    {
                        $errors[$key] = "The $key is insecure. Chose a strong one !";
                    }
                }
                elseif ($key == 'confirm')
                {
                    if ($value != $this->data['password']) {$errors[$key] = 'Passwords must be matching !';}
                }
                else
                {
                    continue;
                }
            }

            return (empty($errors)) ? true : $errors;
        }
        else
        {
            if (!empty($this->rule))
            {
                switch ($this->rule)
                {
                    case 'email':
                        $result = $this->validateEmail($this->data);
                        break;

                    case 'alpha':
                        $result = $this->validateAlpha($this->data);
                        break;

                    case 'phone':
                        $result = $this->validatePhone($this->data);
                        break;

                    case 'url':
                        $result = $this->validateURL($this->data);
                        break;

                    case 'dob':
                        $result = $this->validateDateFormat($this->data);
                        break;

                    case 'date':
                        $result = $this->validateDateFormat($this->data);
                        break;

                    default:
                        trigger_error('Unknown rule defined');
                        return false;
                        break;
                }
            }
            else
            {
                trigger_error('No rule specified');
                return false;
            }
            return $result;
        }
    }
}
