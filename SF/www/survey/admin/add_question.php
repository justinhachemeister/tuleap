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
survey_header(array('title'=>$LANG->getText('survey_admin_add_question','add_q'),
		    'help'=>'AdministeringSurveys.html#CreatingorEditingQuestions'));

if (!user_isloggedin() || !user_ismember($group_id,'A')) {
	echo '<H1>'.$LANG->getText('survey_admin_add_question','perm_denied').'</H1>';
	survey_footer(array());
	exit;
}

if ($post_changes) {
    survey_data_question_create($group_id,htmlspecialchars($question),$question_type);
}

?>
<SCRIPT LANGUAGE="JavaScript">
<!--
var timerID2 = null;

function show_questions() {
	newWindow = open("","occursDialog","height=600,width=500,scrollbars=yes,resizable=yes");
	newWindow.location=('show_questions.php?group_id=<?php echo $group_id; ?>');
}

// -->
</script>

<H2><?php echo $LANG->getText('survey_admin_add_question','add_q'); ?></H2>
<P>
<FORM ACTION="<?php echo $PHP_SELF; ?>" METHOD="POST">
<INPUT TYPE="HIDDEN" NAME="post_changes" VALUE="Y">
<INPUT TYPE="HIDDEN" NAME="group_id" VALUE="<?php echo $group_id; ?>">
<?php echo $LANG->getText('survey_admin_add_question','q_allowed'); ?><BR>
<TEXTAREA NAME="question" COLS="60" ROWS="4" WRAP="SOFT"></TEXTAREA>
<P>

<?php echo $LANG->getText('survey_admin_add_question','q_type'); ?><BR>
<?php

$sql="SELECT * from survey_question_types";
$result=db_query($sql);
echo html_build_select_box($result,'question_type','xzxz',false);

?>
<P>

<INPUT TYPE="SUBMIT" NAME="SUBMIT" VALUE=" <?php echo $LANG->getText('survey_admin_add_question','add_this_q'); ?>">
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<INPUT TYPE="BUTTON" NAME="none" VALUE="<?php echo $LANG->getText('survey_admin_add_question','show_q'); ?>" ONCLICK="show_questions()">
</FORM>

<?php

survey_footer(array());

?>
