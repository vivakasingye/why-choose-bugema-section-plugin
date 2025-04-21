<?php
/*
Plugin Name: Why Choose Bugema University
Description: Customizable "Why Choose" section for Bugema University with Font Awesome icons [why_choose_bugema]
Version: 1.0
Author: KASINGYE VIVA
Author Url: x.com/vivakasingye1
*/

// Enqueue necessary assets
function why_choose_bugema_assets() {
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css');
    wp_enqueue_style('why-choose-bugema-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'why_choose_bugema_assets');

// Register Customizer settings
function why_choose_bugema_customizer($wp_customize) {
    // Add section
    $wp_customize->add_section('why_choose_bugema_section', array(
        'title'    => __('Why Choose Section', 'bugema'),
        'priority' => 30,
    ));

    // Section title
    $wp_customize->add_setting('why_choose_title', array(
        'default'   => 'Why Choose Bugema University?',
        'transport' => 'refresh',
    ));
    $wp_customize->add_control('why_choose_title', array(
        'label'    => __('Section Title', 'bugema'),
        'section'  => 'why_choose_bugema_section',
        'type'     => 'text',
    ));

    // Cards - we'll create 6 cards
    for ($i = 1; $i <= 6; $i++) {
        // Card title
        $wp_customize->add_setting("why_choose_card_{$i}_title", array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control("why_choose_card_{$i}_title", array(
            'label'    => sprintf(__('Card %d Title', 'bugema'), $i),
            'section'  => 'why_choose_bugema_section',
            'type'     => 'text',
        ));

        // Card icon
        $wp_customize->add_setting("why_choose_card_{$i}_icon", array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control("why_choose_card_{$i}_icon", array(
            'label'    => sprintf(__('Card %d Icon (Font Awesome class)', 'bugema'), $i),
            'section'  => 'why_choose_bugema_section',
            'type'     => 'text',
            'description' => 'Example: fas fa-book (see <a href="https://fontawesome.com/icons" target="_blank">Font Awesome icons</a>)',
        ));

        // Card content
        $wp_customize->add_setting("why_choose_card_{$i}_content", array(
            'default'   => '',
            'transport' => 'refresh',
        ));
        $wp_customize->add_control("why_choose_card_{$i}_content", array(
            'label'    => sprintf(__('Card %d Content', 'bugema'), $i),
            'section'  => 'why_choose_bugema_section',
            'type'     => 'textarea',
        ));
    }
}
add_action('customize_register', 'why_choose_bugema_customizer');

// Shortcode to display the section
function why_choose_bugema_shortcode() {
    ob_start();
    ?>
    <section class="why-choose-section">
        <h2><?php echo esc_html(get_theme_mod('why_choose_title', 'Why Choose Bugema University?')); ?></h2>
        <div class="why-choose-content">
            <?php for ($i = 1; $i <= 6; $i++) : 
                $title = get_theme_mod("why_choose_card_{$i}_title");
                $icon = get_theme_mod("why_choose_card_{$i}_icon");
                $content = get_theme_mod("why_choose_card_{$i}_content");
                
                if ($title || $content) : ?>
                    <div class="why-choose-card">
                        <?php if ($icon) : ?>
                            <i class="<?php echo esc_attr($icon); ?>"></i>
                        <?php endif; ?>
                        <?php if ($title) : ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                        <?php if ($content) : ?>
                            <p><?php echo esc_html($content); ?></p>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </section>
    <?php
    return ob_get_clean();
}
add_shortcode('why_choose_bugema', 'why_choose_bugema_shortcode');

// Default content setup
function why_choose_bugema_default_content() {
    $defaults = array(
        'why_choose_title' => 'Why Choose Bugema University?',
        'why_choose_card_1_title' => 'Christ-Centered Education',
        'why_choose_card_1_icon' => 'fas fa-book',
        'why_choose_card_1_content' => 'Bugema University provides holistic education combining academic excellence with Christian values and leadership.',
        'why_choose_card_2_title' => 'Accredited Programs',
        'why_choose_card_2_icon' => 'fas fa-certificate',
        'why_choose_card_2_content' => 'We offer recognized degree, diploma, and certificate programs accepted locally and internationally.',
        'why_choose_card_3_title' => 'Experienced Faculty',
        'why_choose_card_3_icon' => 'fas fa-chalkboard-teacher',
        'why_choose_card_3_content' => 'Learn from passionate lecturers and professors dedicated to your academic and personal growth.',
        'why_choose_card_4_title' => 'Peaceful Environment',
        'why_choose_card_4_icon' => 'fas fa-leaf',
        'why_choose_card_4_content' => 'Enjoy learning in a green and serene campus environment ideal for concentration and growth.',
        'why_choose_card_5_title' => 'Innovation & Research',
        'why_choose_card_5_icon' => 'fas fa-lightbulb',
        'why_choose_card_5_content' => 'We promote creativity and research that solve real-world problems and empower communities.',
        'why_choose_card_6_title' => 'International Community',
        'why_choose_card_6_icon' => 'fas fa-globe-africa',
        'why_choose_card_6_content' => 'Be part of a diverse, global community that fosters inclusivity, culture, and collaboration.',
    );

    foreach ($defaults as $key => $value) {
        if (get_theme_mod($key) === false) {
            set_theme_mod($key, $value);
        }
    }
}
add_action('after_setup_theme', 'why_choose_bugema_default_content');

// Create CSS file if it doesn't exist
function why_choose_bugema_create_css() {
    $css_dir = plugin_dir_path(__FILE__) . 'css';
    if (!file_exists($css_dir)) {
        wp_mkdir_p($css_dir);
    }
    
    $css_file = $css_dir . '/style.css';
    if (!file_exists($css_file)) {
        $css_content = '




    .why-choose-section {
   
      padding: 60px 20px;
      max-width: 1200px;
      margin: auto;
    }

    .why-choose-section h2 {
      text-align: center;
      font-size: 2.5rem;
      color: #fff;
      margin-bottom: 40px;
    }

    .why-choose-content {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
      gap: 30px;
    }

    .why-choose-card {
      background-color: #36348e9c;
      padding: 25px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
      transition: transform 0.3s;
      text-align: center;
    }

    .why-choose-card:hover {
      transform: translateY(-5px);
    }

    .why-choose-card i {
      font-size: 2.5rem;
      color: #fff;
      margin-bottom: 15px;
    }

.why-choose-card h3 {
	font-size: 1.3rem !important;
	margin-bottom: 10px;
	color: #fff !important;
}

    .why-choose-card p {
      font-size: 13px;
      color: #fff;
      line-height: 1.6;
    }

    @media (max-width: 768px) {
      .why-choose-section h2 {
        font-size: 2rem;
      }

      .why-choose-card i {
        font-size: 2rem;
      }

      .why-choose-card h3 {
        font-size: 1.1rem;
      }
    }
  		

';
        
        file_put_contents($css_file, $css_content);
    }
}
register_activation_hook(__FILE__, 'why_choose_bugema_create_css');
