<?php
if(!defined('OSTCLIENTINC') || !$thisclient || !$ticket || !$ticket->checkClientAccess($thisclient)) die('Access Denied!');

$info=($_POST && $errors)?Format::htmlchars($_POST):array();

$dept = $ticket->getDept();
//Making sure we don't leak out internal dept names
if(!$dept || !$dept->isPublic())
    $dept = $cfg->getDefaultDept();

?>
<div class="row-fluid">
  <div class="span12"><h3>Ticket #<?php echo $ticket->getExtId(); ?></h3></div>
</div>
<hr>
<div class="row-fluid">
  <div class="span3"><strong>Ticket Status:</strong></div>
  <div class="span3"><?php echo ucfirst($ticket->getStatus()); ?></div>
  <div class="span3"><strong>Name</strong></div>
  <div class="span3"><?php echo ucfirst($ticket->getName()); ?></div>
</div>

<div class="row-fluid">
  <div class="span3"><strong>Email:</strong></div>
  <div class="span3"><?php echo Format::htmlchars($ticket->getEmail()); ?></div>
  <div class="span3"><strong>Phone:</strong></div>
  <div class="span3"><?php echo $ticket->getPhoneNumber(); ?></div>
</div>
<div class="row-fluid">
  <div class="span3"><strong>Department:</strong></div>
  <div class="span3"><?php echo Format::htmlchars($dept->getName()); ?></div>
  <div class="span3"><strong>Create Date:</strong></div>
  <div class="span3"><?php echo Format::db_datetime($ticket->getCreateDate()); ?></div>
</div>
<div class="row-fluid">
  <div class="span3"><strong>Subject:</strong></div>
  <div class="span9"><?php echo Format::htmlchars($ticket->getSubject()); ?></div>
</div>
<hr>
<h4>Ticket Thread</h4>


<?php    
if($ticket->getThreadCount() && ($thread=$ticket->getClientThread())) {
    $threadType=array('M' => 'message', 'R' => 'response');
    foreach($thread as $entry) {
        //Making sure internal notes are not displayed due to backend MISTAKES!
        if(!$threadType[$entry['thread_type']]) continue;
        $poster = $entry['poster'];
        if($entry['thread_type']=='R' && ($cfg->hideStaffName() || !$entry['staff_id']))
            $poster = ' ';
        ?>
            <div class="row"><div class="span2"><?php echo Format::db_datetime($entry['created']); ?><br><em>
              <?php echo (empty($poster) === true) ? "By: " . ucfirst($ticket->getName()) : "By: " . $poster; ?>
              </em></div>
            <div class="span10"><?php echo Format::display($entry['body']); ?></div></div><hr>
            <?php
            if($entry['attachments']
                    && ($tentry=$ticket->getThreadEntry($entry['id']))
                    && ($links=$tentry->getAttachmentsLinks())) { ?>
                <div class="row"><div class="span8 offset2"><?php echo $links; ?></div></div>
            <?php
            } ?>

    <?php
    }
}
?>
         <?php if($errors['err']) { ?>
            <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $warn; ?></div>
         <?php } ?>

<form id="reply" action="tickets.php?id=<?php echo $ticket->getExtId(); ?>#reply" name="reply" method="post" enctype="multipart/form-data">
    <?php csrf_token(); ?>
    <h4>Post a Reply</h4>
    <input type="hidden" name="id" value="<?php echo $ticket->getExtId(); ?>">
    <input type="hidden" name="a" value="reply">
  <div class="row">
    <div class="span2">Message:</div>
                <?php
                if($ticket->isClosed()) {
                    $msg='Ticket will be reopened on message post';
                } else {
                    $msg='To best assist you, please be specific and detailed';
                }
                ?>
                <div class="span10"><span id="msg"><em><?php echo $msg; ?> </em></span><font class="error">*&nbsp;<?php echo $errors['message']; ?></font><br/>
                <textarea name="message" id="message" cols="50" rows="9" wrap="soft" class="input-xxlarge"><?php echo $info['message']; ?></textarea> </div>
    </div>
        <?php
        if($cfg->allowOnlineAttachments()) { ?>
    <div class="row">
      <div class="span2">Attachments:</div>
      <div class="span10"><input class="multifile" type="file" name="attachments[]" size="30" value="" /></div>
    </div>
        <?php
        } ?>
  <br>
  <div class="row">
    <div class="span12 offset2">
        <input class="btn btn-primary" type="submit" value="Post Reply">
        <input class="btn" type="reset" value="Reset">
        <input class="btn" type="button" value="Cancel" onClick="history.go(-1)">
    </div>
  </div>
</form>