

<?php $footerscript = stripslashes(klasik_get_option('klasik_footerscript'));?>
<?php if($footerscript=="false"){?>
<?php }else{?>
<script>
<?php echo $footerscript; ?>
</script>
<?php } ?>
<?php
	/* Always have wp_footer() just before the closing </body>
	 * tag of your theme, or you will break many plugins, which
	 * generally use this hook to reference JavaScript files.
	 */

	wp_footer();
?>
</body>
</html>
