<?php
// =============================================
// index.php — Home Page for CA Cera
// =============================================
include 'config/db.php';
include 'includes/header.php';
?>

<!-- ============================== -->
<!-- HERO SECTION — Full Screen     -->
<!-- ============================== -->
<section class="hero">
    <!-- Background Video -->
    <video class="hero-video-bg" autoplay muted loop playsinline preload="auto">
        <source src="assets/videos/CACERA.mp4" type="video/mp4">
    </video>

    <div class="hero-content" style="margin-top: 300px;">
        <div class="hero-buttons">
            <a href="products.php" class="btn btn-white btn-arrow">Explore Collection</a>
            <a href="about.php" class="btn btn-outline btn-arrow">Know More</a>
        </div>
    </div>

    <!-- Category tabs at bottom — Varmora style -->
    <div class="hero-tabs">
        <?php
        $icons = [
            'Toilet' => '🚽',
            'Basin' => '🚿',
            'Bathtub' => '🛁',
            'Luxury' => '✨'
        ];
        $catQuery = mysqli_query($conn, "SELECT DISTINCT type FROM product ORDER BY type ASC");
        $first = true;
        if ($catQuery && mysqli_num_rows($catQuery) > 0) {
            while ($cat = mysqli_fetch_assoc($catQuery)) {
                $type = htmlspecialchars($cat['type']);
                $icon = isset($icons[$type]) ? $icons[$type] : '📦';
                ?>
                <a href="products.php?type=<?php echo urlencode($type); ?>"
                    class="hero-tab <?php echo $first ? 'active' : ''; ?>">
                    <span class="hero-tab-icon"><?php echo $icon; ?></span>
                    <?php echo strtoupper($type); ?>
                </a>
                <?php
                $first = false;
            }
        }
        ?>
    </div>
</section>

<!-- ============================== -->
<!-- ABOUT / INNOVATION SECTION     -->
<!-- ============================== -->
<section class="about-intro animate-on-scroll">
    <div class="about-intro-images">
        <div class="about-intro-img"><img src="assets/img/first-photo.jpg" alt="CA Cera Showroom"
                style="width:100%;height:100%;object-fit:cover;border-radius:inherit;"></div>
    </div>
    <div class="about-intro-text">
        <span class="section-script eyebrow">The Unchallenged Leader in Sanitaryware</span>
        <h2 class="blur-up-text">Crafting Quality Products for<br>Every Space <strong>Since 1990</strong></h2>
        <p class="slide-up">
            CA Cera — the cornerstone of premium sanitaryware manufacturing in India, has
            cultivated a distinguished reputation as a leading manufacturer of toilets, basins,
            kitchen sinks, and luxury bathroom fixtures.
        </p>
        <p class="slide-up">
            Driven by innovation, sustainability, and unwavering customer focus, CA Cera is
            dedicated to delivering premium-quality products on a national scale. Our
            state-of-the-art manufacturing facility combines traditional ceramic craftsmanship
            with modern production techniques.
        </p>
        <div class="cert-badges">
            <span class="cert-badge">✅</span>
            <span class="cert-badge">🏅</span>
            <span class="cert-badge">🔬</span>
            <span class="cert-badge">♻️</span>
            <span class="cert-badge">🇮🇳</span>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- CATEGORY SHOWCASE — Varmora    -->
