<?php
if(!defined('OSTCLIENTINC')) die('Access Denied!');
$info=array();
if($thisclient && $thisclient->isValid()) {
    $info=array('name'=>$thisclient->getName(),
                'email'=>$thisclient->getEmail(),
                'phone'=>$thisclient->getPhone(),
                'phone_ext'=>$thisclient->getPhoneExt());
}
$info=($_POST && $errors)?Format::htmlchars($_POST):$info;
?>  
<h1>Open a New Ticket</h1>
<p>Please fill in the form below to open a new ticket.</p>
<form id="ticketForm" method="post" action="open.php" enctype="multipart/form-data" class="form-horizontal">
  <?php csrf_token(); ?>
  <input type="hidden" name="a" value="open">
    <div class="control-group">
    <label class="control-label" for="inputName">Full Name:</label>
            <?php
            if($thisclient && $thisclient->isValid()) {
              ?>
            <div class="controls">
              <span class="uneditable-input">
              <?php 
                echo $thisclient->getName();
              ?>
                </span>
              </div>
      <?php
            } else { ?>
                <div class="controls">
                <input class="input-xlarge" id="name" type="text" name="name" size="30" value="<?php echo $info['name']; ?>" placeholder="Full Name">
                <span class="help-inline" style="color:Red"><?php echo $errors['name']; ?></span>
                </div>
            </div>
            <?php
            } ?>
  <div class="control-group">
    <label class="control-label" for="inputEmail">Email Address:</label>
            <?php
            if($thisclient && $thisclient->isValid()) { 
              ?>
            <div class="controls">
              <span class="uneditable-input">
                <?php
                echo $thisclient->getEmail();
                ?>
                </span>
              </div>
      <?php
            } else { ?>
              <div class="controls">
                <input class="input-xlarge" id="email" type="text" name="email" size="30" value="<?php echo $info['email']; ?>" placeholder="Email Address">
                <span class="help-inline" style="color:Red"><?php echo $errors['email']; ?></span>
                </div>
              </div>
            <?php
            } ?>
  <div class="control-group">
    <label class="control-label" for="inputTel">Telephone:</label>
       <?php
            if($thisclient && $thisclient->isValid()) { 
              ?>
            <div class="controls inline">
              <span class="uneditable-input">
            <?php
               echo $thisclient->getPhone();
            ?>
                </span>
              <span class="uneditable-input">
            <?php
                echo $thisclient->getPhoneExt();
            ?>
                </span>
              </div>
            <?php
            } else { ?>
      <div class="controls inline">
            <input class="input-xlarge" id="phone" type="text" name="phone" size="17" value="<?php echo $info['phone']; ?>" placeholder="Telephone"> Ext.:
            <input class="input-small" id="ext" type="text" name="phone_ext" size="3" value="<?php echo $info['phone_ext']; ?>" placeholder="Ext.">
            <span class="help-inline" style="color:Red"><?php echo $errors['phone']; ?>&nbsp;&nbsp;<?php echo $errors['phone_ext']; ?></span>
        </div>
    </div>
  <?php } ?>
  <div class="control-group">
    <label class="control-label" for="inputHelp">Help Topic:</label>
      <div class="controls">
            <select id="topicId" class="input-xlarge" name="topicId">
                <option value="" selected="selected">&mdash; Select a Help Topic &mdash;</option>
                <?php
                if($topics=Topic::getPublicHelpTopics()) {
                    foreach($topics as $id =>$name) {
                        echo sprintf('<option value="%d" %s>%s</option>',
                                $id, ($info['topicId']==$id)?'selected="selected"':'', $name);
                    }
                } else { ?>
                    <option value="0" >General Inquiry</option>
                <?php
                } ?>
            </select>
            <span class="help-inline" style="color:Red"><?php echo $errors['topicId']; ?></span>
        </div>
    </div>
  <div class="control-group">
    <label class="control-label" for="inputSubject">Subject:</label>
      <div class="controls">
            <input class="input-xlarge" id="subject" type="text" name="subject" size="40" value="<?php echo $info['subject']; ?>" placeholder="Subject">
            <span class="help-inline" style="color:Red"><?php echo $errors['subject']; ?></span>
      </div>
    </div>
        <div class="control-group">
    <label class="control-label" for="inputMessage">Message:</label>
          <div class="controls">
            <em>Please provide as much detail as possible so we can best assist you.</em> <br>
            <textarea id="message" cols="60" rows="8" name="message" class="input-xxlarge"><?php echo $info['message']; ?></textarea> <br>
            <span class="help-inline" style="color:Red"><?php echo $errors['message']; ?></span>
            </div>
          </div>

    <?php if(($cfg->allowOnlineAttachments() && !$cfg->allowAttachmentsOnlogin())
            || ($cfg->allowAttachmentsOnlogin() && ($thisclient && $thisclient->isValid()))) { ?>
  <div class="control-group">
    <label class="control-label" for="inputAttachment">Attachments:</label>
        <div class="controls">
            <input type="file" class="" name="attachments[]" id="attachments" size="30" value="" />
            <span class="help-inline" style="color:Red"><?php echo $errors['attachments']; ?></span>
        </div>
      </div>
    <?php } ?>
    <?php
    //if($cfg->allowPriorityChange() && ($priorities=Priority::getPriorities())) { ?>
      <div class="controls-group">
        <label class="control-label" for="inputMessage">Ticket Priority:</label>
          <div class="controls">
            <select class="input-xlarge" id="priority" name="priorityId">
                <?php
                    if(!$info['priorityId'])
                        $info['priorityId'] = $cfg->getDefaultPriorityId(); //System default.
                    foreach($priorities as $id =>$name) {
                        echo sprintf('<option value="%d" %s>%s</option>',
                                        $id, ($info['priorityId']==$id)?'selected="selected"':'', $name);
                        
                    }
                ?>
            </select>
             <span class="help-inline" style="color:Red"><?php echo $errors['priorityId']; ?></span>
          </div>
        </div>
  <br>
    <?php
    //}
    ?>
    <?php
    if($cfg && $cfg->isCaptchaEnabled() && (!$thisclient || !$thisclient->isValid())) {
        if($_POST && $errors && !$errors['captcha'])
            $errors['captcha']='Please re-enter the text again';
        ?>
  <div class="controls-group">
        <label class="control-label" for="inputMessage">CAPTCHA Text:</label>
          <div class="controls inline">  
            <em>Enter the text shown on the image.</em> <br>
          <span><img src="captcha.php" border="0" align="left"></span> &nbsp;
            <input id="captcha" type="text" name="captcha" size="6" placeholder="CAPTCHA">
             <span class="help-inline" style="color:Red"><?php echo $errors['captcha']; ?></span> <br> <br>
        </div>
    </div>
    <?php
    } ?>
      <div class="controls">
        <input class="btn btn-primary" type="submit" value="Create Ticket">
        <input class="btn" type="reset" value="Reset">
        <input class="btn" type="button" value="Cancel" onClick='window.location.href="index.php"'>
        </div>
  </form>