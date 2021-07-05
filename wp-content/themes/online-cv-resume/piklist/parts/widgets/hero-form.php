<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
piklist('field', array(
    'type' => 'text',
    'field' => 'heading',
    'label' => esc_html__( 'Title', 'online-cv-resume' ),
    'description' => esc_attr__( 'Add hero heading', 'online-cv-resume' ),
    'attributes' => array(
      'class' => 'widefat online-cv-heading'
    )
));
piklist('field', array(
    'type' => 'text',
    'field' => 'heading-2nd',
    'label' => esc_html__( '2nd heading', 'online-cv-resume' ),
    'description' => esc_attr__( 'Add 2nd heading', 'online-cv-resume' ),
    'attributes' => array(
      'class' => 'widefat online-cv-heading'
    )
));

piklist('field', array(
    'type' => 'file',
    'field' => 'bg_image',
    'label' => esc_html__( 'Background Image', 'online-cv-resume' ),
    'options' => array(
      'modal_title' => esc_attr__( 'Upload Image', 'online-cv-resume' ),
      'button' => esc_attr__( 'Add Image', 'online-cv-resume' ),
    )
));

piklist('field', array(
    'type' => 'group'
    ,'field' => 'hero_btn_group'
    ,'label' => esc_html__('Add Profile Button', 'online-cv-resume')
    ,'add_more' => true
    ,'description' => __('A grouped/addmore Button.', 'online-cv-resume')
    ,'fields' => array(
		  array(
			'type' => 'text',
			'field' => 'btn_text',
			'label' => esc_html__( 'Button', 'online-cv-resume' ),
			'description' => esc_html__( 'Add hero heading', 'online-cv-resume' ),
			'attributes' => array(
			  'class' => 'widefat button-text'
		  )),
		   array(
			'type' => 'text',
			'field' => 'btn_link',
			'label' => esc_html__( 'Button link', 'online-cv-resume' ),
			'description' => esc_html__( 'Add Button link', 'online-cv-resume' ),
			'attributes' => array(
			  'class' => 'widefat btn-text'
		  )),
    )
));

