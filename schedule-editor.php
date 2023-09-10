<?php
/*
Plugin Name: Schedule Editor
Description: Create a Schedule editing widget for displaying a schedure
Version: 2.0
Author: Hanna, Araceli, Terese, June, and Fosiya.
Text Domain: schedule-editor
*/

function schedule_content_register_post_type()
//Register a custom posttype for holding schedule-specific content
{
    $labels = array(
        'name' => __('Schedule contents', 'schedule-editor'),
        'singular_name' => __('Schedule content', 'schedule-editor'),
        'add_new' => __('Add new lesson', 'schedule-editor'),
        'add_new_item' => __('Add New lesson', 'schedule-editor'),
        'edit_item' => __('Edit lesson', 'schedule-editor'),
        'new_item' => __('New lesson', 'schedule-editor'),
        'view_item' => __('View lesson', 'schedule-editor'),
        'search_items' => __('Search lessons', 'schedule-editor'),
        'not_found' => __('No lessons Found', 'schedule-editor'),
        'not_found_in_trash' => __('No lessons found in Trash', 'schedule-editor'),
    );
    $args = array(
        'labels' => $labels,
        'has_archive' => true,
        'public' => true,
        'hierarchical' => false,
        'supports' => array(
            //'title',
            // 'editor', 
            'excerpt', 
            //'custom-fields',
           // 'thumbnail',
            // 'page-attributes'
        ),
        'rewrite' => array('slug' => 'schedule_content'),
        'show_in_rest' => true,
        'menu_position' => 2,
    );
    register_post_type('schedule_content', $args);
}

add_action('init', 'schedule_content_register_post_type');
//Registers post-type on init hook


function schedule_content_register_taxonomies()
//Register new taxonomies linked to schedule_contents
{
    //Adds a category for the class-subjects
    $labelsSubject = array(
        'name' => __('Subjects', 'schedule-editor'),
        'singular_name' => __('Subject', 'schedule-editor'),
        'search_items' => __('Search Subjects', 'schedule-editor'),
        'all_items' => __('All Subjects', 'schedule-editor'),
        'edit_item' => __('Edit Subject', 'schedule-editor'),
        'update_item' => __('Update Subjects', 'schedule-editor'),
        'add_new_item' => __('Add New Subject', 'schedule-editor'),
        'new_item_name' => __('New Subject Name', 'schedule-editor'),
        'menu_name' => __('Subjects', 'schedule-editor'),
    );

    $argsSubject = array(
        'labels' => $labelsSubject,
        'hierarchical' => true,
        'sort' => true,
        'args' => array('orderby' => 'term_order'),
        'rewrite' => array('slug' => 'subject'),
        'show_admin_column' => true,
        'show_in_rest' => true
    );
    register_taxonomy('schedule_subject', array('schedule_content'), $argsSubject);
//TODO: Explore if possible to preset weekday contents and remove from admin-menu
    //Adds a category for the weekdays
    $labelsWeekday = array(
        'name' => __('Weekday', 'schedule-editor'),
        'singular_name' => __('Weekday', 'schedule-editor'),
        'search_items' => __('Search Weekdays', 'schedule-editor'),
        'all_items' => __('All Weekdays', 'schedule-editor'),
        'edit_item' => __('Edit Weekday', 'schedule-editor'),
        'update_item' => __('Update Weekdays', 'schedule-editor'),
        'add_new_item' => __('Add New Weekday', 'schedule-editor'),
        'new_item_name' => __('New Weekday Name', 'schedule-editor'),
        'menu_name' => __('Weekdays', 'schedule-editor'),
    );

    $argsWeekday = array(
        'labels' => $labelsWeekday,
        'hierarchical' => true,
        'sort' => true,
        'args' => array('orderby' => 'term_order'),
        'rewrite' => array('slug' => 'subject'),
        'show_admin_column' => true,
        'show_in_rest' => true
    );
    register_taxonomy('schedule_weekday', array('schedule_content'), $argsWeekday);

       //Adds a category for the start-times of the class
    $labelsStarttime = array(
        'name' => __('Start time', 'schedule-editor'),
        'singular_name' => __('Start time', 'schedule-editor'),
        'search_items' => __('Search Start times', 'schedule-editor'),
        'all_items' => __('All Start times', 'schedule-editor'),
        'edit_item' => __('Edit Start time', 'schedule-editor'),
        'update_item' => __('Update Start times', 'schedule-editor'),
        'add_new_item' => __('Add New Start time', 'schedule-editor'),
        'new_item_name' => __('New Start time Name', 'schedule-editor'),
        'menu_name' => __('Start times', 'schedule-editor'),
    );

    $argsStarttime = array(
        'labels' => $labelsStarttime,
        'hierarchical' => true,
        'sort' => true,
        'args' => array('orderby' => 'term_order'),
        'rewrite' => array('slug' => 'starttime'),
        'show_admin_column' => true,
        'show_in_rest' => true
    );

    register_taxonomy('schedule_starttime', array('schedule_content'), $argsStarttime);
    //Adds a category for the end-times of the class
    $labelsEndtime = array(
        'name' => __('End time', 'schedule-editor'),
        'singular_name' => __('End time', 'schedule-editor'),
        'search_items' => __('Search End times', 'schedule-editor'),
        'all_items' => __('All End times', 'schedule-editor'),
        'edit_item' => __('Edit End time', 'schedule-editor'),
        'update_item' => __('Update End times', 'schedule-editor'),
        'add_new_item' => __('Add New End time', 'schedule-editor'),
        'new_item_name' => __('New End time Name', 'schedule-editor'),
        'menu_name' => __('End times', 'schedule-editor'),
    );

    $argsEndtime = array(
        'labels' => $labelsEndtime,
        'hierarchical' => true,
        'sort' => true,
        'args' => array('orderby' => 'term_order'),
        'rewrite' => array('slug' => 'end'),
        'show_admin_column' => true,
        'show_in_rest' => true
    );

    register_taxonomy('schedule_endtime', array('schedule_content'), $argsEndtime);

}
add_action('init', 'schedule_content_register_taxonomies');
//Adds the taxonomies to the schedule_content post-type


function schedule_content_styles()
//Adds specific styling for schedule
{
    wp_enqueue_style('schedule', plugin_dir_url(__FILE__) . '/css/schedule.css');
}
add_action('wp_enqueue_scripts', 'schedule_content_styles');

class Custom_Schedule_Widget extends WP_Widget
//Creates a new custom schedule-widgett?
{
    public function __construct()
    {
        parent::__construct(
            'Custom_Schedule_Widget',
            'Custom Schedule Widget',
            array(
                'description' => 'Displays the schedule as a widget.',
            )
        );
    }
    public function widget($args, $instance)
    {
        include(plugin_dir_path(__FILE__) . 'schedule-editor-template.php');
    }
    public function shortcode()
    {
        ob_start();
        $this->widget(array(), array());
        return ob_get_clean();
    }
}
function custom_schedule_shortcode_widget()
{
    $widget = new Custom_Schedule_Widget();//Returns a new instace of the widget where shortcode is found?
    return $widget->shortcode();
}
function register_schedule_widget()
{
    register_widget('Custom_Schedule_Widget');
}
add_shortcode('Custom-Schedule-Widget', 'custom_schedule_shortcode_widget');//Registers custom schedule widget
add_action('widgets_init', 'register_schedule_widget');//Registers schedule-widget on widgit init.
