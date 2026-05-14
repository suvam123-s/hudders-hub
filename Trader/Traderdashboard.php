<?php
session_start();

// ── Auth Guard ─────────────────────────────────────────────────
if (!isset($_SESSION['user_id'])) {
    header('Location: ../auth.php');
    exit();
}

require_once '../include/db_connect.php';
$conn = get_db_connection();

$trader_user_id = (int) $_SESSION['user_id'];

// ── Resolve trader's shop ──────────────────────────────────────
$s = oci_parse($conn, "SELECT shop_ID FROM SHOP WHERE user_ID = :uid FETCH FIRST 1 ROWS ONLY");
oci_bind_by_name($s, ':uid', $trader_user_id);
oci_execute($s);
$srow    = oci_fetch_assoc($s);
$shop_id = $srow ? (int)$srow['SHOP_ID'] : 1;

// ── KPI: Total Orders ──────────────────────────────────────────
$st = oci_parse($conn, "SELECT COUNT(DISTINCT o.order_ID) AS total FROM ORDERS o
    JOIN ORDER_ITEM oi ON oi.order_ID = o.order_ID WHERE oi.shop_ID = :sid");
oci_bind_by_name($st, ':sid', $shop_id); oci_execute($st);
$total_orders = oci_fetch_assoc($st)['TOTAL'] ?? 0;

// ── KPI: Total Delivered ───────────────────────────────────────
$st2 = oci_parse($conn, "SELECT COUNT(DISTINCT o.order_ID) AS total FROM ORDERS o
    JOIN ORDER_ITEM oi ON oi.order_ID = o.order_ID
    WHERE oi.shop_ID = :sid AND o.order_status = 'COLLECTED'");
oci_bind_by_name($st2, ':sid', $shop_id); oci_execute($st2);
$total_delivered = oci_fetch_assoc($st2)['TOTAL'] ?? 0;

// ── KPI: Total Revenue ─────────────────────────────────────────
$st3 = oci_parse($conn, "SELECT NVL(SUM(oi.quantity * oi.purchase_price),0) AS rev
    FROM ORDER_ITEM oi JOIN ORDERS o ON o.order_ID = oi.order_ID
    WHERE oi.shop_ID = :sid AND o.order_status != 'CANCELLED'");
oci_bind_by_name($st3, ':sid', $shop_id); oci_execute($st3);
$total_revenue = oci_fetch_assoc($st3)['REV'] ?? 0;

// ── Recent Customers ───────────────────────────────────────────
$st4 = oci_parse($conn, "SELECT u.first_name, u.last_name, u.email,
    NVL(SUM(oi.quantity * oi.purchase_price),0) AS spent
    FROM ORDERS o JOIN ORDER_ITEM oi ON oi.order_ID = o.order_ID
    JOIN USER_ACCOUNT u ON u.user_ID = o.user_ID
    WHERE oi.shop_ID = :sid
    GROUP BY u.first_name, u.last_name, u.email
    ORDER BY spent DESC FETCH FIRST 5 ROWS ONLY");
oci_bind_by_name($st4, ':sid', $shop_id); oci_execute($st4);
$customers = [];
while ($r = oci_fetch_assoc($st4)) $customers[] = $r;

// Fallback sample customers if DB empty
if (empty($customers)) {
    $customers = [
        ['FIRST_NAME'=>'Peter',  'LAST_NAME'=>'Parker', 'EMAIL'=>'p.parker@dailybugle.com', 'SPENT'=>450.00],
        ['FIRST_NAME'=>'Thomas', 'LAST_NAME'=>'Johnson','EMAIL'=>'thomas.j@outlook.com',     'SPENT'=>1200.00],
        ['FIRST_NAME'=>'Riya',   'LAST_NAME'=>'Thapa',  'EMAIL'=>'riya.thapa@tech.io',       'SPENT'=>85.50],
        ['FIRST_NAME'=>'Saha',   'LAST_NAME'=>'Rani',   'EMAIL'=>'rani.saha@domain.net',     'SPENT'=>235.00],
    ];
}

// ── Low Stock ──────────────────────────────────────────────────
$st5 = oci_parse($conn, "SELECT product_name, stock FROM PRODUCT
    WHERE shop_ID = :sid AND stock <= 10 ORDER BY stock ASC");
oci_bind_by_name($st5, ':sid', $shop_id); oci_execute($st5);
$low_stock = [];
while ($r = oci_fetch_assoc($st5)) $low_stock[] = $r;

if (empty($low_stock)) {
    $low_stock = [
        ['PRODUCT_NAME'=>'Hand-crafted Ceramic Vase', 'STOCK'=>2],
        ['PRODUCT_NAME'=>'Organic Lavender Oil (50ml)', 'STOCK'=>5],
    ];
}

// ── Latest Reviews ─────────────────────────────────────────────
$st6 = oci_parse($conn, "SELECT r.rating, r.review_description, u.first_name, u.last_name
    FROM REVIEW r JOIN PRODUCT p ON p.product_ID = r.product_ID
    JOIN USER_ACCOUNT u ON u.user_ID = r.user_ID
    WHERE p.shop_ID = :sid ORDER BY r.review_date DESC FETCH FIRST 3 ROWS ONLY");
oci_bind_by_name($st6, ':sid', $shop_id); oci_execute($st6);
$reviews = [];
while ($r = oci_fetch_assoc($st6)) $reviews[] = $r;

if (empty($reviews)) {
    $reviews = [
        ['RATING'=>5,'REVIEW_DESCRIPTION'=>'The quality of the botanical extracts is unparalleled. Fast shipping too!','FIRST_NAME'=>'Clara','LAST_NAME'=>'M.'],
        ['RATING'=>4,'REVIEW_DESCRIPTION'=>'Beautiful packaging, though the box had a small dent. Product is 10/10.','FIRST_NAME'=>'James','LAST_NAME'=>'H.'],
    ];
}

// ── Monthly Chart Data ─────────────────────────────────────────
$st7 = oci_parse($conn, "SELECT TO_CHAR(o.order_date,'Mon') AS mon,
    NVL(SUM(oi.quantity * oi.purchase_price),0) AS revenue,
    COUNT(DISTINCT o.order_ID) AS orders
    FROM ORDERS o JOIN ORDER_ITEM oi ON oi.order_ID = o.order_ID
    WHERE oi.shop_ID = :sid AND o.order_date >= ADD_MONTHS(SYSDATE,-6)
    GROUP BY TO_CHAR(o.order_date,'Mon'), TO_CHAR(o.order_date,'YYYYMM')
    ORDER BY TO_CHAR(o.order_date,'YYYYMM')");
oci_bind_by_name($st7, ':sid', $shop_id); oci_execute($st7);
$chart_labels = []; $chart_revenue = []; $chart_orders = [];
while ($r = oci_fetch_assoc($st7)) {
    $chart_labels[]  = $r['MON'];
    $chart_revenue[] = (float)$r['REVENUE'];
    $chart_orders[]  = (int)$r['ORDERS'];
}
if (empty($chart_labels)) {
    $chart_labels  = ['JAN','FEB','MAR','APR','MAY','JUN'];
    $chart_revenue = [120, 180, 140, 220, 175, 260];
    $chart_orders  = [8, 12, 9, 15, 11, 17];
}

oci_close($conn);

$user_name = $_SESSION['user_name'] ?? 'Trader';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Trader Dashboard – Hudders Hub</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<style>
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
:root{
  --bg:#ede8df;
  --sidebar:#ddd8ce;
  --white:#fff;
  --dark:#1a3322;
  --green:#2d6a4f;
  --accent:#52b788;
  --text:#2c2c2c;
  --muted:#6b7280;
  --red:#dc3545;
  --card-shadow:0 2px 16px rgba(0,0,0,.07);
  --radius:14px;
}
body{font-family:'Inter',sans-serif;background:var(--bg);color:var(--text);display:flex;min-height:100vh}

/* ══ SIDEBAR ══════════════════════════════════════════ */
.sidebar{
  width:195px;min-height:100vh;background:var(--sidebar);
  display:flex;flex-direction:column;padding:20px 0;
  position:fixed;top:0;left:0;bottom:0;z-index:100;
}
.sidebar-logo{
  display:flex;align-items:center;gap:10px;
  padding:0 18px 28px;
}
.sidebar-logo img{width:48px;height:48px;object-fit:contain;border-radius:8px}
.nav-list{flex:1}
.nav-item{
  display:flex;align-items:center;gap:12px;
  padding:11px 18px;cursor:pointer;color:var(--text);
  text-decoration:none;font-size:13.5px;font-weight:500;
  transition:background .18s,color .18s;
}
.nav-item:hover{background:rgba(45,106,79,.1);color:var(--green)}
.nav-item.active{
  background:var(--dark);color:#fff;
  border-radius:9px;margin:2px 10px;padding:11px 14px;
}
.nav-item i{width:22px;text-align:center;font-size:15px}
.sidebar-footer{padding:18px 18px 6px;margin-top:auto}
.signout-btn{
  display:flex;align-items:center;gap:9px;
  color:var(--muted);font-size:13.5px;font-weight:500;
  cursor:pointer;background:none;border:none;
  font-family:inherit;padding:6px 0;
  transition:color .18s;
}
.signout-btn:hover{color:var(--red)}

/* ══ MAIN ═════════════════════════════════════════════ */
.main{margin-left:195px;flex:1;padding:28px 32px;min-height:100vh}

.page-header{
  display:flex;align-items:center;gap:12px;
  padding-bottom:18px;margin-bottom:26px;
  border-bottom:1px solid #cec9bf;
}
.page-header i{font-size:20px;color:var(--dark)}
.page-header h1{font-size:21px;font-weight:700;color:var(--dark)}

/* ══ KPI CARDS ════════════════════════════════════════ */
.kpi-row{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-bottom:22px}
.kpi-card{
  background:var(--white);border-radius:var(--radius);
  padding:22px;box-shadow:var(--card-shadow);
  position:relative;overflow:hidden;
}
.kpi-card.dark{background:var(--dark);color:#fff}
.kpi-icon{
  width:38px;height:38px;border-radius:9px;
  background:#f0f7f4;display:flex;align-items:center;
  justify-content:center;margin-bottom:14px;
}
.kpi-card.dark .kpi-icon{background:rgba(255,255,255,.13)}
.kpi-icon i{color:var(--green);font-size:17px}
.kpi-card.dark .kpi-icon i{color:#fff}
.kpi-badge{
  position:absolute;top:16px;right:16px;
  background:#f0fdf4;color:#16a34a;
  font-size:10.5px;font-weight:700;
  padding:3px 8px;border-radius:20px;
}
.kpi-card.dark .kpi-badge{background:rgba(255,255,255,.16);color:#86efac}
.kpi-label{
  font-size:10.5px;font-weight:700;letter-spacing:.08em;
  text-transform:uppercase;color:var(--muted);margin-bottom:5px;
}
.kpi-card.dark .kpi-label{color:rgba(255,255,255,.6)}
.kpi-value{font-size:30px;font-weight:800;color:var(--dark)}
.kpi-card.dark .kpi-value{color:#fff}
.kpi-bg-icon{
  position:absolute;bottom:-14px;right:-8px;
  font-size:78px;opacity:.05;color:var(--dark);
}
.kpi-card.dark .kpi-bg-icon{color:#fff;opacity:.09}

/* ══ CHARTS ROW ═══════════════════════════════════════ */
.charts-row{display:grid;grid-template-columns:1fr 310px;gap:18px;margin-bottom:22px}
.chart-card{
  background:var(--white);border-radius:var(--radius);
  padding:22px;box-shadow:var(--card-shadow);
}
.chart-title{font-size:14.5px;font-weight:700;color:var(--dark);margin-bottom:3px}
.chart-sub{font-size:11.5px;color:var(--muted);margin-bottom:14px}
.legend{display:flex;gap:14px;margin-bottom:12px}
.legend span{font-size:10.5px;font-weight:700;display:flex;align-items:center;gap:5px;text-transform:uppercase;letter-spacing:.05em;color:var(--muted)}
.legend .dot{width:8px;height:8px;border-radius:50%;display:inline-block;flex-shrink:0}
.chart-stat{font-size:27px;font-weight:800;color:var(--dark);margin-top:10px}
.chart-stat-sub{font-size:10.5px;color:var(--muted);text-transform:uppercase;letter-spacing:.07em}

/* ══ BOTTOM ROW ═══════════════════════════════════════ */
.bottom-row{display:grid;grid-template-columns:1fr 330px;gap:18px}
.panel{background:var(--white);border-radius:var(--radius);padding:22px;box-shadow:var(--card-shadow)}
.panel-header{display:flex;justify-content:space-between;align-items:center;margin-bottom:16px}
.panel-title{font-size:14.5px;font-weight:700;color:var(--dark)}
.view-all{font-size:11.5px;color:var(--green);text-decoration:none;font-weight:700;letter-spacing:.04em}
.view-all:hover{text-decoration:underline}

/* Customer rows */
.customer-row{
  display:flex;align-items:center;gap:13px;
  padding:9px 0;border-bottom:1px solid #f0ece4;
}
.customer-row:last-child{border-bottom:none}
.avatar{
  width:34px;height:34px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;
  font-weight:700;font-size:12px;color:#fff;flex-shrink:0;
}
.av-1{background:#2d6a4f} .av-2{background:#e76f51}
.av-3{background:#457b9d} .av-4{background:#6d6875}
.av-5{background:#e9c46a;color:#333}
.customer-info{flex:1;min-width:0}
.customer-name{font-size:13px;font-weight:600;color:var(--dark)}
.customer-email{font-size:11px;color:var(--muted);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.customer-spent{font-size:13px;font-weight:700;color:var(--dark);flex-shrink:0}

/* Right panels */
.right-panels{display:flex;flex-direction:column;gap:0}
.alert-section{border-left:3px solid var(--red);padding-left:14px;margin-bottom:18px}
.alert-title{
  font-size:11px;font-weight:800;text-transform:uppercase;
  letter-spacing:.07em;color:var(--red);
  display:flex;align-items:center;gap:6px;margin-bottom:10px;
}
.stock-row{
  display:flex;justify-content:space-between;align-items:center;
  padding:7px 0;border-bottom:1px solid #f3f0eb;font-size:12.5px;color:var(--text);
}
.stock-row:last-child{border-bottom:none}
.stock-badge{
  background:var(--red);color:#fff;font-size:10px;
  font-weight:700;padding:2px 8px;border-radius:20px;white-space:nowrap;
}
.reviews-title{
  font-size:11px;font-weight:800;text-transform:uppercase;
  letter-spacing:.07em;color:var(--dark);
  display:flex;align-items:center;gap:6px;margin-bottom:12px;
}
.review-item{margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid #f3f0eb}
.review-item:last-child{border-bottom:none;margin-bottom:0;padding-bottom:0}
.stars{color:#f59e0b;font-size:13px;margin-bottom:4px}
.review-text{font-size:11.5px;color:#555;font-style:italic;margin-bottom:3px;line-height:1.55}
.review-author{font-size:11px;color:var(--muted);font-weight:600}

/* Page views icon row */
.pv-footer{display:flex;justify-content:space-between;align-items:flex-end;margin-top:6px}
.pv-icon{color:var(--muted);font-size:16px}

@media(max-width:1100px){
  .charts-row,.bottom-row{grid-template-columns:1fr}
  .kpi-row{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:700px){
  .sidebar{width:60px}
  .sidebar-logo span,.nav-item span,.signout-btn span{display:none}
  .main{margin-left:60px;padding:16px}
}
</style>
</head>
<body>

<!-- ══ SIDEBAR ════════════════════════════════════════════════ -->
<aside class="sidebar">
  <div class="sidebar-logo">
    <img src="../assets/css/image/logo.png" alt="Hudders Hub" onerror="this.style.display='none'">
  </div>

  <nav class="nav-list">
    <a href="Traderdashboard.php" class="nav-item active">
      <i class="fas fa-chart-bar"></i><span>Dashboard</span>
    </a>
    <a href="trader_profile.php" class="nav-item">
      <i class="fas fa-store"></i><span>Trader</span>
    </a>
    <a href="customers.php" class="nav-item">
      <i class="fas fa-users"></i><span>Customer</span>
    </a>
    <a href="products.php" class="nav-item">
      <i class="fas fa-box-open"></i><span>Product</span>
    </a>
    <a href="orders.php" class="nav-item">
      <i class="fas fa-receipt"></i><span>Orders</span>
    </a>
  </nav>

  <div class="sidebar-footer">
    <a href="../logout.php" class="signout-btn">
      <i class="fab fa-google" style="font-size:15px"></i>
      <span>Sign out</span>
    </a>
  </div>
</aside>

<!-- ══ MAIN CONTENT ═══════════════════════════════════════════ -->
<main class="main">

  <!-- Header -->
  <div class="page-header">
    <i class="fas fa-th-large"></i>
    <h1>Trader DashBoard</h1>
  </div>

  <!-- KPI Cards -->
  <div class="kpi-row">
    <div class="kpi-card">
      <div class="kpi-badge">↑ +12.5%</div>
      <div class="kpi-icon"><i class="fas fa-shopping-basket"></i></div>
      <div class="kpi-label">Total Orders</div>
      <div class="kpi-value"><?= number_format($total_orders) ?></div>
      <div class="kpi-bg-icon"><i class="fas fa-shopping-basket"></i></div>
    </div>

    <div class="kpi-card">
      <div class="kpi-badge">↑ +8.3%</div>
      <div class="kpi-icon"><i class="fas fa-truck"></i></div>
      <div class="kpi-label">Total Delivered</div>
      <div class="kpi-value"><?= number_format($total_delivered) ?></div>
      <div class="kpi-bg-icon"><i class="fas fa-truck"></i></div>
    </div>

    <div class="kpi-card dark">
      <div class="kpi-badge">↑ +24%</div>
      <div class="kpi-icon"><i class="fas fa-pound-sign"></i></div>
      <div class="kpi-label">Total Revenue</div>
      <div class="kpi-value">£<?= number_format($total_revenue, 2) ?></div>
      <div class="kpi-bg-icon"><i class="fas fa-chart-line"></i></div>
    </div>
  </div>

  <!-- Charts Row -->
  <div class="charts-row">
    <!-- Line Chart -->
    <div class="chart-card">
      <div class="chart-title">Production &amp; Sales Overview</div>
      <div class="chart-sub">Real-time infographic of workshop activity</div>
      <div class="legend">
        <span><span class="dot" style="background:#1a3322"></span>Production</span>
        <span><span class="dot" style="background:#52b788"></span>Sale</span>
        <span><span class="dot" style="background:#b7e4c7"></span>Marketing</span>
      </div>
      <canvas id="salesChart" height="155"></canvas>
    </div>

    <!-- Bar Chart -->
    <div class="chart-card">
      <div class="chart-title">Page Views</div>
      <div class="chart-sub">Weekly engagement trend</div>
      <canvas id="viewsChart" height="170"></canvas>
      <div class="pv-footer">
        <div>
          <div class="chart-stat">12,482</div>
          <div class="chart-stat-sub">Unique Hits</div>
        </div>
        <div class="pv-icon"><i class="fas fa-desktop"></i></div>
      </div>
    </div>
  </div>

  <!-- Bottom Row -->
  <div class="bottom-row">

    <!-- Recent Customers -->
    <div class="panel">
      <div class="panel-header">
        <div class="panel-title">Recent Customers</div>
        <a href="customers.php" class="view-all">VIEW ALL</a>
      </div>

      <?php
      $colors = ['av-1','av-2','av-3','av-4','av-5'];
      foreach ($customers as $i => $c):
        $initials = strtoupper(substr($c['FIRST_NAME'],0,1).substr($c['LAST_NAME'],0,1));
        $cls = $colors[$i % count($colors)];
      ?>
      <div class="customer-row">
        <div class="avatar <?= $cls ?>"><?= $initials ?></div>
        <div class="customer-info">
          <div class="customer-name"><?= htmlspecialchars($c['FIRST_NAME'].' '.$c['LAST_NAME']) ?></div>
          <div class="customer-email"><?= htmlspecialchars($c['EMAIL']) ?></div>
        </div>
        <div class="customer-spent">£<?= number_format($c['SPENT'],2) ?></div>
      </div>
      <?php endforeach; ?>
    </div>

    <!-- Right: Alerts + Reviews -->
    <div class="right-panels">
      <div class="panel">

        <!-- Low Stock Alerts -->
        <div class="alert-section">
          <div class="alert-title">
            <i class="fas fa-exclamation-triangle"></i> Low Stock Alerts
          </div>
          <?php foreach ($low_stock as $ls): ?>
          <div class="stock-row">
            <span><?= htmlspecialchars($ls['PRODUCT_NAME']) ?></span>
            <span class="stock-badge"><?= (int)$ls['STOCK'] ?> Left</span>
          </div>
          <?php endforeach; ?>
        </div>

        <!-- Latest Reviews -->
        <div class="reviews-title">
          <i class="fas fa-comment-alt"></i> Latest Reviews
        </div>
        <?php foreach ($reviews as $rev):
          $stars = str_repeat('★',(int)$rev['RATING']).str_repeat('☆',5-(int)$rev['RATING']);
        ?>
        <div class="review-item">
          <div class="stars"><?= $stars ?></div>
          <div class="review-text">"<?= htmlspecialchars(substr($rev['REVIEW_DESCRIPTION']??'',0,110)) ?>"</div>
          <div class="review-author">— <?= htmlspecialchars($rev['FIRST_NAME'].' '.substr($rev['LAST_NAME'],0,1).'.') ?></div>
        </div>
        <?php endforeach; ?>

      </div>
    </div>
  </div>

</main>

<script>
// ── Sales Line Chart ───────────────────────────────────────────
const labels      = <?= json_encode($chart_labels) ?>;
const revenueData = <?= json_encode($chart_revenue) ?>;
const ordersData  = <?= json_encode($chart_orders) ?>;
const marketing   = revenueData.map(v => v * 0.3);

new Chart(document.getElementById('salesChart').getContext('2d'), {
  type: 'line',
  data: {
    labels,
    datasets: [
      { label:'Production', data:revenueData,
        borderColor:'#1a3322', backgroundColor:'rgba(26,51,34,0.07)',
        borderWidth:2.5, tension:0.5, fill:true, pointRadius:0 },
      { label:'Sale', data:ordersData.map(v=>v*8),
        borderColor:'#52b788', backgroundColor:'rgba(82,183,136,0.07)',
        borderWidth:2.5, tension:0.5, fill:true, pointRadius:0 },
      { label:'Marketing', data:marketing,
        borderColor:'#b7e4c7', backgroundColor:'rgba(183,228,199,0.07)',
        borderWidth:2, tension:0.5, fill:true, pointRadius:0 }
    ]
  },
  options:{
    responsive:true,
    plugins:{ legend:{display:false} },
    scales:{
      x:{ grid:{display:false}, ticks:{font:{size:10.5}, color:'#999'} },
      y:{ grid:{color:'#f0ece4'}, ticks:{font:{size:10.5}, color:'#999'} }
    }
  }
});

// ── Page Views Bar Chart ───────────────────────────────────────
new Chart(document.getElementById('viewsChart').getContext('2d'), {
  type:'bar',
  data:{
    labels:['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
    datasets:[{
      data:[1800,2100,1650,2400,2050,1900,2300],
      backgroundColor:'#1a3322',
      borderRadius:5,
      borderSkipped:false
    }]
  },
  options:{
    responsive:true,
    plugins:{ legend:{display:false} },
    scales:{
      x:{ grid:{display:false}, ticks:{font:{size:10}, color:'#999'} },
      y:{ display:false }
    }
  }
});
</script>

</body>
</html>
