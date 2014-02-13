<?php
if(!defined('OSTCLIENTINC') || !$faq  || !$faq->isPublished()) die('Access Denied');

$category=$faq->getCategory();

?>
<h3>Frequently Asked Questions</h3>
<ul class="breadcrumb">
    <li><a href="index.php">All Categories</a> <span class="divider">></span></li>
    <li><a href="faq.php?cid=<?php echo $category->getId(); ?>"><?php echo $category->getName(); ?></a></li>
</ul>

  <div class="row">
    <div class="span3">
      <b><?php echo $faq->getQuestion() ?></b>
    </div>
    <div class="span8">
      <p><?php echo Format::safe_html($faq->getAnswer()); ?></p>
    </div>
  </div>
  <hr>
  <div class="row">
    <div class="span3">
      <em>Last updated: <?php echo Format::db_daydatetime($category->getUpdateDate()); ?></em>
    </div>
    <div class="span8">
      <?php
        if($faq->getNumAttachments()) { ?>
         <b>Attachments:</b> <?php echo $faq->getAttachmentsLinks(); ?>
        <?php
        } ?>
    </div>
  </div>




<!--

<div style="width:700;padding-top:2px; float:left;">
<strong style="font-size:16px;"><?php echo $faq->getQuestion() ?></strong>
</div>
<div style="float:right;text-align:right;padding-top:5px;padding-right:5px;"></div>
<div class="clear"></div>
<p>
<?php echo Format::safe_html($faq->getAnswer()); ?>
</p>
<p>
<?php
if($faq->getNumAttachments()) { ?>
 <div><span class="faded"><b>Attachments:</b></span>  <?php echo $faq->getAttachmentsLinks(); ?></div>
<?php
} ?>

<div class="article-meta"><span class="faded"><b>Help Topics:</b></span>
    <?php echo ($topics=$faq->getHelpTopics())?implode(', ',$topics):' '; ?>
</div>
<hr>
<div class="faded">&nbsp;Last updated <?php echo Format::db_daydatetime($category->getUpdateDate()); ?></div> -->
