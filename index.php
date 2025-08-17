<?php
include 'config/config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>EventBoard - Elegant</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <style>
    @keyframes wave {
      0% { transform: translateX(0); }
      100% { transform: translateX(-50%); }
    }
    .animate-wave-slow {
      animation: wave 12s linear infinite;
    }
    .animate-wave-fast {
      animation: wave 6s linear infinite;
    }
  </style>
</head>
<body class="bg-gradient-to-b from-purple-100 to-white text-gray-800">

<!-- Navbar -->
<nav class="fixed w-full top-0 z-50 bg-white/30 backdrop-blur-md shadow-md">
  <div class="max-w-6xl mx-auto px-4 py-3 flex justify-between items-center">
    <h1 class="text-2xl font-bold text-purple-700">EventBoard</h1>
    
    <!-- Menu for desktop -->
    <div class="hidden md:flex space-x-6 text-lg">
      <a href="index.php" class="hover:text-purple-600 transition">Home</a>
      <a href="#events" class="hover:text-purple-600 transition">Events</a>
      <a href="dashboard.php" class="bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition">Login Admin</a>
    </div>

    <!-- Hamburger button for mobile -->
    <button id="menu-btn" class="md:hidden focus:outline-none">
      <svg class="w-6 h-6 text-purple-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M4 6h16M4 12h16m-7 6h7" />
      </svg>
    </button>
  </div>

  <!-- Mobile menu -->
  <div id="mobile-menu" class="hidden md:hidden px-4 pb-4 space-y-3 bg-white/90 backdrop-blur-md">
    <a href="index.php" class="block hover:text-purple-600 transition">Home</a>
    <a href="#events" class="block hover:text-purple-600 transition">Events</a>
    <a href="dashboard.php" class="block bg-purple-600 text-white px-4 py-2 rounded-full hover:bg-purple-700 transition">Login Admin</a>
  </div>
</nav>

<!-- Hero Section -->
<section class="pt-28 relative text-center overflow-hidden">
  <div class="max-w-4xl mx-auto px-4">
    <h2 data-aos="fade-up" class="text-5xl font-bold text-gray-800 mb-4">Temukan Event Terbaik</h2>
    <p data-aos="fade-up" data-aos-delay="200" class="text-lg text-gray-600 mb-6">Platform elegan untuk mendapatkan informasi event terbaru.</p>
    <a href="#events" data-aos="fade-up" data-aos-delay="400" class="bg-purple-600 text-white px-6 py-3 rounded-full shadow-lg hover:bg-purple-700 transition">Lihat Event</a>
  </div>
  
  <!-- Wave Animation -->
  <div class="relative mt-16">
    <svg class="absolute bottom-0 left-0 w-[200%] h-32 animate-wave-slow text-purple-300" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="currentColor" d="M0,64L40,80C80,96,160,128,240,149.3C320,171,400,181,480,165.3C560,149,640,107,720,117.3C800,128,880,192,960,197.3C1040,203,1120,149,1200,144C1280,139,1360,181,1400,202.7L1440,224L1440,320L0,320Z"></path>
    </svg>
    <svg class="absolute bottom-0 left-0 w-[200%] h-32 animate-wave-fast opacity-50 text-purple-400" viewBox="0 0 1440 320" preserveAspectRatio="none">
      <path fill="currentColor" d="M0,64L40,80C80,96,160,128,240,149.3C320,171,400,181,480,165.3C560,149,640,107,720,117.3C800,128,880,192,960,197.3C1040,203,1120,149,1200,144C1280,139,1360,181,1400,202.7L1440,224L1440,320L0,320Z"></path>
    </svg>
  </div>
</section>

<!-- Event Section -->
<section id="events" class="max-w-6xl mx-auto px-4 py-20 grid gap-8 md:grid-cols-3">
<?php
$sql = "SELECT * FROM events ORDER BY date ASC";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $delay = 0;
    while($row = $result->fetch_assoc()) {
        echo '<div data-aos="zoom-in" data-aos-delay="'.$delay.'" class="bg-white/70 backdrop-blur-lg rounded-2xl shadow-lg p-5 hover:shadow-xl transition transform hover:-translate-y-2">';
        echo '<img src="'.$row['image'].'" class="rounded-xl mb-4">';
        echo '<h3 class="text-xl font-semibold mb-2">'.$row['title'].'</h3>';
        echo '<p class="text-gray-600 text-sm mb-3">'.date("d F Y", strtotime($row['date'])).'</p>';
        echo '<p class="text-gray-700">'.$row['description'].'</p>';
        echo '</div>';
        $delay += 200;
    }
} else {
    echo "<p class='col-span-3 text-center text-gray-600'>Belum ada event.</p>";
}
$conn->close();
?>
</section>

<!-- Footer -->
<footer class="relative bg-gradient-to-t from-purple-700 to-purple-500 text-white pt-12 pb-6">
  <div class="max-w-6xl mx-auto px-4 grid md:grid-cols-3 gap-8">
    <div>
      <h4 class="text-lg font-bold mb-4">EventBoard</h4>
      <p>Platform untuk menemukan event-event terbaik di sekitar Anda.</p>
    </div>
    <div>
      <h4 class="text-lg font-bold mb-4">Kontak</h4>
      <p>Email: sinagasamuel903@gmail.com</p>
      <p>Wa: +62 88262326834</p>
    </div>
<div>
  <h4 class="text-lg font-bold mb-4">Media Sosial</h4>
  <div class="flex space-x-4">
    <a href="https://www.instagram.com/samuel_sinaga911?igsh=eXhhZG4zMGtpZGY3" target="_blank" class="hover:text-pink-400 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M7.75 2A5.75 5.75 0 002 7.75v8.5A5.75 5.75 0 007.75 22h8.5A5.75 5.75 0 0022 16.25v-8.5A5.75 5.75 0 0016.25 2h-8.5zm0 1.5h8.5A4.25 4.25 0 0120.5 7.75v8.5A4.25 4.25 0 0116.25 20.5h-8.5A4.25 4.25 0 013.5 16.25v-8.5A4.25 4.25 0 017.75 3.5zm9 2a.75.75 0 100 1.5.75.75 0 000-1.5zM12 7a5 5 0 100 10 5 5 0 000-10zm0 1.5a3.5 3.5 0 110 7 3.5 3.5 0 010-7z"/>
      </svg>
    </a>
    <a href="https://www.facebook.com/profile.php?id=100076403688587" target="_blank" class="hover:text-blue-500 transition">
      <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
        <path d="M13.5 9H15V6h-1.5a3 3 0 00-3 3v2H9v3h1.5v7h3v-7H15l.5-3h-3V9a.5.5 0 01.5-.5z"/>
      </svg>
    </a>
    
  </div>
</div>

  </div>
  <p class="text-center mt-8 text-sm">&copy; 2025 EventBoard. All rights reserved.</p>
</footer>

<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 1000, once: true });
</script>
<script src="script.js"></script>
</body>
</html>
