<?php
session_start();
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit;
}
require 'config/config.php';

// Ambil semua event dari database
$events = [];
$sql = "SELECT * FROM events ORDER BY date DESC";
$result = $conn->query($sql);
if ($result && $result->num_rows > 0) {
    $events = $result->fetch_all(MYSQLI_ASSOC);
}
?>
<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Dashboard - EventBoard</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="min-h-screen bg-gray-100">

<!-- Navbar -->
<nav class="bg-white/80 backdrop-blur p-4 shadow">
  <div class="max-w-6xl mx-auto flex justify-between items-center">
    <div class="font-bold text-lg">EventBoard - Admin</div>
    <div class="space-x-3">
      <a href="../index.html" class="text-sm text-gray-600 hover:text-gray-900">Preview Public</a>
      <a href="logout.php" class="bg-red-500 text-white px-3 py-1 rounded">Logout</a>
    </div>
  </div>
</nav>

<main class="max-w-6xl mx-auto p-6">
  <div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-semibold">Kelola Event</h1>
    <button id="btnAdd" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Tambah Event</button>
  </div>

  <!-- Table -->
  <div class="bg-white rounded-xl shadow p-4 overflow-x-auto">
    <table class="w-full table-auto">
      <thead>
        <tr class="text-left text-sm text-gray-600">
          <th class="p-2">Title</th>
          <th class="p-2">Date</th>
          <th class="p-2">Image</th>
          <th class="p-2">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php if (!empty($events)): ?>
        <?php foreach($events as $e): ?>
        <tr class="border-t">
          <td class="p-2"><?= htmlspecialchars($e['title']) ?></td>
          <td class="p-2"><?= htmlspecialchars($e['date']) ?></td>
          <td class="p-2">
            <img src="<?= htmlspecialchars($e['image']) ?>" class="w-24 h-14 object-cover rounded" alt="">
          </td>
          <td class="p-2">
            <button 
              class="editBtn bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded"
              data-id="<?= $e['id'] ?>"
              data-title="<?= htmlspecialchars($e['title'], ENT_QUOTES) ?>"
              data-date="<?= $e['date'] ?>"
              data-desc="<?= htmlspecialchars($e['description'], ENT_QUOTES) ?>"
              data-image="<?= htmlspecialchars($e['image'], ENT_QUOTES) ?>"
            >Edit</button>
            <a href="delete_event.php?id=<?= $e['id'] ?>" onclick="return confirm('Hapus event ini?')" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">Hapus</a>
          </td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr>
          <td colspan="4" class="p-4 text-center text-gray-500">Belum ada event</td>
        </tr>
      <?php endif; ?>
      </tbody>
    </table>
  </div>
</main>

<!-- Modal -->
<div id="modal" class="fixed inset-0 bg-black/50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl w-full max-w-2xl p-6 shadow-xl">
    <h3 id="modalTitle" class="text-lg font-semibold mb-3">Tambah Event</h3>
    <form id="eventForm" method="post" action="save_event.php" enctype="multipart/form-data">
      <input type="hidden" name="id" id="eventId">
      <div class="grid gap-3 md:grid-cols-2">
        <div>
          <label class="text-sm">Judul</label>
          <input name="title" id="title" required class="w-full px-3 py-2 border rounded">
        </div>
        <div>
          <label class="text-sm">Tanggal</label>
          <input name="date" id="date" type="date" required class="w-full px-3 py-2 border rounded">
        </div>
        <div class="md:col-span-2">
          <label class="text-sm">Upload Gambar</label>
          <input type="file" name="image_file" id="image_file" class="w-full px-3 py-2 border rounded" accept="image/*">
        </div>
        <div class="md:col-span-2">
          <label class="text-sm">Atau Gambar (URL)</label>
          <input name="image_url" id="image_url" class="w-full px-3 py-2 border rounded" placeholder="https://...">
        </div>
        <div class="md:col-span-2">
          <label class="text-sm">Deskripsi</label>
          <textarea name="description" id="description" rows="4" class="w-full px-3 py-2 border rounded"></textarea>
        </div>
      </div>
      <div class="mt-4 flex justify-end gap-2">
        <button type="button" id="btnCancel" class="px-4 py-2 rounded border">Batal</button>
        <button type="submit" class="px-4 py-2 rounded bg-blue-600 text-white">Simpan</button>
      </div>
    </form>
  </div>
</div>

<script>
const modal = document.getElementById('modal');
const btnAdd = document.getElementById('btnAdd');
const btnCancel = document.getElementById('btnCancel');
const modalTitle = document.getElementById('modalTitle');
const form = document.getElementById('eventForm');

btnAdd.onclick = () => {
  modalTitle.textContent = 'Tambah Event';
  form.reset();
  document.getElementById('eventId').value = '';
  modal.classList.remove('hidden');
  modal.classList.add('flex');
};

btnCancel.onclick = () => {
  modal.classList.add('hidden');
  modal.classList.remove('flex');
};

document.querySelectorAll('.editBtn').forEach(btn => {
  btn.addEventListener('click', (e) => {
    const el = e.currentTarget;
    modalTitle.textContent = 'Edit Event';
    document.getElementById('eventId').value = el.dataset.id;
    document.getElementById('title').value = el.dataset.title;
    document.getElementById('date').value = el.dataset.date;
    document.getElementById('description').value = el.dataset.desc;
    document.getElementById('image_url').value = el.dataset.image;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
  });
});

modal.addEventListener('click', function(e){
  if (e.target === modal) {
    modal.classList.add('hidden');
    modal.classList.remove('flex');
  }
});
</script>
</body>
</html>
