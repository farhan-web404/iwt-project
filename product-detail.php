<?php
// =============================================
// product-detail.php — Single Product View
// Customer-facing product details
// =============================================
include 'config/db.php';
include 'includes/header.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

$prodQuery = mysqli_query($conn, "SELECT * FROM product WHERE product_id = $id");
$product = null;

if ($prodQuery && mysqli_num_rows($prodQuery) > 0) {
    $product = mysqli_fetch_assoc($prodQuery);
}

$typeIcons = [
    'Toilet'  => '🚽',
    'Basin'   => '🚿',
    'Bathtub' => '🛁',
    'Luxury'  => '✨'
];
?>

<?php if ($product): ?>

    <!-- DETAIL HEADER -->
    <div class="detail-header">
        <div class="detail-header-inner">
            <div class="breadcrumb">
                <a href="index.php">Home</a>
                <span>›</span>
                <a href="products.php">Products</a>
                <span>›</span>
                <span style="color: rgba(255,255,255,0.7);"><?php echo htmlspecialchars($product['product_name']); ?></span>
            </div>
        </div>
    </div>

    <!-- TWO COLUMN LAYOUT -->
    <div class="detail-hero">
        <div class="detail-info">
            <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap; margin-bottom: 8px;">
                <span class="detail-badge"><?php echo htmlspecialchars($product['type']); ?></span>
                <?php if (!empty($product['is_bestseller']) && $product['is_bestseller'] == 1): ?>
                    <span style="display: inline-flex; align-items: center; gap: 6px; background: linear-gradient(135deg, #d4a74a, #c49a3c); color: #fff; padding: 6px 16px; border-radius: 50px; font-size: 12px; font-weight: 600; letter-spacing: 1px; text-transform: uppercase;">⭐ Best Seller</span>
                <?php endif; ?>
            </div>
            <h1><?php echo htmlspecialchars($product['product_name']); ?></h1>

            <?php if (!empty($product['price']) && $product['price'] > 0): ?>
                <div style="margin: 20px 0 28px;">
                    <span style="font-family: 'Poppins', sans-serif; font-size: 32px; font-weight: 700; color: var(--black);">₹ <?php echo number_format(floatval($product['price']), 2); ?></span>
                    <span style="font-size: 14px; color: var(--text-light); margin-left: 8px;">(Inclusive of all taxes)</span>
                </div>
            <?php endif; ?>

            <?php if (!empty($product['description'])): ?>
                <p style="font-size: 16px; line-height: 1.8; color: var(--text); max-width: 540px; margin-bottom: 32px;">
                    <?php echo htmlspecialchars($product['description']); ?>
                </p>
            <?php endif; ?>

            <!-- Key Highlights -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; max-width: 440px; margin-bottom: 32px;">
                <div style="background: var(--lighter-bg); border-radius: 16px; padding: 20px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 6px;">🛡️</div>
                    <div style="font-size: 13px; font-weight: 600; color: var(--black);">Premium Quality</div>
                    <div style="font-size: 12px; color: var(--text-light);">Grade-A Ceramic</div>
                </div>
                <div style="background: var(--lighter-bg); border-radius: 16px; padding: 20px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 6px;">💧</div>
                    <div style="font-size: 13px; font-weight: 600; color: var(--black);">Water Efficient</div>
                    <div style="font-size: 12px; color: var(--text-light);">Eco-Friendly Design</div>
                </div>
                <div style="background: var(--lighter-bg); border-radius: 16px; padding: 20px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 6px;">✅</div>
                    <div style="font-size: 13px; font-weight: 600; color: var(--black);">5 Year Warranty</div>
                    <div style="font-size: 12px; color: var(--text-light);">Guaranteed Durability</div>
                </div>
                <div style="background: var(--lighter-bg); border-radius: 16px; padding: 20px; text-align: center;">
                    <div style="font-size: 24px; margin-bottom: 6px;">🚚</div>
                    <div style="font-size: 13px; font-weight: 600; color: var(--black);">Pan-India Delivery</div>
                    <div style="font-size: 12px; color: var(--text-light);">Safe & Insured</div>
                </div>
            </div>

            <div style="display: flex; gap: 14px; flex-wrap: wrap;">
                <a href="contact.php" class="btn btn-dark btn-arrow">Enquire Now</a>
                <a href="products.php" class="btn btn-outline btn-arrow" style="border-color: var(--border); color: var(--black);">View All Products</a>
            </div>
        </div>

        <div class="detail-image-box">
            <?php if (!empty($product['image_path'])): ?>
                <img src="<?php echo htmlspecialchars($product['image_path']); ?>" alt="<?php echo htmlspecialchars($product['product_name']); ?>" style="width:100%;height:100%;object-fit:cover;border-radius:inherit;">
            <?php else: ?>
                <?php
                    $ptype = htmlspecialchars($product['type']);
                    echo isset($typeIcons[$ptype]) ? $typeIcons[$ptype] : '📦';
                ?>
            <?php endif; ?>
        </div>
    </div>

    <!-- PRODUCT DETAILS SECTION -->
    <div class="tabs-section">
        <div class="tabs-nav">
            <button class="tab-btn active" data-tab="tab-overview">Overview</button>
            <button class="tab-btn" data-tab="tab-features">Features</button>
            <button class="tab-btn" data-tab="tab-shipping">Shipping & Returns</button>
        </div>

        <!-- TAB 1: Overview -->
        <div class="tab-content active" id="tab-overview">
            <div style="padding: 32px 0; max-width: 700px;">
                <h3 style="font-family: var(--font-heading); font-size: 20px; font-weight: 700; color: var(--black); margin-bottom: 16px;">About this Product</h3>
                <p style="font-size: 15px; line-height: 1.9; color: var(--text); margin-bottom: 20px;">
                    <?php echo !empty($product['description']) ? htmlspecialchars($product['description']) : 'A premium CA Cera product crafted with quality materials and modern design sensibilities.'; ?>
                </p>
                <p style="font-size: 15px; line-height: 1.9; color: var(--text); margin-bottom: 20px;">
                    Every CA Cera product is manufactured at our state-of-the-art facility using premium-grade raw materials. 
                    Our rigorous 15+ point quality inspection process ensures that each piece meets the highest standards of 
                    durability, design, and performance before reaching your home.
                </p>

                <div style="display: flex; gap: 24px; flex-wrap: wrap; margin-top: 28px;">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 20px;">📐</span>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--black);">Category</div>
                            <div style="font-size: 14px; color: var(--text);"><?php echo htmlspecialchars($product['type']); ?></div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 20px;">🏷️</span>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--black);">SKU</div>
                            <div style="font-size: 14px; color: var(--text);">CC-<?php echo str_pad($product['product_id'], 4, '0', STR_PAD_LEFT); ?></div>
                        </div>
                    </div>
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <span style="font-size: 20px;">📦</span>
                        <div>
                            <div style="font-size: 13px; font-weight: 600; color: var(--black);">Availability</div>
                            <div style="font-size: 14px; color: #2e7d32; font-weight: 500;">In Stock</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- TAB 2: Features -->
        <div class="tab-content" id="tab-features">
            <div style="padding: 32px 0; max-width: 700px;">
                <h3 style="font-family: var(--font-heading); font-size: 20px; font-weight: 700; color: var(--black); margin-bottom: 20px;">Key Features</h3>
                <ul style="list-style: none; padding: 0; display: flex; flex-direction: column; gap: 16px;">
                    <li style="display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: var(--lighter-bg); border-radius: 14px;">
                        <span style="font-size: 20px; flex-shrink: 0;">✨</span>
                        <div>
                            <div style="font-weight: 600; color: var(--black); margin-bottom: 4px;">Premium Ceramic Construction</div>
                            <div style="font-size: 14px; color: var(--text); line-height: 1.6;">Made from high-grade vitreous china with anti-bacterial glaze for lasting hygiene and durability.</div>
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: var(--lighter-bg); border-radius: 14px;">
                        <span style="font-size: 20px; flex-shrink: 0;">🎨</span>
                        <div>
                            <div style="font-weight: 600; color: var(--black); margin-bottom: 4px;">Contemporary Design</div>
                            <div style="font-size: 14px; color: var(--text); line-height: 1.6;">Sleek, modern aesthetics that complement any bathroom décor with clean lines and smooth curves.</div>
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: var(--lighter-bg); border-radius: 14px;">
                        <span style="font-size: 20px; flex-shrink: 0;">💧</span>
                        <div>
                            <div style="font-weight: 600; color: var(--black); margin-bottom: 4px;">Easy Maintenance</div>
                            <div style="font-size: 14px; color: var(--text); line-height: 1.6;">Smooth, non-porous surface resists stains and makes cleaning effortless. Stays pristine for years.</div>
                        </div>
                    </li>
                    <li style="display: flex; align-items: flex-start; gap: 14px; padding: 16px; background: var(--lighter-bg); border-radius: 14px;">
                        <span style="font-size: 20px; flex-shrink: 0;">🔧</span>
                        <div>
                            <div style="font-weight: 600; color: var(--black); margin-bottom: 4px;">Easy Installation</div>
                            <div style="font-size: 14px; color: var(--text); line-height: 1.6;">Designed for hassle-free installation with standard plumbing connections. Includes all mounting hardware.</div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <!-- TAB 3: Shipping & Returns -->
        <div class="tab-content" id="tab-shipping">
            <div style="padding: 32px 0; max-width: 700px;">
                <h3 style="font-family: var(--font-heading); font-size: 20px; font-weight: 700; color: var(--black); margin-bottom: 20px;">Shipping & Return Policy</h3>
                <div style="display: flex; flex-direction: column; gap: 20px;">
                    <div style="padding: 20px; background: var(--lighter-bg); border-radius: 14px;">
                        <div style="font-weight: 600; color: var(--black); margin-bottom: 6px;">🚚 Delivery</div>
                        <p style="font-size: 14px; color: var(--text); line-height: 1.7;">Free delivery across India for orders above ₹5,000. Standard delivery takes 5-7 business days. Express delivery available for select cities.</p>
                    </div>
                    <div style="padding: 20px; background: var(--lighter-bg); border-radius: 14px;">
                        <div style="font-weight: 600; color: var(--black); margin-bottom: 6px;">📦 Packaging</div>
                        <p style="font-size: 14px; color: var(--text); line-height: 1.7;">All products are securely packed with multi-layer protection to ensure safe transit. Each product is insured during shipping.</p>
                    </div>
                    <div style="padding: 20px; background: var(--lighter-bg); border-radius: 14px;">
                        <div style="font-weight: 600; color: var(--black); margin-bottom: 6px;">🔄 Returns</div>
                        <p style="font-size: 14px; color: var(--text); line-height: 1.7;">If the product arrives damaged, contact us within 48 hours with photos for a full replacement. We stand behind the quality of every product.</p>
                    </div>
                    <div style="padding: 20px; background: var(--lighter-bg); border-radius: 14px;">
                        <div style="font-weight: 600; color: var(--black); margin-bottom: 6px;">🛡️ Warranty</div>
                        <p style="font-size: 14px; color: var(--text); line-height: 1.7;">All CA Cera products come with a 5-year manufacturer warranty covering manufacturing defects. Terms and conditions apply.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="text-align: center; padding: 0 48px 64px;">
        <a href="products.php" class="btn btn-dark btn-arrow">Back to All Products</a>
    </div>

<?php else: ?>
    <div class="section">
        <div class="no-data">
            <span class="no-data-icon">❌</span>
            <p>Product not found. The product ID may be invalid.</p>
            <br>
            <a href="products.php" class="btn btn-dark btn-arrow">Browse All Products</a>
        </div>
    </div>
<?php endif; ?>

<?php include 'includes/footer.php'; ?>
