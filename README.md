# DB_Crud
a mysal database crud library for php. This library has fetch and delete functions which you can use to fetch details from the databse and to delete data from the db.
We can provide the table, column and condiotions as function params instead of writing the select and delete query everywhere. 
The function will buid the query for you

# Password
Checks for your password strength. Forcing the user to use at least one Uppercase letter, Lowercase letter, one numeric digit and one special character. *eg : imRahul@2017*.
Also checks for character sequences in the password string. Means the user can't use any of the below character sequence in their password string.

* *qwerty*
* *abcd*
* *zyxw*
* *1234*

# Sanitize
Sanitizing the user input.

# Validate
Validating the form data. The below listed are the functions we have.
* *require_all : Performs a required validation on every form field.*
* *validating the email address provided.*
* *validating the phone nummber provided.*
* *validate a string and allowing only alphabets and whitespaces.*
* *validating a website url.*
* *validating a date to know if it is a leap year.*
* *validating a month.*
* *Validating the format of a given date.*

# File Handling
Chacks if the uploaded file is of allowed type. Randomly naming the uploaded file, o that the file name will be unique for every uploaded files.

# URL Encoding
Instead of passing critical data as pure integers through the url query part we converts the passing value to a randomly generated string that contains integers and alphabets in it. And on the destination we will revert back the randomly generated string to the actual integer passed.

*eg : https://my_website.com/story.php?ref_id=oNL130FyC168wOc2601l. Here instead of passing the value 1, which is easily exploitable for a user, we generate a string using the actual value, that is a bit complex to exploit and pass that value instead.*

# Other Resources
***genCredential :*** Generating a random password

___

# TODO

**DB_Crud :** Currently only fetch and delete functions. Need to include insert and update functions as well.

**Password :** Need to prevent the user from having commonly used weak password strings such as, *password*, etc

**GenCredential :** Need to check if the strength of the randomly generated Password string. If the string doesn't meet the criteria we set for password in the Password library, then make it a strong one by interchanging the individual chars or by creating a new password string.
