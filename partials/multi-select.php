<select class="widefat" name='t3_schema[t3-schema-post-types][]' multiple >
    <?php foreach( $args[ 'post_types' ] as $post_type ) : ?>
        <?php $post_type_object = get_post_type_object( $post_type ); ?>
        <option
            style="padding:8px"
            value='<?php echo $post_type;?>'
            <?php selected( in_array( $post_type, $args[ 'options' ] ), true );?>
        >
            <?php echo $post_type_object->label;?>
        </option>
    <?php endforeach; ?>
</select>
