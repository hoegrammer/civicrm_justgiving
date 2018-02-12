<?php
// Enter the values corresponding to your CiviCRM installation,
// then move/copy it to config.php in the same directory.
define('ANONYMOUS_CIVI_ID', "1234"); // the contact id of the contact who will "own" all anonymous donations.
define('JUST_GIVING_ID_FIELD_NAME', "custom_123"); // the custom field for storing Just Giving ID against contacts. This has to be in a multirecord fieldset
define('CONTACT_SUB_TYPE', "Supporter"); // the sub-type to create when making new contacts
define('GROUP_ID', 'supporters'); // id of group to put new contacts in.

// Assist-specific custom fields on donations.
define('EVENT_SPONSORSHIP_FIELD_NAME', 'custom_234');
define('ELIGIBLE_FOR_GIFT_AID_FIELD_NAME', 'custom_345');
define('INCOME_CONDITION_FIELD_NAME', 'custom_456');

?>

