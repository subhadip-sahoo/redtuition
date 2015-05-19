<!-- Start Footer -->
<footer>
    <section class="footer-top">
        <?php if(is_active_sidebar('sidebar-2')){ dynamic_sidebar('sidebar-2');}?>
    </section>
    <section class="footer-bottom">
        <?php if(is_active_sidebar('sidebar-3')){ dynamic_sidebar('sidebar-3');}?>
        <br class="Clear">
    </section>
    <!-- jQuery -->
    <script src="<?php echo get_template_directory_uri();?>/js/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="<?php echo get_template_directory_uri();?>/js/libs/jquery-1.7.min.js">\x3C/script>')</script>

    <!-- FlexSlider -->
    <script defer src="<?php echo get_template_directory_uri();?>/js/jquery.flexslider.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/js/jquery.validationEngine-en.js"></script>
    <script src="<?php echo get_template_directory_uri();?>/js/jquery.validationEngine.js"></script>
    <script type="text/javascript">
      $(function(){
        //SyntaxHighlighter.all();
            $('#red_registration').validationEngine();
      });
      $(window).load(function(){
        $('.flexslider').flexslider({
          animation: "slide",
          pauseOnHover: true,
          start: function(slider){
            $('body').removeClass('loading');
          }
        });
        $('.flexslider1').flexslider({
              animation: "slide",
              animationLoop: true,
              slideshowSpeed: 20000,
              itemWidth: 310,
              itemMargin: 2,
              minItems: 1,
              maxItems: 2
        });
      });
	  
	  $(".video").fitVids();
	  
    </script>
    <script src="<?php echo get_template_directory_uri();?>/js/jquery.meanmenu.js"></script>
    <script type="text/javascript">
        jQuery(document).ready(function () {
            jQuery('nav').meanmenu({
                meanMenuContainer : '.mnu',
                meanScreenWidth: '767'
            });
        });
    </script>
    
	<script type="text/javascript" src="<?php echo get_template_directory_uri();?>/js/smk-accordion.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function($){
			$(".accordion_student").smk_Accordion({
				closeAble: true, //boolean
			});			
		});
	</script>
    
</footer>
<?php wp_footer();?>
</body>
</html>