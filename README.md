# CiviCRM Just Giving module for Drupal

Takes a Just Giving payment report and creates contributions in CiviCRM. It matches on Just Giving ID. Before it creates the donations it checks that all the Just Giving IDs (for fundraisers and for donors) exist in CivCRM. Any that don't, it adds to a contact if it can (matching on name plus any email address - doesn't have to be primary) and otherwise creates the contact. Thus it ensures that the Just Giving IDs exist before attempting to import the contributions. It also does soft credits. 

## Dependencies
* hidden_field module
* auto_nodetitle module (the Title is ignored, so no point asking the user to enter one)

## Setup
* Copy config.sample.php to config.php - this is the config file
* Create a content type with machine name "just_giving_import"
* Set up a Private Files directory in Drupal if you don't already have one (tip: add a `.htaccess` saying just `Deny from all`)
* Add a hidden file field (machine name: "file", destination: Private) and a hidden text field (10,000 characters, machine name: "results")
* Create two custom (alphanumeric) fields on the Individual contact type, one for Just Giving ID and one for Just Giving URL. Enter the machine names for these fields into the config file
* Create a CiviCRM contact which will be used to assign all anonymous donations. Give then a Just Giving ID and enter this in the config file
* **** THere are also some Assist-specific field names in the config which are used in the code ****

## Use
* To do an import, go to Drupal menu, choose "Add Content" and add a piece of content using the Just Giving Import type. Insert any title and upload a Just Giving Payment Report. After a short wait the content will be saved and feedback will appear in the Results field. Like any piece of Drupal content this can then be viewed later to review previous imports. 

