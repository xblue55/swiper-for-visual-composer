<div class="swiper-slide" style="min-height:334px">
    <?php the_post_thumbnail('large', array('style' => 'height:' . $height . ';')); ?>
    <div class="text-container swiper-middle-pos">
        <div class="title"><?php the_title(); ?></div>
        <div class="desc"><?php echo wp_trim_words(get_the_excerpt(), 40); ?></div>
    </div>
</div>