<?php

use \Diviner\Post_Types\Diviner_Field\Diviner_Field;
use Diviner\Post_Types\Diviner_Field\PostMeta;
use Diviner\Post_Types\Archive_Item\Post_Meta;
use Diviner\CarbonFields\Helper;


?>

<?php get_header(); ?>

<section class="section">
    <div class="wrapper">
        <div class="content">

            <?php if (have_posts()) : ?>
                <?php while (have_posts()) : the_post() ?>

					<?php
					echo get_the_ID();
					?>

					<?php
					// Helper::get_real_field_name(Post_Meta::FIELD_TYPE )
					echo carbon_get_the_post_meta( Post_Meta::FIELD_TYPE );
					?>

                    <?php
                        /**
                         * Functions hooked into `theme/single/content` action.
                         *
                         * @hooked Tonik\Theme\App\Structure\render_post_content - 10
                         */
                        do_action('theme/single/content');
                    ?>

                <?php endwhile; ?>
            <?php endif; ?>
        </div>


		<div>

			<?php



			/*
			$field_query = new \WP_Query( array(
				'post_type' => Diviner_Field::NAME,
				'meta_query'=> array(
					array(
						'key'     => Helper::get_real_field_name(FieldPostMeta::FIELD_ACTIVE ),
						'value'   => FieldPostMeta::FIELD_CHECKBOX_VALUE
					),
				),
			) );

			$dyn_fields = [];

			// $type = carbon_get_post_meta( $cptid, Post_Meta::FIELD_TYPE );
			while( $field_query->have_posts() ) : $field_query->the_post();
				// add fields
				// var_dump('field dsf fsdndfs kf sdkkdfs hkfdshkdfs hkdfs hkdfs kh dshksd hk l dslda jsl asdjl asdjlsd jaljlasddas jldlajsdlajs lj dsalsadj ljasd');

				$type = $this->get_class( get_post() );
				// var_dump(get_post());
				// var_dump($type);

				$dyn_fields[] = $this->get_field( $type );

				//the_title();
				//the_excerpt();


			endwhile;
			wp_reset_postdata();
			*/




			?>


		</div>

        <?php if (apply_filters('theme/single/sidebar/visibility', false)) : ?>
            <?php
                /**
                 * Functions hooked into `theme/single/sidebar` action.
                 *
                 * @hooked Tonik\Theme\App\Structure\render_sidebar - 10
                 */
                do_action('theme/single/sidebar');
            ?>
        <?php endif; ?>
    </div>
</section>

<?php get_footer(); ?>
