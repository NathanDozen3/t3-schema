<textarea
    id="<?php echo esc_attr( $args[ 'id' ] ?: '' ); ?>"
    name="t3_schema[<?php echo esc_attr( $args[ 'id' ] ?: '' ); ?>]"
    class="t3-schema"
    rows="5"
    cols="50"
><?php echo esc_attr( $args[ 'value' ] ?: '' ); ?></textarea>