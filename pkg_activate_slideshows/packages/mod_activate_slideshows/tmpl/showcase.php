<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php
	$itemsCount = count($items);
	if($itemsCount < $bootstrap_carousel_thumbs_per_row)
		$bootstrap_carousel_rows_of_thumbs = 1;
	
	$boostrap_col_size = ceil(12 / $bootstrap_carousel_thumbs_per_row);
	$slidesCount = ceil($itemsCount / ($bootstrap_carousel_thumbs_per_row*$bootstrap_carousel_rows_of_thumbs));
	$total_per_slide = $bootstrap_carousel_thumbs_per_row*$bootstrap_carousel_rows_of_thumbs;
	if(isset($_GET["dev"]))
	{
		echo "Numero di colonne: ".$bootstrap_carousel_thumbs_per_row."<br/>";
		echo "Numero di righe: ".$bootstrap_carousel_rows_of_thumbs."<br/>";
		echo "Per slide = ".$total_per_slide."<br/>";
		echo "Numero totali: ".count($items)."<br/>";
		echo "Numero slides: ".$slidesCount."<br/>";
		echo "Bootstrap size: col-md-".$boostrap_col_size."<br/>";
		
		//echo "<pre>".print_r($slideshow, true)."</pre>";
		//echo "<pre>".print_r($items, true)."</pre>";
	}
	
?>


<div id="<?php echo $bootstrap_carousel_id; ?>" class="activate-showcase activate-showcase-<?php echo $slideshow[0]["id"]; ?> carousel <?php if($slide) echo $slide; ?>" data-ride="carousel" data-interval="<?php echo $interval; ?>" data-wrap="<?php echo ($wrap==1)?'true':'false'; ?>" <?php if(!empty($pause)) echo 'data-pause="'.$pause.'"'; ?>>
  
  <!-- Wrapper for slides -->
  <div class="carousel-inner">
	<?php 
	$lastSlideIndex = 0;
	for($i=0; $i<$slidesCount; $i++) : ?>
	<div class="item <?php echo ($i==0)?'active':'';?>">
		<?php $nextLimit = ($i+1) * $total_per_slide; ?>
		<?php for($j=$lastSlideIndex,$columnIndex=1; $j<$nextLimit; $j++, $lastSlideIndex++, $columnIndex++) : ?>		
			<?php if($j%$bootstrap_carousel_thumbs_per_row == 0): ?>		
			<div class="row">
			<?php endif; ?>
	<div class="col-md-<?php echo $boostrap_col_size; ?>">
					<?php if(!empty($items[$lastSlideIndex]["link"])): ?><a href="<?php echo $items[$lastSlideIndex]["link"]; ?>" title="<?php echo $items[$lastSlideIndex]["title"]; ?>" target="<?php echo empty($items[$lastSlideIndex]["link_target"])?'_blank':$items[$lastSlideIndex]["link_target"]; ?>"><?php endif; ?>
					<div class="showcase-slide" style="background-image:url(<?php echo $items[$lastSlideIndex]["filepath"]; ?>)"></div>
					<?php if(!empty($items[$lastSlideIndex]["link"])): ?></a><?php endif; ?>
				</div>	
			<?php if($columnIndex == $bootstrap_carousel_thumbs_per_row): $columnIndex = 0; ?>
			</div><!-- row <?php echo ($j%$bootstrap_carousel_thumbs_per_row-1)."j=".($j)." and (bootstrap_carousel_thumbs_per_row) = ".($bootstrap_carousel_thumbs_per_row-1); ?>-->
			<?php endif; ?>
		<?php endfor; // for per Item?>
			
		</div> <!-- item <?php echo " ---- lastSlideIndex = ".$lastSlideIndex; ?> -->
	<?php endfor; // for per Slides?>
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
</div>