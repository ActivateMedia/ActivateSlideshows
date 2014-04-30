<?php // no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); ?>
<?php	

$slides = count($items);
$thumbs = count($items);
$rows_of_thumbs = ceil($thumbs / $bootstrap_carousel_thumbs_per_row);
$bootstrap_thumb_column_size = round(12 / $bootstrap_carousel_thumbs_per_row, 0, PHP_ROUND_HALF_UP);

echo '<script type="text/javascript">
var bootstrap_carousel_id = "'.$bootstrap_carousel_id.'";
var bootstrap_carousel_thumbs_per_row = "'.$bootstrap_carousel_thumbs_per_row.'";
var items_number = "'.count($items).'";
</script>';

if(isset($_GET["dev"]))
{
	echo "<pre>".print_r($items, true)."</pre>";
	echo "Number of slides: ".$slides."<br/>";
	echo "Thumbs per row: ".$bootstrap_carousel_thumbs_per_row."<br/>";
	echo "Number of rows of thumbs: ".$rows_of_thumbs."<br/>";
	echo "bootstrap_thumb_column_size: ".$bootstrap_thumb_column_size."<br/>";
}
?>
				<h1 class="slideshow-title"><?php echo "Slideshow Name"; ?></h1>
                <div id="carousel-bounding-box">
                    <div id="<?php echo $bootstrap_carousel_id; ?>" class="activate-carousel carousel slide"  data-interval="<?php echo $interval; ?>" data-wrap="<?php echo ($wrap==1)?'true':'false'; ?>" <?php if(!empty($pause)) echo 'data-pause="'.$pause.'"'; ?>>
                        <!-- main slider carousel items -->
                        <div class="carousel-inner">
							<?php 
							$i = -1;
							foreach($items as $item) : ?>
								<div class="item <?php echo (++$i==0)?'active':'';?>" data-slide-number="<?php echo $i; ?>">
									<div class="carousel-slide" style="background-image:url(<?php echo $item["filepath"]; ?>)"></div>
									<?php /*<img src="<?php echo $item["filepath"]; ?>" alt="<?php echo $item["title"];?>" class="img-responsive"> */?>
									<?php if($caption) : ?>
									<div class="carousel-caption">
										<a href="<?php echo $item["link"];?>" title="<?php echo (empty($item["description"]))?$item["title"]:$item["description"];?>" <?php if(!empty($item["link_target"])) echo 'target="'.$item["link_target"].'"'; ?>><?php echo $item["title"];?></a>
									</div>
									<?php endif; ?>
								</div>
							<?php endforeach; ?>
                        </div>
						<?php if($arrows_navigation) : ?>
                        <!-- main slider carousel nav controls -->
						<a class="carousel-control left" href="#<?php echo $bootstrap_carousel_id; ?>" data-slide="prev">‹</a>
                        <a class="carousel-control right" href="#<?php echo $bootstrap_carousel_id; ?>" data-slide="next">›</a>
						<?php endif; ?>
                    </div>
                </div>

		
			
			<?php $lastItemIndex = 0; ?>
            <div id="<?php echo $bootstrap_carousel_id; ?>Nav" class="thumbs-carousel carousel <?php if($slide) echo $slide; ?>" data-wrap="<?php echo ($wrap==1)?'true':'false'; ?>" data-interval="false">                
                <!-- Carousel items -->				
                <div class="carousel-inner">
				<?php for($j=0; $j<$rows_of_thumbs; $j++) : ?>
                    <div class="item <?php echo ($j==0)?'active':'';?>">
                        <div class="row thumbs-row">
							<?php $i = 0;
							//foreach($items as $item) 
							$missingToPrint = ($thumbs-$lastItemIndex);
							if($missingToPrint < $bootstrap_carousel_thumbs_per_row)
							{
								$missingFromLastRow = $bootstrap_carousel_thumbs_per_row - $missingToPrint;
							}
							else
							{
								$missingFromLastRow = 0;
							}
							for($itemIndex=$lastItemIndex; $itemIndex < $bootstrap_carousel_thumbs_per_row * ($j+1) - $missingFromLastRow; $itemIndex++) : ?>
                            <div class="thumb-col col-sm-<?php echo $bootstrap_thumb_column_size; ?>">
								<a href="#x">
									<div id="carousel-selector-<?php echo $lastItemIndex; ?>" class="thumb-img <?php echo ($itemIndex==0)?'selected':'';?>" style="background-image:url(<?php echo $items[$lastItemIndex]["filepath"]; ?>)"></div>
									<?php /*<img src="<?php echo $items[$lastItemIndex]["filepath"]; ?>" alt="<?php echo $items[$lastItemIndex]["title"]; ?>" class="img-responsive  thumb-img <?php echo ($itemIndex==0)?'selected':'';?>" id="carousel-selector-<?php echo $lastItemIndex++; ?>">*/ ?>
								</a>
							</div> 
							<?php $lastItemIndex++; ?>
							<?php endfor; ?>
                        </div>
                        <!--/row-->
                    </div>
				<?php endfor; ?>
                    <!--/item-->
                </div>
                <!--/carousel-inner-->
				<?php if($rows_of_thumbs > 1) : ?>
				<a class="left carousel-control" href="#<?php echo $bootstrap_carousel_id; ?>Nav" data-slide="prev">‹</a>
                <a class="right carousel-control" href="#<?php echo $bootstrap_carousel_id; ?>Nav" data-slide="next">›</a>
				<?php endif; ?>
            </div>
			
  <script src="<?php echo Juri::base(); ?>media/<?php echo $module_name; ?>/js/activate.bootstrap.carousel.js" type="text/javascript"></script>
 