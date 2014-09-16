<?php wp_footer(); ?>
	<div class="footer row">
			<div class="col-md-3 col-md-offset-1 col-sm-4 info sidebar">
				<?php dynamic_sidebar( 'leftfooter' ); ?>
			</div>
			<div class="col-md-3 col-md-offset-1 col-sm-4 info sidebar">
				<?php dynamic_sidebar( 'middlefooter' ); ?>
			</div>
			<div class="col-md-3 col-md-offset-1 col-sm-4 info sidebar">
				<?php dynamic_sidebar( 'rightfooter' ); ?>
			</div>
	</div>	
	<div class="siteinfo row">
		<div class="col-xs-10 col-xs-offset-1">
		<p><?php printf( __( 'Copyright &copy; %1$s. Powered by <a href="%2$s">WordPress</a> &amp; <a href="%3$s">Romangie Theme</a>.'), date('Y'), 'http://www.wordpress.org/', 'http://themes.tobscore.com/romangie/'); ?></p>
		</div>
	</div>
</div> <!-- /footer -->
<?php wp_footer(); ?>
</body>
</html>
