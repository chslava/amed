<li class="menu-item menu-item-depth-0 menu-item-page pending menu-item-edit-inactive" style="display: list-item; position: relative; top: 0px;">

<?php
	
	/**
	 * Read global critical CSS
	 */
	$inlinecss = '';
	$cssfile = $this->CTRL->cache_path() . 'criticalcss_global.css';
	if (file_exists($cssfile)) {
		$inlinecss = file_get_contents($cssfile);
	}

?>
	<div class="menu-item-bar criticalcss-edit-header" rel="global">
		<div class="menu-item-handle" style="width:auto!important;cursor: pointer;">
			<span class="item-title">
				<span class="menu-item-title">Global</span>
				<span class="is-submenu" ><?php if (trim($inlinecss) !== '') { print '<span>'.size_format(strlen($inlinecss),2).'</span>'; } else { print '<span style="color:#f1b70a;">empty</span>';} ?>
				</span>
				<span class="is-submenu loading-editor" style="display:none;">
					<span style="color:#ea4335;">Loading editor...</span>
				</span>
			</span>
			<span class="item-controls">
				<a class="item-edit" href="javascript:void(0);">^</a>
			</span>
		</div>
	</div>

	<div id="ccss_editor_global" class="ccss_editor">
		<textarea class="abtfcss" id="abtfcss"<?php if (!isset($options['csseditor']) || intval($options['csseditor']) === 1) { print 'data-advanced="1"'; } ?> name="abovethefold[css]"><?php echo htmlentities($inlinecss,ENT_COMPAT,'utf-8'); ?></textarea>

		<!-- .menu-item-settings-->
	
		<div class="criticalcss-buttons">
		<a href="https://www.google.com/search?q=beautify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Beautify</a>
		<a href="https://www.google.com/search?q=minify+css+online&amp;hl=<?php print $lgcode;?>" target="_blank" class="button button-secondary button-small">Minify</a>
		<a href="https://jigsaw.w3.org/css-validator/#validate_by_input+with_options" target="_blank" class="button button-secondary button-small">Validate</a>
		<a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank" class="button button-secondary button-small">CSS<span style="color:#768c1c;font-weight:bold;margin-left:1px;">LINT</span></a>
		</div>
		<div class="criticalcss-editorswitch">
			<label><input type="checkbox" name="abovethefold[csseditor]" value="1"<?php if (!isset($options['csseditor']) || intval($options['csseditor']) === 1) { print ' checked=""'; } ?>> Use a CSS editor with error reporting (<a href="http://csslint.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">CSS Lint</a> using <a href="https://codemirror.net/#utm_source=wordpress&amp;utm_medium=plugin&amp;utm_term=optimization&amp;utm_campaign=PageSpeed.pro%3A%20Above%20The%20Fold%20Optimization" target="_blank">CodeMirror</a>).</label>
		</div>

		<div style="clear:both;height:1px;overflow:hidden;font-size:1px;">&nbsp;</div>


		<ul class="menu-item-transport"></ul>


		<hr />
		<?php
			submit_button( __( 'Save' ), 'primary large', 'is_submit', false );
		?><a name="conditional">&nbsp;</a>

	</div>
</li>