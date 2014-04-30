<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php
	if(isset($_GET["dev"])) echo "<pre>".print_r($items, true)."</pre>";
?>


<div id="<?php echo $bootstrap_carousel_id; ?>" class="carousel <?php if($slide) echo $slide; ?>" data-ride="carousel" data-interval="<?php echo $interval; ?>" data-wrap="<?php echo ($wrap==1)?'true':'false'; ?>" <?php if(!empty($pause)) echo 'data-pause="'.$pause.'"'; ?>>
  
  <?php if($dots_navigation) : ?>
  <!-- Indicators -->
  <ol class="carousel-indicators">
	<?php 
	$i = 0;
	foreach($items as $item) : ?>
    <li data-target="#<?php echo $bootstrap_carousel_id; ?>" data-slide-to="<?php echo $i; ?>" <?php echo ($i++==0)?'class="active"':'';?>></li>    
	<?php endforeach; ?>
  </ol>
  <?php endif; ?>

  <!-- Wrapper for slides -->
  <div class="carousel-inner">
	<?php 
	$i = 0;
	foreach($items as $item) : ?>
	<div class="item <?php echo ($i++==0)?'active':'';?>">
      <img src="<?php echo $item["filepath"]; ?>" alt="<?php echo $item["title"];?>"  class="img-responsive">
      <?php if($caption) : ?>
	  <div class="carousel-caption">
        <?php echo $item["title"];?>
      </div>
	  <?php endif; ?>
    </div>
    <?php endforeach; ?>
  </div>

  <?php if($arrows_navigation) : ?>
  <!-- Controls -->
  <a class="left carousel-control" href="#<?php echo $bootstrap_carousel_id; ?>" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
  </a>
  <a class="right carousel-control" href="#<?php echo $bootstrap_carousel_id; ?>" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
  </a>
  <?php endif; ?>
</div>