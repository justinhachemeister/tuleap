<?php
//
// SourceForge: Breaking Down the Barriers to Open Source Development
// Copyright 1999-2000 (c) The SourceForge Crew
// http://sourceforge.net
//
// $Id$

require($DOCUMENT_ROOT.'/include/pre.php');
require($DOCUMENT_ROOT.'/include/HTML_Graphs.php');
require($DOCUMENT_ROOT.'/survey/survey_utils.php');

$LANG->loadLanguageMsg('survey/survey');

$is_admin_page='y';
survey_header(array('title'=>$LANG->getText('survey_admin_show_r_aggregate','agg_res'),
		    'help'=>'AdministeringSurveys.html#ReviewingSurveyResults'));

if (!user_isloggedin() || !user_ismember($group_id,'A')) {
	echo '<H1>'.$LANG->getText('survey_admin_add_question','perm_denied').'</H1>';
	survey_footer(array());
	exit;
}

$sql="SELECT question FROM survey_questions WHERE question_id='$question_id'";
$result=db_query($sql);

echo '<h2>'.$LANG->getText('survey_admin_show_r_comments','s_res').'</h2>';

echo '<h3>'.$LANG->getText('survey_admin_show_r_comments','q_no',array($question_num,util_unconvert_htmlspecialchars(db_result($result,0,"question")))).'</H3>';
echo "<P>";

$sql="SELECT response, count(*) AS count FROM survey_responses WHERE survey_id='$survey_id' ".
"AND question_id='$question_id' AND group_id='$group_id' ".
"GROUP BY response";
$result=db_query($sql);
survey_utils_show_comments($result);

survey_footer(array());

?>
