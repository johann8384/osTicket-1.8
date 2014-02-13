<?php
$title=($cfg && is_object($cfg) && $cfg->getTitle())?$cfg->getTitle():'osTicket :: Support Ticket System';
header("Content-Type: text/html; charset=UTF-8\r\n");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo Format::htmlchars($title); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="<?php echo ROOT_PATH; ?>css/bootstrap.min.css" rel="stylesheet" media="screen">
    <style>
    body {
      padding-top: 50px;
      padding-bottom: 40px;
    }   
    @media (max-width: 980px) {
      .navbar-text.pull-right {
        float: none;
        padding-left: 5px;
        padding-right: 5px;
      }
    }
  </style>
  <link href="<?php echo ROOT_PATH; ?>css/bootstrap-responsive.min.css" rel="stylesheet" media="screen">
  <link href='http://fonts.googleapis.com/css?family=Droid+Sans' rel='stylesheet' type='text/css'>
  <link href="<?php echo ROOT_PATH; ?>css/mystyle.css" rel="stylesheet" media="screen">
</head>
<body>
  <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="index.php"><?php echo Format::htmlchars($title); ?></a>
          <div class="nav-collapse collapse">
              <p class="navbar-text pull-right">
             <?php
             if($thisclient && is_object($thisclient) && $thisclient->isValid()) {
                 echo $thisclient->getName().'&nbsp;-&nbsp;';
                 ?>
                <?php
                if($cfg->showRelatedTickets()) {?>
                <a href="<?php echo ROOT_PATH; ?>tickets.php" class="navbar-link">My Tickets <b>(<?php echo $thisclient->getNumTickets(); ?>)</b></a> -
                <?php
                } ?>
                <a href="<?php echo ROOT_PATH; ?>logout.php?auth=<?php echo $ost->getLinkToken(); ?>" class="navbar-link">Log Out</a>
             <?php
             }elseif($nav){ ?>
                 Guest User - <a href="#myLogin" role="button" data-toggle="modal" class="navbar-link">Log In</a>
              <?php
             } ?>
            </p>
            <ul class="nav">
          <?php
            if($nav && ($navs=$nav->getNavLinks()) && is_array($navs)){
                foreach($navs as $name =>$nav) {
                    echo sprintf('<li class="%s %s"><a href="%s">%s</a></li>%s',$nav['active']?'active':'',$name,(ROOT_PATH.$nav['href']),$nav['desc'],"\n");
                }
            } ?>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
      <div class="container">
         <?php if($errors['err']) { ?>
            <div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $errors['err']; ?></div>
         <?php }elseif($msg) { ?>
            <div class="alert alert-success"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $msg; ?></div>
         <?php }elseif($warn) { ?>
            <div class="alert alert-info"><button type="button" class="close" data-dismiss="alert">&times;</button><?php echo $warn; ?></div>
         <?php } ?>