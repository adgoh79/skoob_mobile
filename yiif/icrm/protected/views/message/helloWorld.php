<?php
$this->breadcrumbs=array(
	'Message'=>array('message/index'),
	'HelloWorld',
);?>
<h1>Hello, World!</h1>
<h3><?php echo $time; ?></h3>
<h3><?php echo $test_var; ?></h3>
<p><?php echo CHtml::link("Goodbye",array('message/goodbye'));
?></p>
<!-- <h1><?php echo $this->id . '/' . $this->action->id; ?></h1> 

<p>You may change the content of this page by modifying the file <tt><?php echo __FILE__; ?></tt>.</p> -->
