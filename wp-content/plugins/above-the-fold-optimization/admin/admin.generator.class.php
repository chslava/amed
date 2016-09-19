
<?php require_once('admin.author.class.php'); ?>


<form method="post" action="<?php echo admin_url('admin-post.php?action=abovethefold_generate'); ?>" class="clearfix">
	<?php wp_nonce_field('abovethefold'); ?>
	<div class="wrap abovethefold-wrapper">
		<div id="poststuff">
			<div id="post-body" class="metabox-holder">
				<div id="post-body-content">
					<div class="postbox">


					<h3 class="hndle">
							<span><?php _e( 'Free and Paid Online Service', 'abovethefold' ); ?></span>
						</h3>
						<div class="inside">

							<p>The author of Penthouse.js (<a href="https://jonassebastianohlsson.com/" target="_blank">website</a>) has made a free and paid online critical path CSS generator available.

							The <a href="http://jonassebastianohlsson.com/criticalpathcssgenerator/" target="_blank">free version</a> has no configuration options but it results in good quality Critical Path CSS code for most websites.</p>

							<p>The paid version can be found at <strong><big><a href="https://criticalcss.com/#utm_source=wordpress&utm_medium=link&utm_term=optimization&utm_campaign=Above%20the%20fold" target="_blank">https://criticalcss.com/</a></big></strong>.</p>


						</div>

						<h3 class="hndle">
							<span><?php _e( 'Professional via automation tools', 'abovethefold' ); ?></span>
						</h3>
						<div class="inside">
							<p>The best method for creating critical path CSS is via professional (Node.js) software using an automation tools such as <a href="http://gruntjs.com/" target="_blank">Grunt.js</a> and <a href="http://gulpjs.com/" target="_blank">Gulp.js</a>. The tools can be used on any platform (Windows, Mac and Linux) and are integrated into most IDE's for easy usage.</p>
							<p>Some of the available tools are:</p>
							<ul>
								<li><a href="https://github.com/pocketjoso/penthouse" target="_blank">Penthouse.js</a> - by Jonas Ohlsson generates critical-path CSS (<a href="https://github.com/fatso83/grunt-penthouse" target="_blank">grunt-penthouse</a>)</li>
								<li><a href="https://github.com/addyosmani/critical" target="_blank">Critical</a> - by Addy Osmani generates & inlines critical-path CSS (uses Penthouse, <a href="https://github.com/addyosmani/oust" target="_blank">Oust</a> and inline-styles) (<a href="https://github.com/bezoerb/grunt-critical" target="_blank">grunt-critical</a>)</li>
								<li><a href="https://github.com/filamentgroup/criticalcss" target="_blank">CriticalCSS</a> - by FilamentGroup finds & outputs critical CSS (<a href="https://github.com/filamentgroup/grunt-criticalcss" target="_blank">grunt-criticalcss</a>)</li>
							</ul>
							<p>More info can be found on the following maintained resource: <a href="https://github.com/addyosmani/critical-path-css-tools" target="_blank">https://github.com/addyosmani/critical-path-css-tools</a></p>

							<div><big>Download example <a href="<?php print plugin_dir_url( __FILE__ ); ?>docs/Gruntfile.js" target="_blank">Gruntfile.js</a> | <a href="<?php print plugin_dir_url( __FILE__ ); ?>docs/package.json" target="_blank">package.json</a> - Command: <code>grunt abovethefold</code></big></div>
							<div style="margin-top:5px;"><em>The example uses <a href="https://github.com/pocketjoso/penthouse" target="_blank">Penthouse.js</a> and several other optimization tools. The example code creates critical path CSS code for multiple pages and dimensions, converts inline images to inline data-uri and optimizes the resulting code using custom replacement (regex) and <a href="https://github.com/gruntjs/grunt-contrib-cssmin" target="_blank">cssmin</a> compression. You can easily add other optimization tools to the process to achieve the best possible result for a specific website.</em></div>
						</div>

					</div>

	<!-- End of #post_form -->

				</div>
			</div> <!-- End of #post-body -->
		</div> <!-- End of #poststuff -->
	</div> <!-- End of .wrap .nginx-wrapper -->
</form>
