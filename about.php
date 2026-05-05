<?php
// =============================================
// about.php — About Us Page
// =============================================
include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <span class="eyebrow">Our Story</span>
    <h1 class="blur-up-text">About CA Cera</h1>
    <p class="slide-up">Crafting premium sanitaryware since 1990</p>
</div>

<!-- STORY SECTION — 2 column -->
<section class="about-story animate-on-scroll">
    <div>
        <span class="section-script eyebrow">The Unchallenged Leader</span>
        <h2 class="blur-up-text">Our Journey of Excellence</h2>
        <p class="slide-up">
            Founded in 1990, CA Cera has been at the forefront of sanitaryware 
            manufacturing in India. What began as a small workshop with a vision 
            has grown into one of the country's most trusted brands in the 
            bathroom and kitchen fixtures industry.
        </p>
        <p class="slide-up">
            Our state-of-the-art manufacturing facility combines traditional 
            ceramic craftsmanship with modern production techniques. Every product 
            that leaves our factory undergoes rigorous quality checks to ensure 
            it meets the highest standards of durability, design, and finish.
        </p>
        <p class="slide-up">
            At CA Cera, we believe that everyday spaces deserve extraordinary 
            fixtures. Our team of skilled artisans and engineers work tirelessly 
            to create products that are not just functional, but also works of art 
            that elevate your living spaces.
        </p>
    </div>
    <div class="about-image-placeholder">🏭</div>
</section>

<!-- HIGHLIGHT CARDS -->
<section class="section" style="background: var(--lighter-bg);">
    <div class="section-heading">
        <span class="section-script">Our Values</span>
        <h2 class="section-title">Why Choose CA Cera</h2>
        <p class="section-subtitle" style="margin: 0 auto;">Three pillars that define our commitment to excellence.</p>
    </div>

    <div class="highlights-grid container">
        <div class="highlight-card animate-on-scroll">
            <span class="highlight-icon">🏆</span>
            <h3>Uncompromising Quality</h3>
            <p>
                Every CA Cera product is manufactured using premium-grade raw materials 
                and undergoes 15+ quality checkpoints. Our ceramics are kiln-fired at 
                precision temperatures for lasting strength.
            </p>
        </div>

        <div class="highlight-card animate-on-scroll">
            <span class="highlight-icon">📅</span>
            <h3>30+ Years Experience</h3>
            <p>
                With over three decades of manufacturing expertise, we've perfected the 
                art and science of sanitaryware production. Our experience translates into 
                products you can trust.
            </p>
        </div>

        <div class="highlight-card animate-on-scroll">
            <span class="highlight-icon">💡</span>
            <h3>Continuous Innovation</h3>
            <p>
                We invest heavily in R&D to bring you the latest in sanitaryware technology 
                — from water-saving flush systems to anti-bacterial coatings and smart 
                solutions.
            </p>
        </div>
    </div>
</section>

<!-- STATS -->
<section class="about-stats">
    <div class="container">
        <div class="about-stat animate-on-scroll">
            <div class="about-stat-num">30+</div>
            <div class="about-stat-label">Years in Business</div>
        </div>
        <div class="about-stat animate-on-scroll">
            <div class="about-stat-num">500+</div>
            <div class="about-stat-label">Products Catalog</div>
        </div>
        <div class="about-stat animate-on-scroll">
            <div class="about-stat-num">200+</div>
            <div class="about-stat-label">Team Members</div>
        </div>
        <div class="about-stat animate-on-scroll">
            <div class="about-stat-num">10K+</div>
            <div class="about-stat-label">Happy Customers</div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="cta-section">
    <h2>Want to Know More?</h2>
    <p>Get in touch with our team to learn about our products and services.</p>
    <a href="contact.php" class="btn btn-white btn-arrow">Contact Us</a>
</section>

<?php include 'includes/footer.php'; ?>
