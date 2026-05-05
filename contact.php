<?php
// =============================================
// contact.php — Contact Page with Enquiry Form
// =============================================
include 'config/db.php';

// Create the enquiries table if it does not exist
mysqli_query($conn, "
    CREATE TABLE IF NOT EXISTS enquiries (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100),
        email VARCHAR(100),
        phone VARCHAR(20),
        message TEXT,
        submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )
");

// Handle form submission
$successMsg = '';
$errorMsg = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = mysqli_real_escape_string($conn, trim($_POST['name'] ?? ''));
    $email   = mysqli_real_escape_string($conn, trim($_POST['email'] ?? ''));
    $phone   = mysqli_real_escape_string($conn, trim($_POST['phone'] ?? ''));
    $message = mysqli_real_escape_string($conn, trim($_POST['message'] ?? ''));

    if (empty($name) || empty($email) || empty($message)) {
        $errorMsg = 'Please fill in all required fields (Name, Email, and Message).';
    } else {
        $insertQuery = "INSERT INTO enquiries (name, email, phone, message) 
                        VALUES ('$name', '$email', '$phone', '$message')";

        if (mysqli_query($conn, $insertQuery)) {
            $successMsg = 'Thank you for contacting us! We will get back to you shortly.';
        } else {
            $errorMsg = 'Something went wrong. Please try again later.';
        }
    }
}

include 'includes/header.php';
?>

<!-- PAGE HEADER -->
<div class="page-header">
    <span class="eyebrow">Reach Out</span>
    <h1 class="blur-up-text">Get In Touch</h1>
    <p class="slide-up">Have a question or enquiry? We'd love to hear from you.</p>
</div>

<!-- Alerts -->
<?php if ($successMsg): ?>
    <div style="padding: 24px 48px 0; max-width: var(--max-width); margin: 0 auto;">
        <div class="alert alert-success">✅ <?php echo htmlspecialchars($successMsg); ?></div>
    </div>
<?php endif; ?>

<?php if ($errorMsg): ?>
    <div style="padding: 24px 48px 0; max-width: var(--max-width); margin: 0 auto;">
        <div class="alert alert-error">❌ <?php echo htmlspecialchars($errorMsg); ?></div>
    </div>
<?php endif; ?>

<!-- CONTACT WRAPPER -->
<div class="contact-wrapper">
    <!-- Left: Contact Info -->
    <div class="contact-info">
        <h2>Contact Information</h2>
        <p>Feel free to reach out to us through any of the following channels.</p>

        <div class="info-item">
            <span class="info-icon">📍</span>
            <div>
                <h4>Our Address</h4>
                <p>123 Industrial Area, Ceramic Zone<br>Morbi, Gujarat 363641, India</p>
            </div>
        </div>

        <div class="info-item">
            <span class="info-icon">📞</span>
            <div>
                <h4>Phone Number</h4>
                <p>+91 98765 43210<br>+91 12345 67890</p>
            </div>
        </div>

        <div class="info-item">
            <span class="info-icon">✉️</span>
            <div>
                <h4>Email Address</h4>
                <p>info@cacera.com<br>sales@cacera.com</p>
            </div>
        </div>

        <div class="info-item">
            <span class="info-icon">🕐</span>
            <div>
                <h4>Working Hours</h4>
                <p>Monday – Saturday: 9:00 AM – 6:00 PM<br>Sunday: Closed</p>
            </div>
        </div>
    </div>

    <!-- Right: Contact Form -->
    <div class="contact-form-card">
        <h2>Send Us a Message</h2>
        <p>Fill out the form and our team will respond within 24 hours.</p>

        <form method="POST" action="contact.php" id="contact-form">
            <div class="form-group">
                <label for="name">Full Name *</label>
                <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            </div>

            <div class="form-group">
                <label for="email">Email Address *</label>
                <input type="email" id="email" name="email" placeholder="Enter your email" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="tel" id="phone" name="phone" placeholder="Enter your phone number">
            </div>

            <div class="form-group">
                <label for="message">Your Message *</label>
                <textarea id="message" name="message" placeholder="Type your message here..." required></textarea>
            </div>

            <button type="submit" class="btn btn-dark btn-full btn-arrow">Send Enquiry</button>
        </form>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
