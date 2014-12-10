<?php

function FaqForm( $faq = null, $question = null, $answer = null, $edit = false, $categories = '', $active_categories = null )
{
    ?>
    <input
        type="text"
        name="wp_responsive_faq_question"
        size="30"
        class="widefat wp_ajax_faq_question_edit"
        value="<?php echo esc_attr( $question ) ?>"
        <?php if( !$edit ): ?>
        id="wp_responsive_faq_question"
        <?php endif; ?>
        placeholder="Write your question"
        autocomplete="off">

    <span id="titlewrap" class="category_collection new_faq">
    <span style="">Categories :</span><br>
        <!-- Start Form Here -->
        <?php if( $faq ): ?>
            <?php foreach( $categories as $key => $value ) : ?>
                <?php
                $rowCount = '';
                ?>
                <span style="margin:5px; float: left;">
                    <input
                        type="checkbox"
                        name="categories[]"
                        class="wp_responsive_faq_category<?php echo ($edit) ? '_edit' : ''; ?>"
                        value="<?php echo esc_attr( $key ) ?>"
                        <?php echo in_array( $key, $active_categories ) ? 'checked' : ''; ?> >
                    <?php echo ucwords( esc_attr( $value ) ) ?>
                </span>
            <?php endforeach; ?>
        <?php else: ?>
            <?php foreach( $categories as $key => $value ) : ?>
            <span style="margin:5px; float: left;">
                <input
                    type="checkbox"
                    name="categories[]"
                    class="wp_responsive_faq_category<?php echo ($edit) ? '_edit' : ''; ?>"
                    value="<?php echo esc_attr( $key ) ?>" >
                <?php echo ucwords( esc_attr( $value ) ) ?>
            </span>
            <?php endforeach; ?>
        <?php endif; ?>
    </span>

    <br/>

    <textarea
        class="widefat wp_ajax_faq_answer_edit"
        rows="10"
        name="wp_responsive_faq_answer"
        <?php if( !$edit ): ?>
        id="wp_responsive_faq_answer"
        <?php endif; ?>
        placeholder="Write your answer"><?php echo esc_attr( $answer ) ?></textarea>

    <br/>
    <?php
}

function Category( $id, $category )
{
    ?>
    <p>
        <input type="hidden" class="category_id" value="<?php echo esc_attr( $id ) ?>">
        <input type="text" name="edit_category" style="display: none;" class="edit_category" value="<?php echo esc_attr( ucwords( $category ) ) ?>">
        <span class="category_name"><?php echo ucwords( $category ) ?></span>
        <?php if( $id == 1 ) : ?>
            <span class="category_edit_links">
                <a href="#" class="category_edit">Edit</a>
            </span>
        <?php else: ?>
            <span class="category_edit_links">
                <a href="#" class="category_edit">Edit</a> | <a href="#" class="category_delete">Delete</a>
            </span>
        <?php endif; ?>
        <br/>
        <span class="category_update_links" style="display:none;">
            <a href="#" class="category_update">Update</a> | <a href="#" class="category_cancel">Cancel</a>
        </span>
    <p>
    <?php
}

function CategoryList()
{
    global $wpdb;
    $table_name             = $wpdb->prefix . WP_RESPONSIVE_FAQ_TABLE_NAME;
    $category_table_name    = $wpdb->prefix . WP_RESPONSIVE_FAQ_CATEGORIES_TABLE_NAME;
    $faq_cat_table_name     = $wpdb->prefix . WP_RESPONSIVE_FAQ_CAT_TABLE_NAME;

    $output = '';
    $output .= '<div class="category-block">';

    $output .= '<a href="#" class="category-admin" id="0">All</a> ';
    $category_list = $wpdb->get_results('SELECT * FROM ' . $category_table_name, ARRAY_A);
    foreach ($category_list as $category) {
        $output .= '<a href="#" id="cat' . $category['id'] . '" class="category-admin"> | ' . ucwords($category['name']) . '</a>';
    }

    $output .= '</div>';
    return $output;
}

function FaqBlock()
{
    ?>
    <div class="faq-block">
        <h3 class="panel-title"><span class="ques-icon">Q:</span>Article 2</h3>
        <div class="panel-content">
            <p>Curabitur sed placerat mi, quis consectetur quam. Mauris congue ac leo quis laoreet. In rutrum tortor nec
                lectus semper faucibus. Donec ut placerat nunc. Vivamus elementum tortor erat, a pulvinar massa cursus
                vitae. Quisque porta neque a nisl porttitor, vel dictum mauris gravida. Donec in arcu ligula.
                Suspendisse vitae volutpat turpis, ac fringilla mauris. Vivamus posuere ipsum in mi tempor, at efficitur
                leo sollicitudin. Sed laoreet, ligula sit amet euismod scelerisque, tortor quam luctus odio, at pharetra
                tortor ante in metus. Phasellus orci erat, pretium eget elit ut, dignissim varius ipsum.</p>
        </div>
    </div>
    <?php
}

?>