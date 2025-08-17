<?php
session_start();
$err = '';
// hardcoded credential (ganti sesuai kebutuhan)
$ADMIN_USER = 'admin';
$ADMIN_PASS = 'password123';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $u = trim($_POST['username'] ?? '');
    $p = trim($_POST['password'] ?? '');
    if ($u === $ADMIN_USER && $p === $ADMIN_PASS) {
        $_SESSION['admin'] = true;
        header('Location: dashboard.php');
        exit;
    } else {
        $err = 'Username atau password salah.';
    }
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Admin Login - EventBoard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes fadeDown { from{opacity:0; transform:translateY(-10px)} to{opacity:1; transform:none} }
    .fade-down { animation: fadeDown .6s ease-out; }
  </style>
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-indigo-300 via-purple-300 to-pink-300">
  <div class="bg-white/30 backdrop-blur-lg p-8 rounded-2xl shadow-xl w-full max-w-md fade-down">
    <h2 class="text-2xl font-bold text-center mb-4">Login Admin</h2>
    <?php if($err): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-3"><?=htmlspecialchars($err)?></div>
    <?php endif; ?>
    <form method="post" class="space-y-4">
      <div>
        <label class="block text-gray-800 mb-1">Username</label>
        <input name="username" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
      </div>
      <div>
        <label class="block text-gray-800 mb-1">Password</label>
        <input name="password" type="password" required class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-500">
      </div>
      <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white font-semibold py-2 rounded-lg transition">Login</button>
    </form>
    <p class="mt-4 text-sm text-center text-white/80">Project demo: PHP + JSON (no DB)</p>
  </div>
</body>
</html>
