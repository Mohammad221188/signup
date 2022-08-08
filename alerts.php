<?php
if(isset($_SESSION['error'])):

?>
<div class="alert alert-danger">
    <b><?php echo $_SESSION['error'];?></b>
</div>
<?php
$_SESSION['error'] = null;
unset($_SESSION['error']); 
endif; 
if(isset($_SESSION['success'])):
?>
<div class="alert alert-success">
    <b><?php echo $_SESSION['success'];?></b>
</div>
<?php
$_SESSION['success'] = null;
unset($_SESSION['success']); 
 endif;?>