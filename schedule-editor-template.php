<div class="schedule">
    <?php
    $weekarray = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday');
    foreach ($weekarray as $value) {
        ?>
        <div class=weekday-container>
            <div class=weekday-heading>
                <?php
                echo '<h3>' . ucfirst($value) . '</h3>  ';
                ?>
            </div>

            <?php
//Query for each weekday ($value) and fetch all schedule_contents for this day. Order asc by starttime.
            $the_query = new WP_Query(
                array(
                    'post_type' => 'schedulecontent',
                    'posts_per_page' => -1,
                    'orderby' => 'schedule_starttime',
                  'order' => 'asc',
                    'tax_query' => array(
                        array(
                            'taxonomy' => 'schedule_weekday',
                            'field' => 'slug',
                            'terms' => $value,
                        )
                    )
                )
            );

            while ($the_query->have_posts()):
                $the_query->the_post();
                ?>
                <div class="schedule-entry">
                    <?php 


                    //Get all info to be displayed for each post
                    
                    $lesson_terms = get_the_terms($the_query->ID, 'schedule_subject');
                    if (!empty($lesson_terms) && is_array($lesson_terms) && isset($lesson_terms[0]->name)) {
                        $lesson_name = $lesson_terms[0]->name;
                    } else {
                        $lesson_name = '';
                    }
                    
                    
                    $start_time_terms = get_the_terms($the_query->ID, 'schedule_starttime');
                    if (!empty($start_time_terms) && is_array($start_time_terms) && isset($start_time_terms[0]->name)) {
                        $start_time = $start_time_terms[0]->name;
                    } else {
                        $start_time = '1';
                    }

                    $end_time_terms = get_the_terms($the_query->ID, 'schedule_endtime');
                    if (!empty($end_time_terms) && is_array($end_time_terms) && isset($end_time_terms[0]->name)) {
                        $end_time = $end_time_terms[0]->name;
                    } else {
                        $end_time = '';
                    }


                    //Use separate template for lesson-contents due to readability
                    include(plugin_dir_path(__FILE__) . 'schedule-content-template.php');
                    ?>
                </div>
                <?php
            endwhile;
            ?>
        </div>
        <?php


    }
    ?>

</div>