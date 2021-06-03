<?php

// Display
foreach (['title', 'content', 'image', 'link'] as $key) {
    if (!$element["show_{$key}"]) { $props[$key] = ''; }
}

// Item
$el = $this->el('div', [
    'class' => [
        'el-item uk-panel uk-margin-remove-first-child uk-link-toggle uk-display-block'
    ],
    'itemprop'  => 'offers',
    'itemtype' => 'http://schema.org/Offer',
    'itemscope' => 'itemscope', 
    //'uk-grid' => true,
]);

// Title
$title = $this->el($element['title_element'], [
    'class' => [
        'el-title',
    ],
]);

// Content
$content = $this->el($element['content_element'], [
    'class' => [
        'el-content uk-panel price-color',
    ],
    'style' => [
        // Set the min-height if it has a value
        //'min-height: {min_height}px',
    ],
    //'itemprop'  => 'price',

    //'id' => 'JiGa-shopify',
    //'shopifyId' => $props['content'],
]);
// Test
 

$image = $this->el('image', [
    'class' => [
        'el-image',
    ],
    'src' => $props['image'],
    'alt' => $props['image_alt'],
    'width' => $element['image_width'],
    'height' => $element['image_height'],
    'thumbnail' => true,
]);

// Link
$link = $this->el('a', [
    'class' => [
        'el-link uk-button uk-button-default',
    ],
    'itemprop'  => 'url',
    'href' => $props['link'],
    'uk-scroll' => strpos($props['link'], '#') === 0,
]);

?>

<?php

$token = $element['shopify_token'];
$secret = $element['shopify_secret'];
$shop = $element['shopify_storename'];
$shopilink = 'https://'.$token.':'.$secret.'@'.$shop.'.myshopify.com/admin/api/2021-01/products/'.$props['content'].'/variants.json';
$json = json_decode(file_get_contents($shopilink),true);
$price = $json['variants']['0']['price'];
$cost = $element['content_currency'].$json['variants']['0']['price'];
?>

<?= $el($element, $attrs) ?>

        <?php if ($props['image']) : ?>
        <?= $image($element, $props['image']) ?>
        <?php endif ?>

        <?php if ($props['title']) : ?>
        <?= $title($element, $props['title']) ?>
        <?php endif ?>

        <?php if ($props['content']) : ?>
        <meta itemprop="priceCurrency" content=<?= $element['content_currency'] ?> />
        <meta itemprop="price" content=<?= $price ?> />
        <meta itemprop="availability" content="https://schema.org/InStock" />
        <meta itemprop="priceValidUntil" content="2030-11-20" />
        <?= $content($element,$cost) ?>
        <?php endif ?>

        <?php if ($props['link'] && $element['link_text']) : ?>
        <?= $link($element, $element['link_text']) ?>
        <?php endif ?>

<?= $el->end() ?>

