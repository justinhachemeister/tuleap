<?php
//
// SourceForge: Breaking Down the Barriers to Open Source Development
// Copyright 1999-2000 (c) The SourceForge Crew
// http://sourceforge.net
//
// $Id$

require($DOCUMENT_ROOT.'/include/pre.php');
require('../survey_data.php');
require('../survey_utils.php');

$LANG->loadLanguageMsg('survey/survey');

$is_admin_page='y';

if (!user_isloggedin() || !user_ismember($group_id,'A')) {
	echo '<H1>'.$LANG->getText('survey_admin_add_question','perm_denied').'</H1>';
	survey_footer(array());
	exit;
}

switch ($func) {

 case 'browse' :
     require('./browse_survey.php');
     break;

 case 'delete_survey' :
     survey_data_survey_delete($group_id,$survey_id);
     require('./browse_survey.php');
     break;

 case 'update_survey':
     if ($post_changes) {
	 // Update the survey
	 survey_data_survey_update($group_id,$survey_id,$survey_title,$survey_questions,$is_active,$is_anonymous);
	 // Display the list after the update
	 require('./browse_survey.php');
     } else {
	 // Show the form to update the survey
	 require('./update_survey.php');
     }
    break;
    
 default :
     require('./browse_survey.php');
     break;
}
?>
