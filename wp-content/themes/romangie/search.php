<?php get_header(); ?>
<?php if ( is_active_sidebar( 'primary' ) ) {
	$romangie_left_col_class = "col-md-9 indexpage";
	$romangie_right_col_class= "col-md-3 visible-lg visible-md";
	$romangie_content_class = "col-sm-9 content format-" . get_post_format();
} else {
	$romangie_left_col_class = "col-md-12 indexpage";
	$romangie_right_col_class= "hidden-xs";
	$romangie_content_class = "col-sm-9 col-md-8 content format-" . get_post_format();
}
?>
	<div class="row">
		<div class="<?php echo $romangie_left_col_class; ?>">

		<?php if (have_posts()) : ?>

 			<?php $post = $posts[0]; // Hack. Set $romangie_post so that the_date() works. ?>
            <div id="title_archives" class="entry-title">

				<h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'twentythirteen' ), get_search_query() ); ?></h1>

			</div>

			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php $romangie_countComments = wp_count_comments(get_the_ID()); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('row post-roll'); ?>>
						<div class="col-sm-3 meta info hidden-xs">
							<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'romangie'), get_the_title()); ?>">
								<?php 
								if( has_post_format( ' quote' ) ) {
									echo '<span data-icon="&#x7b;" class="metaicon"></span>';
								} elseif ( has_post_format( 'status' ) ) {
									echo '<span data-icon="&#x6a;" class="metaicon"></span>';
								} elseif ( has_post_format( 'video' ) ) {
									echo '<span data-icon="&#xe024;" class="metaicon"></span>';
								} elseif ( has_post_format( 'audio' ) ) {
									echo '<span data-icon="&#xe069;" class="metaicon"></span>';
								} elseif ( has_post_format( 'chat' ) ) {
									echo '<span data-icon="&#xe066;" class="metaicon"></span>';
								} elseif ( has_post_format( 'image' ) ) {
									echo '<span data-icon="&#xe005;" class="metaicon"></span>';
								} elseif ( has_post_format( 'gallery' ) ) {
									echo '<span data-icon="&#xe006;" class="metaicon"></span>';
								} elseif ( has_post_format( 'link' ) ) {
									echo '<span data-icon="&#xe02b;" class="metaicon"></span>';
								} elseif ( has_post_format( 'aside' ) ) {
									echo '<span data-icon="&#xe057;" class="metaicon"></span>';
								} else {
									echo '<span data-icon="&#xe058;" class="metaicon"></span>';
								}
								?>
							</a>
							<hr class="metaline" />
							<div class="additional-meta">
								<div class="meta-item"><a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) );?>"><span data-icon="&#xe08a;" class="info-icon"></span><?php the_author(); ?></a></div>
								<div class="meta-item"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'romangie'), get_the_title()); ?>"><span data-icon="&#xe023;" class="info-icon"></span><?php echo get_the_date(); ?></a></div>
								<div class="meta-item"><a href="<?php the_permalink(); ?>#comments" rel="bookmark" title="<?php _e('Go to comment section', 'romangie'); ?>"><span data-icon="&#xe065;" class="info-icon"></span><?php printf( _n( '%1$s Comment', '%1$s Comments', get_comments_number(), 'romangie' ), number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' ); ?></a></div>
								<?php if ( has_category() ) { ?><div class="meta-item"><?php _e('Categories:', 'romangie' ); ?><?php the_category(); ?></div><?php } ?>
								<?php if ( has_tag() ) { ?><div class="meta-item"><?php _e('Tags:', 'romangie' ); the_tags('<ul><li>','</li><li>','</li></ul>'); ?></div><?php } ?>
								<?php edit_post_link(__( 'Edit this entry.', 'romangie') , '<div class="meta-item">', '</div>'); ?>
							</div>
						</div>
						<div class="<?php echo $romangie_content_class; ?>">
							<h2 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php printf( __('Permalink to %s', 'romangie'), get_the_title()); ?>"><?php the_title(); ?></a></h2>
							<div class="entry"><?php the_excerpt(); ?></div>
								<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'romangie' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>

						</div>
					 </div>
			<?php endwhile; ?>
			<?php else : ?>

				<h2><?php _e('Not Found', 'romangie') ?></h2>

			<?php endif; ?>
			<div class="pagenav page-links row">
				<div class="next-posts pagination-item col-xs-6 col-sm-offset-3 col-sm-4"><?php next_posts_link('&laquo; ' . __('Older Entries', 'romangie') ) ?></div>
				<div class="prev-posts pagination-item col-xs-6 col-sm-offset-1 col-sm-4"><?php previous_posts_link( __('Newer Entries', 'romangie') . ' &raquo;') ?></div> 
			</div>

		<?php endif; ?>
		</div>
		<div class="<?php echo $romangie_right_col_class; ?>">
			<?php get_sidebar('primary'); ?>
		</div>
</div>

<?php get_footer(); ?>
