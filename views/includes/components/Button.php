<?php
function render_button($props) {
    $text = $props['text'] ?? '';
    $type = $props['type'] ?? 'button';
    $variant = $props['variant'] ?? 'primary';
    $classes = $props['classes'] ?? '';
    $icon = $props['icon'] ?? '';
    $modal_target = $props['modal_target'] ?? '';
    $attributes = $props['attributes'] ?? [];
    
    $btn_classes = "btn btn-{$variant} {$classes}";
    $data_attrs = '';
    
    // Add modal attributes if modal target is specified
    if ($modal_target) {
        $data_attrs .= ' data-bs-toggle="modal" data-bs-target="#' . $modal_target . '"';
    }
    
    // Add any additional attributes
    foreach ($attributes as $key => $value) {
        $data_attrs .= ' ' . $key . '="' . $value . '"';
    }
    
    ob_start();
    ?>
    <button type="<?php echo $type; ?>" class="<?php echo $btn_classes; ?>"<?php echo $data_attrs; ?>>
        <?php if ($icon): ?>
            <i class="<?php echo $icon; ?>"></i>
        <?php endif; ?>
        <?php echo $text; ?>
    </button>
    <?php
    return ob_get_clean();
}
?> 