<?php
/*
Plugin Name: Schedule Editor
Description: Create a Schedule editing widget for collecting user opinions.
Version: 1.0
Author: Hanna, Araceli, Terese, June, and Fosiya.
*/

// Gör formuläret till en widget

class schedule_editor_widget extends WP_Widget {
    public function __construct() {
        parent::__construct(
            'custom_feedback_form_widget',
            'Custom Feedback Form Widget',
            array(
                'description' => 'Displays the custom feedback form as a widget.',
            )
        );
    }

    // Lägg till widgeten i sidofältet
    public function widget($args, $instance) {

        echo $args['before_widget'];
        echo $args['before_title'] . 'Schedule Editor' . $args['after_title'];
        include(plugin_dir_path(__FILE__) . 'schedule-editor-template.php');
        echo $args['after_widget'];
    }

    public function shortcode() {
        ob_start();
        $this->widget(array(), array());
        return ob_get_clean();
    }
}
//Så man kan lägga till Widgeten i sidofältet med en shortcode
function schedule_editor_shortcode_widget() {
    $widget = new schedule_editor_widget();
    return $widget->shortcode();
}
add_shortcode('schedule_editor_widget', 'schedule_editor_shortcode_widget');

//Registrera widgeten
function register_schedule_editor_widget() {
    register_widget('schedule_editor_widget');
}
add_action('widgets_init', 'register_schedule_editor_widget');

// Stil för feedbackformuläret
function enqueue_schedule_editor_styles () {
    wp_enqueue_style('schedule_editor_styles', plugin_dir_url(__FILE__) . 'css/schedule-editor.css');
}
add_action('wp_enqueue_scripts', 'enqueue_schedule_editor_styles');


function custom_schedule_editor_shortcode_page() {
    ob_start();
    include(plugin_dir_path(__FILE__) . 'schedule-editor-template.php');
    return ob_get_clean();
}
add_shortcode('schedule-editor', 'custom_schedule_editor_shortcode_page');
?>