<!-- ============================== -->
<div class="category-showcase stacking-container">
    <?php
    $catDescriptions = [
        'Basin' => [
            'script' => 'Exquisite',
            'desc' => 'Elevate your bathroom with our curated collection of premium basins. From wall-mounted designs to pedestal elegance, each basin embodies a dedication to unparalleled quality, captivating design, and enduring strength.',
            'icon' => 'assets/img/second-photo.jpg',
            'watermark' => '◈'
        ],
        'Toilet' => [
            'script' => 'Futuristic',
            'desc' => 'Modern bathrooms demand innovation. CA Cera, with a rich history of pioneering advancements, brings you cutting-edge toilet technology. Experience superior flushing systems, water-saving mechanisms, and ergonomic comfort.',
            'icon' => 'assets/img/5-photo.jpg',
            'watermark' => '◎'
        ],
        'Bathtub' => [
            'script' => 'Elegant',
            'desc' => 'Indulge in the ultimate bathing experience with our premium range of bathtubs. Designed for both beauty and functionality, each bathtub combines elegant form with superior comfort for a truly luxurious soak.',
            'icon' => 'assets/img/3-photo.jpg',
            'watermark' => '◇'
        ],
        'Luxury' => [
            'script' => 'Luxurious',
            'desc' => 'Immerse yourself in a curated selection of premium luxury sanitaryware that transforms your bathroom into a haven of personalised luxury. Each piece is thoughtfully designed to harmonise aesthetics with performance.',
            'icon' => 'assets/img/4-photo.jpg',
            'watermark' => '◆'
        ]
    ];

    // Re-run query since we used catQuery above
    $catQuery2 = mysqli_query($conn, "SELECT DISTINCT type FROM product ORDER BY type ASC");

    if ($catQuery2 && mysqli_num_rows($catQuery2) > 0) {
        while ($cat = mysqli_fetch_assoc($catQuery2)) {
            $type = htmlspecialchars($cat['type']);
            $info = isset($catDescriptions[$type]) ? $catDescriptions[$type] : [
                'script' => 'Premium',
                'desc' => 'Explore our range of premium sanitaryware products.',
                'icon' => '📦',
                'watermark' => '◈'
            ];
            ?>
            <div class="category-showcase-card stacking-card animate-on-scroll">
                <div class="cat-image"><img src="<?php echo $info['icon']; ?>" alt="<?php echo $type; ?>"
                        style="width:100%;height:100%;object-fit:cover;"></div>
                <div class="cat-text">
                    <span class="section-script eyebrow"><?php echo $info['script']; ?></span>
                    <h3 class="blur-up-text"><?php echo strtoupper($type); ?></h3>
                    <p class="slide-up"><?php echo $info['desc']; ?></p>
                    <a href="products.php?type=<?php echo urlencode($type); ?>" class="explore-link">Explore
                        <?php echo $type; ?></a>
                </div>
                <span class="cat-watermark"><?php echo $info['watermark']; ?></span>
            </div>
            <?php
        }
    }
    ?>
</div>

