<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { header('Location: login.php'); exit; }

// Handle user deletion
if (isset($_GET['delete_user']) && intval($_GET['delete_user']) > 0) {
    $delId = intval($_GET['delete_user']);
    $chk = mysqli_query($conn, "SELECT role FROM users WHERE user_id = $delId");
    if ($chk && ($r = mysqli_fetch_assoc($chk)) && $r['role'] !== 'admin') {
        mysqli_query($conn, "DELETE FROM users WHERE user_id = $delId");
    }
    header('Location: admin.php?tab=users'); exit;
}

// Stats
$stats = [];
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM users WHERE role='user'"); $stats['users'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM product"); $stats['products'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM worker"); $stats['workers'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM raw_material"); $stats['materials'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM login_logs"); $stats['logins'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM login_logs WHERE DATE(login_time) = CURDATE()"); $stats['today'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COUNT(*) as c FROM enquiries"); $stats['enquiries'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;
$q = mysqli_query($conn, "SELECT COALESCE(SUM(quantity_produced),0) as c FROM production"); $stats['produced'] = $q ? mysqli_fetch_assoc($q)['c'] : 0;

$activeTab = isset($_GET['tab']) ? $_GET['tab'] : 'dashboard';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Admin Panel | CA Cera</title>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
<style>
*{margin:0;padding:0;box-sizing:border-box}
html{zoom:1.25}
body{font-family:'Poppins',sans-serif;background:#f4f4f8;color:#1a1a1a;display:flex;min-height:100vh;font-size:18px}

/* Sidebar */
.sidebar{width:300px;background:#1a1a1a;color:#fff;padding:36px 0;display:flex;flex-direction:column;position:fixed;top:0;left:0;bottom:0;z-index:100;overflow-y:auto}
.sidebar-logo{padding:0 32px 36px;font-family:'Playfair Display',serif;font-size:40px;font-weight:700;border-bottom:1px solid rgba(255,255,255,0.08)}
.sidebar-logo span{font-style:italic;color:#d4a74a}
.sidebar-badge{background:rgba(212,167,74,0.15);color:#d4a74a;padding:6px 16px;border-radius:20px;font-size:14px;font-weight:600;letter-spacing:1px;text-transform:uppercase;margin-left:12px;font-family:'Poppins',sans-serif}
.sidebar-nav{flex:1;padding:24px 0}
.sidebar-section{padding:0 32px;margin-bottom:12px;font-size:14px;font-weight:700;color:rgba(255,255,255,0.3);letter-spacing:2px;text-transform:uppercase}
.sidebar-link{display:flex;align-items:center;gap:16px;padding:16px 32px;color:rgba(255,255,255,0.6);text-decoration:none;font-size:19px;transition:all 0.2s;border-left:4px solid transparent}
.sidebar-link:hover{color:#fff;background:rgba(255,255,255,0.05)}
.sidebar-link.active{color:#fff;background:rgba(255,255,255,0.08);border-left-color:#d4a74a}
.sidebar-link-icon{font-size:26px;width:32px;text-align:center}
.sidebar-footer{padding:24px 32px;border-top:1px solid rgba(255,255,255,0.08)}
.sidebar-footer a{color:rgba(255,255,255,0.5);text-decoration:none;font-size:18px;display:flex;align-items:center;gap:12px;transition:color 0.2s}
.sidebar-footer a:hover{color:#ff6b6b}

/* Main */
.main{margin-left:300px;flex:1;padding:48px 56px;min-height:100vh}
.main-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:40px}
.main-header h1{font-size:42px;font-weight:700}
.main-header p{color:#888;font-size:19px;margin-top:6px}
.header-actions{display:flex;gap:14px;align-items:center}
.header-actions a{text-decoration:none;padding:16px 32px;border-radius:16px;font-size:17px;font-weight:600;transition:all 0.2s}
.btn-site{background:#f0f0f0;color:#333}.btn-site:hover{background:#e0e0e0}

/* Stats */
.stats-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:20px;margin-bottom:40px}
.sc{background:#fff;border-radius:22px;padding:36px;border:1px solid #eee;transition:all 0.3s}
.sc:hover{box-shadow:0 12px 32px rgba(0,0,0,0.06);transform:translateY(-3px)}
.sc-icon{font-size:40px;margin-bottom:16px}
.sc-val{font-size:48px;font-weight:700;color:#1a1a1a}
.sc-label{font-size:18px;color:#999;font-weight:500;margin-top:6px}

/* Tables */
.card{background:#fff;border-radius:20px;border:1px solid #eee;overflow:hidden;margin-bottom:28px}
.card-header{padding:26px 32px;border-bottom:1px solid #f0f0f0;font-weight:700;font-size:24px;display:flex;justify-content:space-between;align-items:center}
.tbl{width:100%;border-collapse:collapse}
.tbl th{background:#f8f8fa;padding:18px 28px;text-align:left;font-size:15px;font-weight:700;color:#666;text-transform:uppercase;letter-spacing:1px;border-bottom:1px solid #eee}
.tbl td{padding:20px 28px;font-size:17px;color:#333;border-bottom:1px solid #f5f5f5}
.tbl tr:last-child td{border-bottom:none}
.tbl tr:hover td{background:#fafafa}
.badge{display:inline-block;padding:8px 18px;border-radius:22px;font-size:14px;font-weight:600;text-transform:uppercase;letter-spacing:0.5px}
.badge-admin{background:rgba(212,167,74,0.12);color:#b8860b}
.badge-user{background:rgba(59,130,246,0.1);color:#3b82f6}
.badge-best{background:rgba(34,197,94,0.1);color:#16a34a}
.text-muted{color:#999;font-size:16px}
.btn-del{background:rgba(255,80,80,0.1);color:#e53e3e;border:none;padding:10px 22px;border-radius:12px;font-size:15px;font-weight:600;cursor:pointer;text-decoration:none;transition:all 0.2s}
.btn-del:hover{background:rgba(255,80,80,0.2)}
.empty{text-align:center;padding:64px;color:#999;font-size:19px}
.empty-icon{font-size:48px;margin-bottom:12px}
.overflow-x{overflow-x:auto}

@media(max-width:768px){
.sidebar{width:70px;padding:16px 0}.sidebar-logo,.sidebar-section,.sidebar-link span:not(.sidebar-link-icon),.sidebar-badge,.sidebar-footer span{display:none}
.sidebar-link{padding:16px 0;justify-content:center}.sidebar-link-icon{width:auto}
.main{margin-left:70px;padding:24px}
.stats-grid{grid-template-columns:1fr 1fr}
}
</style>
</head>
<body>

<!-- SIDEBAR -->
<aside class="sidebar">
    <div class="sidebar-logo">CA <span>Cera</span><span class="sidebar-badge">Admin</span></div>
    <nav class="sidebar-nav">
        <p class="sidebar-section" style="margin-top:12px">Overview</p>
        <a href="admin.php?tab=dashboard" class="sidebar-link <?php echo $activeTab==='dashboard'?'active':''; ?>"><span class="sidebar-link-icon">📊</span><span>Dashboard</span></a>

        <p class="sidebar-section" style="margin-top:18px">Factory</p>
        <a href="admin.php?tab=products" class="sidebar-link <?php echo $activeTab==='products'?'active':''; ?>"><span class="sidebar-link-icon">📦</span><span>Products</span></a>
        <a href="admin.php?tab=workers" class="sidebar-link <?php echo $activeTab==='workers'?'active':''; ?>"><span class="sidebar-link-icon">👷</span><span>Workers</span></a>
        <a href="admin.php?tab=materials" class="sidebar-link <?php echo $activeTab==='materials'?'active':''; ?>"><span class="sidebar-link-icon">🧱</span><span>Raw Materials</span></a>
        <a href="admin.php?tab=production" class="sidebar-link <?php echo $activeTab==='production'?'active':''; ?>"><span class="sidebar-link-icon">🏭</span><span>Production</span></a>

        <p class="sidebar-section" style="margin-top:18px">Accounts</p>
        <a href="admin.php?tab=users" class="sidebar-link <?php echo $activeTab==='users'?'active':''; ?>"><span class="sidebar-link-icon">👥</span><span>Users</span></a>
        <a href="admin.php?tab=logins" class="sidebar-link <?php echo $activeTab==='logins'?'active':''; ?>"><span class="sidebar-link-icon">🔐</span><span>Login Activity</span></a>
        <a href="admin.php?tab=enquiries" class="sidebar-link <?php echo $activeTab==='enquiries'?'active':''; ?>"><span class="sidebar-link-icon">✉️</span><span>Enquiries</span></a>
    </nav>
    <div class="sidebar-footer">
        <a href="logout.php">🚪 <span>Logout</span></a>
    </div>
</aside>

<!-- MAIN CONTENT -->
<div class="main">
    <div class="main-header">
        <div>
            <h1><?php
                $titles = ['dashboard'=>'Dashboard','products'=>'Products','workers'=>'Workers','materials'=>'Raw Materials','production'=>'Production History','users'=>'User Accounts','logins'=>'Login Activity','enquiries'=>'Enquiries'];
                echo $titles[$activeTab] ?? 'Dashboard';
            ?></h1>
            <p>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?></p>
        </div>
        <div class="header-actions">
            <a href="index.php" class="btn-site">🏠 View Site</a>
        </div>
    </div>

<?php if ($activeTab === 'dashboard'): ?>
    <!-- DASHBOARD -->
    <div class="stats-grid">
        <div class="sc"><div class="sc-icon">📦</div><div class="sc-val"><?php echo $stats['products']; ?></div><div class="sc-label">Products</div></div>
        <div class="sc"><div class="sc-icon">👷</div><div class="sc-val"><?php echo $stats['workers']; ?></div><div class="sc-label">Workers</div></div>
        <div class="sc"><div class="sc-icon">🧱</div><div class="sc-val"><?php echo $stats['materials']; ?></div><div class="sc-label">Raw Materials</div></div>
        <div class="sc"><div class="sc-icon">🏭</div><div class="sc-val"><?php echo number_format($stats['produced']); ?></div><div class="sc-label">Units Produced</div></div>
        <div class="sc"><div class="sc-icon">👥</div><div class="sc-val"><?php echo $stats['users']; ?></div><div class="sc-label">Registered Users</div></div>
        <div class="sc"><div class="sc-icon">🔐</div><div class="sc-val"><?php echo $stats['logins']; ?></div><div class="sc-label">Total Logins</div></div>
        <div class="sc"><div class="sc-icon">📅</div><div class="sc-val"><?php echo $stats['today']; ?></div><div class="sc-label">Logins Today</div></div>
        <div class="sc"><div class="sc-icon">✉️</div><div class="sc-val"><?php echo $stats['enquiries']; ?></div><div class="sc-label">Enquiries</div></div>
    </div>

    <!-- Recent Users -->
    <div class="card">
        <div class="card-header">Recent Users <a href="admin.php?tab=users" style="font-size:13px;color:#d4a74a;text-decoration:none;">View All →</a></div>
        <div class="overflow-x"><table class="tbl"><thead><tr><th>Name</th><th>Email</th><th>Role</th><th>Joined</th></tr></thead><tbody>
        <?php $rq = mysqli_query($conn, "SELECT * FROM users ORDER BY created_at DESC LIMIT 5");
        if ($rq && mysqli_num_rows($rq)>0) { while($u=mysqli_fetch_assoc($rq)): ?>
            <tr><td><strong><?php echo htmlspecialchars($u['name']); ?></strong></td><td><?php echo htmlspecialchars($u['email']); ?></td>
            <td><span class="badge <?php echo $u['role']==='admin'?'badge-admin':'badge-user'; ?>"><?php echo $u['role']; ?></span></td>
            <td class="text-muted"><?php echo date('d M Y',strtotime($u['created_at'])); ?></td></tr>
        <?php endwhile; } else { echo '<tr><td colspan="4" class="empty">No users yet</td></tr>'; } ?>
        </tbody></table></div>
    </div>

    <!-- Recent Logins -->
    <div class="card">
        <div class="card-header">Recent Login Activity <a href="admin.php?tab=logins" style="font-size:13px;color:#d4a74a;text-decoration:none;">View All →</a></div>
        <div class="overflow-x"><table class="tbl"><thead><tr><th>User</th><th>Email</th><th>Time</th><th>IP</th></tr></thead><tbody>
        <?php $rq = mysqli_query($conn, "SELECT l.*,u.name FROM login_logs l JOIN users u ON l.user_id=u.user_id ORDER BY l.login_time DESC LIMIT 5");
        if ($rq && mysqli_num_rows($rq)>0) { while($l=mysqli_fetch_assoc($rq)): ?>
            <tr><td><strong><?php echo htmlspecialchars($l['name']); ?></strong></td><td><?php echo htmlspecialchars($l['email']); ?></td>
            <td><?php echo date('d M, h:i A',strtotime($l['login_time'])); ?></td><td class="text-muted"><?php echo htmlspecialchars($l['ip_address']); ?></td></tr>
        <?php endwhile; } else { echo '<tr><td colspan="4" class="empty">No login activity</td></tr>'; } ?>
        </tbody></table></div>
    </div>

<?php elseif ($activeTab === 'products'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>ID</th><th>Image</th><th>Name</th><th>Type</th><th>Price</th><th>Best Seller</th><th>Molding</th><th>Casting</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT * FROM product ORDER BY product_id");
    if ($rq && mysqli_num_rows($rq)>0) { while($p=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $p['product_id']; ?></td>
        <td><?php if(!empty($p['image_path'])): ?><img src="<?php echo htmlspecialchars($p['image_path']); ?>" style="width:50px;height:50px;object-fit:cover;border-radius:8px;"><?php else: ?>—<?php endif; ?></td>
        <td><strong><?php echo htmlspecialchars($p['product_name']); ?></strong></td>
        <td><?php echo htmlspecialchars($p['type']); ?></td>
        <td>₹ <?php echo number_format(floatval($p['price']),2); ?></td>
        <td><?php echo $p['is_bestseller']?'<span class="badge badge-best">Yes</span>':'—'; ?></td>
        <td><?php echo intval($p['molding_required']); ?></td>
        <td><?php echo intval($p['casting_required']); ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="8" class="empty">No products</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'workers'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>ID</th><th>Name</th><th>Role</th><th>Daily Wage (₹)</th><th>Assigned Products</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT w.*, GROUP_CONCAT(DISTINCT p.product_name SEPARATOR ', ') as products FROM worker w LEFT JOIN worker_assignment wa ON w.worker_id=wa.worker_id LEFT JOIN product p ON wa.product_id=p.product_id GROUP BY w.worker_id ORDER BY w.worker_name");
    if ($rq && mysqli_num_rows($rq)>0) { while($w=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $w['worker_id']; ?></td><td><strong><?php echo htmlspecialchars($w['worker_name']); ?></strong></td>
        <td><?php echo htmlspecialchars($w['role']); ?></td><td>₹ <?php echo number_format(floatval($w['daily_wage']),2); ?></td>
        <td class="text-muted"><?php echo $w['products'] ? htmlspecialchars($w['products']) : '—'; ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="5" class="empty">No workers</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'materials'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>ID</th><th>Material</th><th>Unit</th><th>Cost/Unit (₹)</th><th>Used In Products</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT rm.*, GROUP_CONCAT(DISTINCT p.product_name SEPARATOR ', ') as products FROM raw_material rm LEFT JOIN material_usage mu ON rm.material_id=mu.material_id LEFT JOIN product p ON mu.product_id=p.product_id GROUP BY rm.material_id ORDER BY rm.material_name");
    if ($rq && mysqli_num_rows($rq)>0) { while($m=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $m['material_id']; ?></td><td><strong><?php echo htmlspecialchars($m['material_name']); ?></strong></td>
        <td><?php echo htmlspecialchars($m['unit']); ?></td><td>₹ <?php echo number_format(floatval($m['cost_per_unit']),2); ?></td>
        <td class="text-muted"><?php echo $m['products'] ? htmlspecialchars($m['products']) : '—'; ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="5" class="empty">No materials</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'production'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>ID</th><th>Product</th><th>Date</th><th>Qty Produced</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT pr.*, p.product_name FROM production pr JOIN product p ON pr.product_id=p.product_id ORDER BY pr.production_date DESC");
    if ($rq && mysqli_num_rows($rq)>0) { while($pr=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $pr['production_id']; ?></td><td><strong><?php echo htmlspecialchars($pr['product_name']); ?></strong></td>
        <td><?php echo date('d M Y',strtotime($pr['production_date'])); ?></td><td><?php echo intval($pr['quantity_produced']); ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="4" class="empty">No production records</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'users'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>ID</th><th>Name</th><th>Email</th><th>Role</th><th>Logins</th><th>Last Login</th><th>Joined</th><th>Action</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT u.*, (SELECT COUNT(*) FROM login_logs l WHERE l.user_id=u.user_id) as login_count, (SELECT MAX(login_time) FROM login_logs l WHERE l.user_id=u.user_id) as last_login FROM users u ORDER BY u.created_at DESC");
    if ($rq && mysqli_num_rows($rq)>0) { while($u=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $u['user_id']; ?></td><td><strong><?php echo htmlspecialchars($u['name']); ?></strong></td>
        <td><?php echo htmlspecialchars($u['email']); ?></td>
        <td><span class="badge <?php echo $u['role']==='admin'?'badge-admin':'badge-user'; ?>"><?php echo $u['role']; ?></span></td>
        <td><?php echo intval($u['login_count']); ?></td>
        <td class="text-muted"><?php echo $u['last_login'] ? date('d M Y, h:i A',strtotime($u['last_login'])) : 'Never'; ?></td>
        <td class="text-muted"><?php echo date('d M Y',strtotime($u['created_at'])); ?></td>
        <td><?php if($u['role']!=='admin'): ?><a href="admin.php?delete_user=<?php echo $u['user_id']; ?>&tab=users" class="btn-del" onclick="return confirm('Delete this user?')">Delete</a><?php else: ?>—<?php endif; ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="8" class="empty">No users</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'logins'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>#</th><th>User</th><th>Email</th><th>Login Time</th><th>IP Address</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT l.*,u.name FROM login_logs l JOIN users u ON l.user_id=u.user_id ORDER BY l.login_time DESC LIMIT 100");
    if ($rq && mysqli_num_rows($rq)>0) { while($l=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $l['log_id']; ?></td><td><strong><?php echo htmlspecialchars($l['name']); ?></strong></td>
        <td><?php echo htmlspecialchars($l['email']); ?></td>
        <td><?php echo date('d M Y, h:i:s A',strtotime($l['login_time'])); ?></td>
        <td class="text-muted"><?php echo htmlspecialchars($l['ip_address']); ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="5" class="empty">No login activity</td></tr>'; } ?>
    </tbody></table></div></div>

<?php elseif ($activeTab === 'enquiries'): ?>
    <div class="card"><div class="overflow-x"><table class="tbl"><thead><tr><th>#</th><th>Name</th><th>Email</th><th>Phone</th><th>Message</th><th>Date</th></tr></thead><tbody>
    <?php $rq = mysqli_query($conn, "SELECT * FROM enquiries ORDER BY submitted_at DESC");
    if ($rq && mysqli_num_rows($rq)>0) { while($e=mysqli_fetch_assoc($rq)): ?>
        <tr><td><?php echo $e['id']; ?></td><td><strong><?php echo htmlspecialchars($e['name']); ?></strong></td>
        <td><?php echo htmlspecialchars($e['email']); ?></td><td><?php echo htmlspecialchars($e['phone']); ?></td>
        <td style="max-width:300px"><?php echo htmlspecialchars(substr($e['message'],0,100)); ?><?php echo strlen($e['message'])>100?'...':''; ?></td>
        <td class="text-muted"><?php echo date('d M Y, h:i A',strtotime($e['submitted_at'])); ?></td></tr>
    <?php endwhile; } else { echo '<tr><td colspan="6" class="empty">No enquiries</td></tr>'; } ?>
    </tbody></table></div></div>

<?php endif; ?>

</div>
</body>
</html>
