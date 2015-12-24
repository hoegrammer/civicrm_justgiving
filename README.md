# CiviCRM Just Giving module for Drupal

Takes a Just Giving payment report and creates contributions in CiviCRM. It matches on Just Giving ID. Before it creates the donations it checks that all the IDs match contacts. If not it adds the IDs to what it thinks are the rights contacts, or creates those that it can't find.

## Dependencies
* hidden_field module

## Setup
* Create a content type with machine name "just_giving_import"
* Add a hidden file field (machine name: "file") and a hidden text field (10,000 characters, machine name: "results")
* Create two custom (alphanumeric) fields on the Individual contact type, one for Just Giving ID and one for Just Giving URL. Enter the machine names for these fields into the code.

## Use
* To do an import, go to Drupal menu, choose "Add Content" and add a piece of content using the Just Giving Import type. Insert any title and upload a Just Giving Payment Report. After a short wait the content will be saved and feedback will appear in the Results field. Like any piece of Drupal content this can then be viewed later to review previous imports. 