<!-- ============================== -->
<!-- FEATURED PRODUCTS              -->
<!-- ============================== -->
<section class="section" style="background: var(--lighter-bg);">
    <div class="section-heading">
        <span class="section-script">Our Collection</span>
        <h2 class="section-title">Featured Products</h2>
        <p class="section-subtitle" style="margin: 0 auto;">Hand-picked from our finest range of sanitaryware products.
        </p>
    </div>

    <div class="products-grid container">
        <?php
        $featQuery = mysqli_query($conn, "SELECT * FROM product LIMIT 6");

        if ($featQuery && mysqli_num_rows($featQuery) > 0) {
            while ($prod = mysqli_fetch_assoc($featQuery)) {
                $pid = intval($prod['product_id']);
                $pname = htmlspecialchars($prod['product_name']);
                $ptype = htmlspecialchars($prod['type']);
                $pprice = floatval($prod['price']);
                $pimg = !empty($prod['image_path']) ? htmlspecialchars($prod['image_path']) : '';
                $isBest = !empty($prod['is_bestseller']) && $prod['is_bestseller'] == 1;
                ?>
                <div class="product-card animate-on-scroll">
                    <div class="product-card-image">
                        <?php if ($pimg): ?>
                            <img src="<?php echo $pimg; ?>" alt="<?php echo $pname; ?>" style="width:100%;height:100%;object-fit:cover;">
                        <?php else: ?>
                            <span class="product-card-icon">📦</span>
                        <?php endif; ?>
                        <?php if ($isBest): ?>
                            <span style="position:absolute;top:12px;left:12px;background:linear-gradient(135deg,#d4a74a,#c49a3c);color:#fff;padding:4px 12px;border-radius:20px;font-size:11px;font-weight:600;letter-spacing:0.5px;">⭐ Best Seller</span>
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
                <p>No products found in the database yet.</p>
            </div>
        <?php } ?>
    </div>
</section>

<!-- ============================== -->
<!-- WHY CHOOSE US SECTION          -->
<!-- ============================== -->
<section class="why-section">
    <div class="section-heading">
        <span class="section-script">Why CA Cera</span>
        <h2 class="section-title">Why Choose Us</h2>
    </div>
    <div class="why-grid">
        <div class="why-card animate-on-scroll">
            <span class="why-icon">🏆</span>
            <h3>Premium Quality</h3>
            <p>Every product undergoes 15+ quality checkpoints with premium-grade raw materials for lasting durability.
            </p>
        </div>
        <div class="why-card animate-on-scroll">
            <span class="why-icon">🔧</span>
            <h3>Expert Craftsmanship</h3>
            <p>Over 30 years of manufacturing expertise combining traditional ceramic artistry with modern technology.
            </p>
        </div>
        <div class="why-card animate-on-scroll">
            <span class="why-icon">🌍</span>
            <h3>Trusted Brand</h3>
            <p>Thousands of satisfied customers across India trust CA Cera for their bathroom and kitchen fixtures.</p>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- CA CERA STRENGTH — Varmora     -->
<!-- ============================== -->
<section class="section" style="background: var(--white);" data-stagger>
    <div class="section-heading">
        <span class="section-script eyebrow">Where innovation meets legacy</span>
        <h2 class="section-title blur-up-text">CA Cera Strength</h2>
        <p class="section-subtitle slide-up" style="margin: 0 auto;">
            We’re building a modern sanitaryware brand with manufacturing discipline, design excellence, and
            customer-first service.
        </p>
    </div>

    <div class="stats-grid">
        <div class="stat-card animate-on-scroll">
            <span class="counter-value" data-target="2+">0</span>
            <div class="stat-label">Manufacturing Units</div>
        </div>
        <div class="stat-card animate-on-scroll">
            <span class="counter-value" data-target="30+">0</span>
            <div class="stat-label">Years of Legacy</div>
        </div>
        <div class="stat-card animate-on-scroll">
            <span class="counter-value" data-target="500+">0</span>
            <div class="stat-label">SKUs</div>
        </div>
        <div class="stat-card animate-on-scroll">
            <span class="counter-value" data-target="100+">0</span>
            <div class="stat-label">Countries Served</div>
        </div>
    </div>
</section>


<!-- ============================== -->
<!-- GET IN TOUCH — homepage block  -->
<!-- ============================== -->
<section class="section" style="background: var(--white);" data-stagger>
    <div class="contact-slab container animate-on-scroll">
        <div>
            <span class="section-script eyebrow">Get in touch with us</span>
            <h2 class="blur-up-text">Let’s build your sanitaryware range</h2>
            <p class="slide-up">
                For enquiries, dealership opportunities, or product questions, contact our team. We’ll respond quickly
                with the right information.
            </p>
            <div class="contact-slab-actions slide-up">
                <a href="contact.php" class="btn btn-dark btn-arrow">Contact Us</a>
                <a href="products.php" class="btn btn-outline-dark btn-arrow">View Products</a>
            </div>
        </div>
        <div class="contact-slab-card">
            <div class="contact-slab-item">
                <span class="contact-slab-ico">📍</span>
                <div>
                    <p class="contact-slab-k">Registered Office</p>
                    <p class="contact-slab-v">Morbi, Gujarat, India</p>
                </div>
            </div>
            <div class="contact-slab-item">
                <span class="contact-slab-ico">✉️</span>
                <div>
                    <p class="contact-slab-k">Email</p>
                    <p class="contact-slab-v">info@cacera.com</p>
                </div>
            </div>
            <div class="contact-slab-item">
                <span class="contact-slab-ico">📞</span>
                <div>
                    <p class="contact-slab-k">Phone</p>
                    <p class="contact-slab-v">+91 98765 43210</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- TOOLS / QUICK ACTIONS          -->
<!-- ============================== -->
<section class="tools-section">
    <div class="tools-grid">
        <div class="tool-card animate-on-scroll">
            <span class="tool-card-icon">📐</span>
            <h3>Product Guide</h3>
            <p>Find the perfect sanitaryware for your space with our comprehensive product guide.</p>
            <a href="products.php" class="explore-link">Browse Now</a>
        </div>
        <div class="tool-card animate-on-scroll">
            <span class="tool-card-icon">📍</span>
            <h3>Where to Buy?</h3>
            <p>Explore our product range at a store near you. Quality sanitaryware, always within reach.</p>
            <a href="contact.php" class="explore-link">Locate Now</a>
        </div>
        <div class="tool-card animate-on-scroll">
            <span class="tool-card-icon">📰</span>
            <h3>About CA Cera</h3>
            <p>Stay informed: discover CA Cera's latest innovations and company milestones.</p>
            <a href="about.php" class="explore-link">Explore More</a>
        </div>
    </div>
</section>

<!-- ============================== -->
<!-- CTA SECTION                    -->
<!-- ============================== -->
<section class="cta-section">
    <h2>Ready to Transform Your Space?</h2>
    <p>Explore our complete range of premium sanitaryware products.</p>
    <a href="contact.php" class="btn btn-white btn-arrow">Contact Us Today</a>
</section>

<?php include 'includes/footer.php'; ?>