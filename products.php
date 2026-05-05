<?php
// =============================================
// products.php — All Products with Filtering
// =============================================
include 'config/db.php';
include 'includes/header.php';

$filterType = '';
if (isset($_GET['type']) && !empty($_GET['type'])) {
    $filterType = mysqli_real_escape_string($conn, $_GET['type']);
}
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <span class="eyebrow">Our Collection</span>
    <h1 class="blur-up-text">Our Products</h1>
    <p class="slide-up"><?php echo $filterType ? 'Showing: ' . htmlspecialchars($filterType) : 'Browse our complete sanitaryware range'; ?></p>
</div>

<!-- FILTER + SEARCH + GRID -->
<section class="section">
    <div class="filter-bar">
        <a href="products.php" class="filter-btn <?php echo !$filterType ? 'active' : ''; ?>">All</a>
        <?php
        $typeQuery = mysqli_query($conn, "SELECT DISTINCT type FROM product ORDER BY type ASC");
        if ($typeQuery) {
            while ($t = mysqli_fetch_assoc($typeQuery)) {
                $tname = htmlspecialchars($t['type']);
                $isActive = ($filterType === $t['type']) ? 'active' : '';
        ?>
            <a href="products.php?type=<?php echo urlencode($t['type']); ?>" class="filter-btn <?php echo $isActive; ?>">
                <?php echo $tname; ?>
            </a>
        <?php
            }
        }
        ?>
    </div>

    <div class="search-wrapper">
        <span class="search-icon">🔍</span>
        <input type="text" id="product-search" class="search-input" placeholder="Search products by name...">
    </div>

    <div class="products-grid container">
        <?php
        $sql = "SELECT * FROM product";
        if ($filterType) {
            $sql .= " WHERE type = '$filterType'";
        }
        $sql .= " ORDER BY product_name ASC";

        $prodQuery = mysqli_query($conn, $sql);

        if ($prodQuery && mysqli_num_rows($prodQuery) > 0) {
            while ($prod = mysqli_fetch_assoc($prodQuery)) {
                $pid   = intval($prod['product_id']);
                $pname = htmlspecialchars($prod['product_name']);
                $ptype = htmlspecialchars($prod['type']);
                $pprice = floatval($prod['price']);
                $pimg  = !empty($prod['image_path']) ? htmlspecialchars($prod['image_path']) : '';
                $isBest = !empty($prod['is_bestseller']) && $prod['is_bestseller'] == 1;
        ?>
            <div class="product-card animate-on-scroll" data-name="<?php echo $pname; ?>">
                <div class="product-card-image">
                    <?php if ($pimg): ?>
                        <img src="<?php echo $pimg; ?>" alt="<?php echo $pname; ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                        <span class="product-card-icon">📦</span>
                    <?php endif; ?>
                    <?php if ($isBest): ?>
                        <span style="position:absolute;top:12px;left:12px;background:linear-gradient(135deg,#d4a74a,#c49a3c);color:#fff;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;">⭐ Best Seller</span>
                    <?php endif; ?>
                </div>
                <div class="product-card-body">
                    <span class="product-card-type"><?php echo $ptype; ?></span>
                    <h3><?php echo $pname; ?></h3>
                    <?php if ($pprice > 0): ?>
                        <p class="product-card-meta" style="font-size:18px;font-weight:700;color:var(--black);">₹ <?php echo number_format($pprice, 2); ?></p>
                    <?php endif; ?>
                    <a href="product-detail.php?id=<?php echo $pid; ?>" class="product-card-link">View Details</a>
                </div>
            </div>
        <?php
            }
        } else {
        ?>
            <div class="no-data" style="grid-column: 1 / -1;">
                <span class="no-data-icon">📦</span>
                <p>No products found<?php echo $filterType ? ' in the "' . htmlspecialchars($filterType) . '" category' : ''; ?>.</p>
            </div>
        <?php } ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>
