<?php
// -----
// Part of the Bootstrap template for Zen Cart. Loads a javascript function
// that ensures that any sidebox carousels' cards are equal heights to
// prevent screen 'jitter'.
//
// Bootstrap v3.7.10
//
$matchheight_selectors = [
    '.sideBoxContent .carousel-item .card',
];
$zco_notifier->notify('BOOTSTRAP_MATCHING_HEIGHTS', $matchheight_selectors, $matchheight_selectors);
?>
<script id="sidebox-height-match">
const matchHeight = (selector) => {
    const elements = document.querySelectorAll(selector);
    let maxHeight = 0;

    // Reset heights first to get natural height
    elements.forEach(el => el.style.height = 'auto');

    // Find the tallest element
    elements.forEach(el => {
        if (el.offsetHeight > maxHeight) {
            maxHeight = el.offsetHeight;
        }
    });

    // Apply the max height to all
    elements.forEach(el => el.style.height = `${maxHeight}px`);
};
<?php
foreach ($matchheight_selectors as $next_selector) {
?>
window.addEventListener('resize', () => matchHeight('<?= $next_selector ?>'));
window.addEventListener('DOMContentLoaded', () => matchHeight('<?= $next_selector ?>'));
<?php
}
?>
</script>
