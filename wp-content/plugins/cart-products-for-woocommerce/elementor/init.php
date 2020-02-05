<?php

// Exit if accessed directly
if( ! defined( 'ABSPATH' ) ) exit();


if ( !class_exists( 'WCCP_Elementor_Init' ) ) {

    class WCCP_Elementor_Init{

        public function __construct(){

            add_action( 'elementor/widgets/widgets_registered', array( $this, 'include_widgets' ) );
            add_action( 'init', array( $this, 'register_scripts' ) );
            add_action( 'wp_enqueue_scripts', array( $this,'enqueue_frontend_scripts' ) );
            add_action( 'admin_enqueue_scripts', array( $this,'enqueue_admin_scripts') );

        }

        // Include Widgets File
        public function include_widgets(){
            if ( file_exists( WCCP_PATH.'elementor/wccp-widget.php' ) ) {
                require_once WCCP_PATH.'elementor/wccp-widget.php';
            }
        }

        public function enqueue_admin_scripts() {

        }

        // Register frontend scripts
        public function register_scripts(){
            

        }

        // enqueue frontend scripts
        public function enqueue_frontend_scripts(){

        }


    }
    new WCCP_Elementor_Init();

}