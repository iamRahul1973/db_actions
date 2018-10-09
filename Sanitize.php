<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 30-10-2017
 * Time: 14:15
 * @author: iamRahul1973.github.io
 * @package: My_Repo
 * @lib: sanitize
 */

/**
 * Class Sanitize
 * to sanitize the user input
 * @package custom
 */
class Sanitize
{
    /**
     * @var mixed $input the user input
     */
    public $input;

    public function __construct($input)
    {
        $this->input = $input;
    }

    /**
     * @return array|mixed|string
     *
     * sanitizing the user input !
     *
     * @doc_num Here we sanitized the value to integer. from
     *          the 'fee' field we are expecting integer value
     *          (fee of the course). you can either add more
     *          field names - that can be used as common names
     *          to describe those input fields - in the if
     *          condition there or use an array with those
     *          possible common integer value names. or just
     *          change and use it according to your need !
     */

    public function sanitize()
    {
        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<style[^>]*?>.*?</style>@siU',  // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@'       // Strip multi-line comments
        );

        if (is_array($this->input))
        {
            $array = $this->input;
            foreach ($array as $key => $value)
            {
                $value = trim($value);
                $value = htmlspecialchars($value);
                $value = stripslashes($value);
                $value = preg_replace($search, '', $value);

                if ($key == 'email')
                {
                    $value = filter_var($value, FILTER_SANITIZE_EMAIL);
                }
                elseif ($key == 'phone')
                {
                    $value = preg_replace('/[^0-9]/', '', $value);
                }
                elseif ($key == 'fee') // @see doc_num
                {
                    $value = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                }

                $sanitized[$key] = $value;
            }
        }
        else
        {
            $this->input = trim($this->input);
            $this->input = htmlspecialchars($this->input);
            $this->input = stripslashes($this->input);
            $this->input = preg_replace($search, '', $this->input);
            $sanitized = $this->input;
        }

        return isset($sanitized) ? $sanitized : false;
    }
}
