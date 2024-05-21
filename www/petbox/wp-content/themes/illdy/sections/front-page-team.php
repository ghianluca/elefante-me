<!--  /*
 *	
 *
 *	@package WordPress
 *	@subpackage illdy
 */  -->
<head>
 <style>
    .scrolloff {
        pointer-events: none;
    }
</style>
<script>
    jQuery(document).ready(function () {
        jQuery('#map').addClass('scrolloff');                // set the mouse events to none when doc is ready
        jQuery('#3dmap').addClass('scrolloff');                // set the mouse events to none when doc is ready
        
        jQuery('#overlay').on("mouseup",function(){          // lock it when mouse up
            jQuery('#map').addClass('scrolloff'); 
            //somehow the mouseup event doesn't get call...
        });
        jQuery('#3doverlay').on("mouseup",function(){          // lock it when mouse up
            jQuery('#3dmap').addClass('scrolloff'); 
            //somehow the mouseup event doesn't get call...
        });

        jQuery('#overlay').on("mousedown",function(){        // when mouse down, set the mouse events free
            jQuery('#map').removeClass('scrolloff');
        });
		jQuery('#3doverlay').on("mousedown",function(){        // when mouse down, set the mouse events free
            jQuery('#3dmap').removeClass('scrolloff');
        });

        jQuery("#map").mouseleave(function () {              // becuase the mouse up doesn't work... 
            jQuery('#map').addClass('scrolloff');            // set the pointer events to none when mouse leaves the map area
                                                        // or you can do it on some other event
        });
        jQuery("#3dmap").mouseleave(function () {              // becuase the mouse up doesn't work... 
            jQuery('#3dmap').addClass('scrolloff');            // set the pointer events to none when mouse leaves the map area
                                                        // or you can do it on some other event
        });
        
    });
</script>
</head>
<body>

<section id="team" class="front-page-section">
	<!--<div onClick="style.pointerEvents='none'" style="background:transparent;position:relative;width:100%;height:480px;top:480px;margin-top:-480px;"></div>-->
					
<div id="overlay" class="map"><iframe id="map" align="center" src="https://www.google.com/maps/d/embed?mid=zLYM3TADvTgg.kxmnWRYYg1NQ" frameborder="0" width="100%" height="480" style="border:0;"></iframe></div>
			</section><!--/#team.front-page-section-->