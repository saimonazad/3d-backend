<script>
var shopengine_has_product_status = <?php echo json_encode([
    'has_product' => \ShopEngine\Core\Builders\Templates::has_simple_product(),
    'message' => \ShopEngine\Widgets\Products::instance()->no_product_to_preview()
]);?>
</script>

<div class="shopengine-admin-dashboard">
    <div class="shopengine-admin-dashboard-wrapper" >
        <!-- Content Goes Here -->
    </div>
</div>
