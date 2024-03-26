<?php namespace t3\schema; ?>

<div <?php echo get_block_wrapper_attributes( [ 'style' => get_block_styles( $attributes ) ] ); ?>>
	<div class="wp-block-t3-faq-list" id="t3-faq">
		<?php foreach( (array) json_decode( get_post_meta( get_the_ID(), 't3-faq', true ) ) as $key => $faq ) : ?>
			<div class="wp-block-t3-faq-item">
				<h3 class="wp-block-t3-faq-header" id="heading-<?php echo $key; ?>">
					<button 
						class="wp-block-t3-faq-button <?php if( $key === 0 ) echo 'wp-block-t3-faq-button--active'; ?>"
						type="button"
						data-t3-toggle="collapse"
						data-t3-target="#collapse-<?php echo $key; ?>"
						aria-expanded="false"
						aria-controls="collapse-<?php echo $key; ?>"
					>
						<?php echo $faq->question; ?>
					</button>
				</h3>
				<div
					id="collapse-<?php echo $key; ?>"
					class="wp-block-t3-faq-collapse <?php if( $key === 0 ) echo 'wp-block-t3-faq-collapse--active'; ?>"
					aria-labelledby="heading-<?php echo $key; ?>"
					data-t3-parent="#t3-faq"
				>
					<div class="wp-block-t3-faq-body">
						<?php echo $faq->answer; ?>
					</div>
				</div>
			</div>
		<?php endforeach; ?>
	</div>
</div>
