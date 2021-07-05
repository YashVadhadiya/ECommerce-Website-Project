<?php
/**
 * Checkout style tab content.
 *
 * @package CartFlows
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="wcf-checkout-style wcf-tab-content widefat">
	<div class="wcf-cs-fields">
		<div class="wcf-cs-checkbox-field">
			<?php

				$layout_pro_option = array();

			if ( ! _is_cartflows_pro() ) {
				$layout_pro_option = array(
					'one-column' => __( 'One Column (Available in CartFlows Pro) ', 'cartflows' ),
					'two-step'   => __( 'Two Step (Available in CartFlows Pro) ', 'cartflows' ),
				);
			}

				echo wcf()->meta->get_select_field(
					array(
						'label'       => __( 'Checkout Skin', 'cartflows' ),
						'name'        => 'wcf-checkout-layout',
						'value'       => $options['wcf-checkout-layout'],
						'options'     => array(
							'one-column' => esc_html__( 'One Column', 'cartflows' ),
							'two-column' => esc_html__( 'Two Column', 'cartflows' ),
							'two-step'   => esc_html__( 'Two Step', 'cartflows' ),
						),
						'pro-options' => $layout_pro_option,

					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Primary Color', 'cartflows' ),
						'name'  => 'wcf-primary-color',
						'value' => $options['wcf-primary-color'],
					)
				);

				echo wcf()->meta->get_font_family_field(
					array(
						'for'   => 'wcf-base',
						'label' => esc_html__( 'Font Family', 'cartflows' ),
						'name'  => 'wcf-base-font-family',
						'value' => $options['wcf-base-font-family'],
					)
				);

				echo wcf()->meta->get_checkbox_field(
					array(
						'label' => __( 'Advance Options', 'cartflows' ),
						'name'  => 'wcf-advance-options-fields',
						'value' => $options['wcf-advance-options-fields'],
						'after' => 'Enable',
					)
				);
				?>
		</div>                  
		<div class="wcf-cs-fields-options">
			<?php
				echo wcf()->meta->get_section(
					array(
						'label' => __( 'Heading', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Heading Color', 'cartflows' ),
						'name'  => 'wcf-heading-color',
						'value' => $options['wcf-heading-color'],
					)
				);

				echo wcf()->meta->get_font_family_field(
					array(
						'for'   => 'wcf-heading',
						'label' => esc_html__( 'Font Family', 'cartflows' ),
						'name'  => 'wcf-heading-font-family',
						'value' => $options['wcf-heading-font-family'],
					)
				);

				echo wcf()->meta->get_font_weight_field(
					array(
						'for'   => 'wcf-heading',
						'label' => esc_html__( 'Font Weight', 'cartflows' ),
						'name'  => 'wcf-heading-font-weight',
						'value' => $options['wcf-heading-font-weight'],
					)
				);

				echo wcf()->meta->get_section(
					array(
						'label' => __( 'Input Fields', 'cartflows' ),
					)
				);

				$fields_skin_pro_option = array();

				if ( ! _is_cartflows_pro() ) {
					$fields_skin_pro_option = array(
						'style-one' => __( 'Floating Labels (Available in CartFlows Pro)', 'cartflows' ),
					);
				}

				echo wcf()->meta->get_select_field(
					array(
						'label'       => __( 'Style', 'cartflows' ),
						'name'        => 'wcf-fields-skins',
						'value'       => $options['wcf-fields-skins'],
						'options'     => array(
							'default'   => esc_html__( 'Default', 'cartflows' ),
							'style-one' => esc_html__( 'Floating Labels', 'cartflows' ),
						),
						'pro-options' => $fields_skin_pro_option,

					)
				);

				echo wcf()->meta->get_font_family_field(
					array(
						'for'   => 'wcf-input',
						'label' => esc_html__( 'Font Family', 'cartflows' ),
						'name'  => 'wcf-input-font-family',
						'value' => $options['wcf-input-font-family'],
					)
				);

				echo wcf()->meta->get_font_weight_field(
					array(
						'for'   => 'wcf-input',
						'label' => esc_html__( 'Font Weight', 'cartflows' ),
						'name'  => 'wcf-input-font-weight',
						'value' => $options['wcf-input-font-weight'],
					)
				);

				echo wcf()->meta->get_select_field(
					array(
						'label'   => __( 'Size', 'cartflows' ),
						'name'    => 'wcf-input-field-size',
						'value'   => $options['wcf-input-field-size'],
						'options' => array(
							'33px'   => esc_html__( 'Extra Small', 'cartflows' ),
							'38px'   => esc_html__( 'Small', 'cartflows' ),
							'44px'   => esc_html__( 'Medium', 'cartflows' ),
							'58px'   => esc_html__( 'Large', 'cartflows' ),
							'68px'   => esc_html__( 'Extra Large', 'cartflows' ),
							'custom' => esc_html__( 'Custom', 'cartflows' ),
						),
					)
				);

				echo wcf()->meta->get_number_field(
					array(
						'label' => __( 'Top Bottom Spacing', 'cartflows' ),
						'name'  => 'wcf-field-tb-padding',
						'value' => $options['wcf-field-tb-padding'],
					)
				);

				echo wcf()->meta->get_number_field(
					array(
						'label' => __( 'Left Right Spacing', 'cartflows' ),
						'name'  => 'wcf-field-lr-padding',
						'value' => $options['wcf-field-lr-padding'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Text / Placeholder Color', 'cartflows' ),
						'name'  => 'wcf-field-color',
						'value' => $options['wcf-field-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Background Color', 'cartflows' ),
						'name'  => 'wcf-field-bg-color',
						'value' => $options['wcf-field-bg-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Border Color', 'cartflows' ),
						'name'  => 'wcf-field-border-color',
						'value' => $options['wcf-field-border-color'],
					)
				);
				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Label Color', 'cartflows' ),
						'name'  => 'wcf-field-label-color',
						'value' => $options['wcf-field-label-color'],
					)
				);

				?>
		</div>
		<div class="wcf-cs-button-options">
			<?php

				echo wcf()->meta->get_section(
					array(
						'label' => __( 'Buttons', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_font_family_field(
					array(
						'for'   => 'wcf-button',
						'label' => esc_html__( 'Font Family', 'cartflows' ),
						'name'  => 'wcf-button-font-family',
						'value' => $options['wcf-button-font-family'],
					)
				);

				echo wcf()->meta->get_font_weight_field(
					array(
						'for'   => 'wcf-button',
						'label' => esc_html__( 'Font Weight', 'cartflows' ),
						'name'  => 'wcf-button-font-weight',
						'value' => $options['wcf-button-font-weight'],
					)
				);

				echo wcf()->meta->get_select_field(
					array(
						'label'   => __( 'Size', 'cartflows' ),
						'name'    => 'wcf-input-button-size',
						'value'   => $options['wcf-input-button-size'],
						'options' => array(
							'33px'   => esc_html__( 'Extra Small', 'cartflows' ),
							'38px'   => esc_html__( 'Small', 'cartflows' ),
							'44px'   => esc_html__( 'Medium', 'cartflows' ),
							'58px'   => esc_html__( 'Large', 'cartflows' ),
							'68px'   => esc_html__( 'Extra Large', 'cartflows' ),
							'custom' => esc_html__( 'Custom', 'cartflows' ),
						),
					)
				);

				echo wcf()->meta->get_number_field(
					array(
						'label' => __( 'Top Bottom Spacing', 'cartflows' ),
						'name'  => 'wcf-submit-tb-padding',
						'value' => $options['wcf-submit-tb-padding'],
					)
				);

				echo wcf()->meta->get_number_field(
					array(
						'label' => __( 'Left Right Spacing', 'cartflows' ),
						'name'  => 'wcf-submit-lr-padding',
						'value' => $options['wcf-submit-lr-padding'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Text Color', 'cartflows' ),
						'name'  => 'wcf-submit-color',
						'value' => $options['wcf-submit-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Text Hover Color', 'cartflows' ),
						'name'  => 'wcf-submit-hover-color',
						'value' => $options['wcf-submit-hover-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Background Color', 'cartflows' ),
						'name'  => 'wcf-submit-bg-color',
						'value' => $options['wcf-submit-bg-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Background Hover Color', 'cartflows' ),
						'name'  => 'wcf-submit-bg-hover-color',
						'value' => $options['wcf-submit-bg-hover-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Border Color', 'cartflows' ),
						'name'  => 'wcf-submit-border-color',
						'value' => $options['wcf-submit-border-color'],
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Border Hover Color', 'cartflows' ),
						'name'  => 'wcf-submit-border-hover-color',
						'value' => $options['wcf-submit-border-hover-color'],
					)
				);

				?>
		</div>
		<div class="wcf-cs-section-options">
			<?php

				echo wcf()->meta->get_section(
					array(
						'label' => __( 'Sections', 'cartflows' ),
					)
				);

				echo wcf()->meta->get_color_picker_field(
					array(
						'label' => __( 'Highlight Area Background Color', 'cartflows' ),
						'name'  => 'wcf-hl-bg-color',
						'value' => $options['wcf-hl-bg-color'],
					)
				);

				echo wcf()->meta->get_hidden_field(
					array(
						'name'  => 'wcf-field-google-font-url',
						'value' => $options['wcf-field-google-font-url'],
					)
				);
				?>
		</div>
		<?php do_action( 'cartflows_checkout_style_tab_content', $options, $post_id ); ?> 
	</div>
</div>
<?php
