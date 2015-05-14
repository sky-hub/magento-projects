<?php
$currentDate = date("Y-m-d H:i:s", Mage::getModel('core/date')->timestamp(time()));
$banners = array(
    array(
        'title' => 'First Banner',
        'content' => 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.',
        'url' => 'http://www.example.com',
        'url_target' => '_blank',
        'button' => 1,
        'button_text' => 'Buy Now!',
        'image' => 'innobyte_slide_1.png',
        'position' => 0,
        'is_active' => 1,
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Second Banner',
        'content' => 'Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English.',
        'url' => 'http://www.example.com',
        'url_target' => '_blank',
        'button' => 0,
        'button_text' => null,
        'image' => 'innobyte_slide_2.png',
        'position' => 1,
        'is_active' => 1,
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Third Banner',
        'content' => 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form.',
        'url' => 'http://www.example.com',
        'url_target' => '_blank',
        'button' => 0,
        'button_text' => null,
        'image' => 'innobyte_slide_3.png',
        'position' => 2,
        'is_active' => 1,
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Forth Banner',
        'content' => 'If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.',
        'url' => 'http://www.example.com',
        'url_target' => '_blank',
        'button' => 0,
        'button_text' => null,
        'image' => 'innobyte_slide_4.png',
        'position' => 3,
        'is_active' => 1,
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Fifth Banner',
        'content' => 'The generated Lorem Ipsum is therefore always free from repetition, injected humour, or non-characteristic words etc.',
        'url' => 'http://www.example.com',
        'url_target' => '_blank',
        'button' => 0,
        'button_text' => null,
        'image' => 'innobyte_slide_5.png',
        'position' => 4,
        'is_active' => 1,
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Sixt Banner',
        'content' => 'Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text.',
        'url' => 'http://www.example.com',
        'url_target' => '_self',
        'button' => 1,
        'button_text' => 'Buy Now!',
        'image' => 'innobyte_slide_1.png',
        'position' => 5,
        'is_active' => 1,
        'created_at' => $currentDate
    )
);

$groups = array(
    array(
        'title' => 'Homepage Banner Group',
        'identifier' => 'homepage_banner_group',
        'page' => 'cms',
        'delay' => 10,
        'show_pagination' => 0,
        'prev_next' => 0,
        'css_transition' => 0,
        'lazy_load' => 0,
        'position' => 0,
        'is_primary' => 1,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            4 => array('position' => 0),
            5 => array('position' => 1),
            6 => array('position' => 2)
        ),
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Category Banner Group',
        'identifier' => 'category_banner_group',
        'page' => 'category',
        'delay' => 10,
        'show_pagination' => 0,
        'prev_next' => 0,
        'css_transition' => 0,
        'lazy_load' => 0,
        'position' => 0,
        'is_primary' => 1,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            1 => array('position' => 0),
            3 => array('position' => 1),
            4 => array('position' => 2),
            5 => array('position' => 3),
            6 => array('position' => 4)
        ),
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Product Banner Group',
        'identifier' => 'product_banner_group',
        'page' => 'product',
        'delay' => 10,
        'show_pagination' => 1,
        'prev_next' => 1,
        'css_transition' => 1,
        'lazy_load' => 1,
        'position' => 0,
        'is_primary' => 0,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            3 => array('position' => 0),
            4 => array('position' => 1),
            5 => array('position' => 2)
        ),
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Catalog Search Banner Group',
        'identifier' => 'catalogsearch_banner_group',
        'page' => 'catalogsearch',
        'delay' => 10,
        'show_pagination' => 0,
        'prev_next' => 0,
        'css_transition' => 0,
        'lazy_load' => 0,
        'position' => 0,
        'is_primary' => 1,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            2 => array('position' => 0),
            5 => array('position' => 1),
            6 => array('position' => 2)
        ),
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Cms Banner Group',
        'identifier' => 'cms_banner_group',
        'page' => 'cms',
        'delay' => 10,
        'show_pagination' => 1,
        'prev_next' => 1,
        'css_transition' => 0,
        'lazy_load' => 0,
        'position' => 0,
        'is_primary' => 0,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            1 => array('position' => 0),
            3 => array('position' => 1),
            4 => array('position' => 2)
        ),
        'created_at' => $currentDate
    ),
    array(
        'title' => 'Test Banner Group',
        'identifier' => 'test_banner_group',
        'page' => 'product',
        'delay' => 5,
        'show_pagination' => 1,
        'prev_next' => 0,
        'css_transition' => 1,
        'lazy_load' => 0,
        'position' => 0,
        'is_primary' => 0,
        'is_active' => 1,
        'stores' => array(0),
        'banners_data' => array(
            4 => array('position' => 0),
            5 => array('position' => 1),
            6 => array('position' => 2)
        ),
        'created_at' => $currentDate
    )
);

/**
 * Insert default banners
 */
foreach ($banners as $key => $banner) {
    Mage::getModel('skylab_banner/banner')
        ->setData($banner)
        ->save();
}

/**
 * Insert default banner groups
 */
foreach ($groups as $group) {
    Mage::getModel('skylab_banner/group')
        ->setData($group)
        ->save();
}
