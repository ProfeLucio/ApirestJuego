<!DOCTYPE html>
<html lang="es" class="dark">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>API de Juegos – UP Seminario I</title>
  <!-- Tailwind CSS via CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = { darkMode: 'class' }
  </script>
  <style>
    /* Transición navbar */
    .navbar { transition: background-color .3s; }
    .navbar.scrolled { background-color: rgba(31, 41, 55, .9); }
  </style>
</head>
<body class="bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 scroll-smooth">

  <!-- Navbar transparente y sticky -->
  <nav id="nav" class="navbar fixed w-full top-0 z-50 px-8 py-4 flex justify-between items-center">
    <a href="#" class="text-2xl font-bold text-red-500">API Juegos</a>
    <div class="space-x-6">
      <a href="#hero" class="hover:text-red-400">Inicio</a>
      <a href="#about" class="hover:text-red-400">Quiénes somos</a>
      <a href="#contact" class="hover:text-red-400">Contacto</a>
    </div>
  </nav>

  <!-- Hero full-screen -->
  <section id="hero" class="relative w-full h-screen">
    <div class="absolute inset-0 bg-cover bg-center filter brightness-50" style="background-image:url('/images/hero-bg.jpg');"></div>
    <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
      <h1 class="text-5xl md:text-6xl font-extrabold text-white mb-4">API REST de Juegos</h1>
      <p class="text-xl text-gray-200 mb-6">Gestiona usuarios, partidas y resultados de tus proyectos académicos</p>
      <a href="{{ url('/api/documentation') }}"
         class="bg-red-500 hover:bg-red-600 text-white font-semibold py-3 px-8 rounded-full transition">
        📘 Documentación Swagger
      </a>
    </div>
  </section>

  <!-- Sección “Quiénes somos” -->
  <section id="about" class="py-16 bg-white dark:bg-gray-800">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <h2 class="text-3xl font-bold mb-4 text-gray-800 dark:text-gray-100">Quiénes somos</h2>
      <p class="text-lg text-gray-600 dark:text-gray-300">
        Estudiantes de Ingeniería de Sistemas de la Universidad del Pacífico, asignatura Seminario de Actualización I,
        guiados por el docente Gonzalo Andrés Lucio.
      </p>
    </div>
  </section>

  <!-- Sección “Objetivos” -->
  <section class="py-16">
    <div class="max-w-5xl mx-auto px-6 grid md:grid-cols-2 gap-8">
      <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
        <h3 class="text-2xl font-semibold mb-3">Objetivo General</h3>
        <p>Registrar y gestionar datos de usuarios, partidas y aciertos de los juegos desarrollados.</p>
      </div>
      <div class="bg-gray-50 dark:bg-gray-700 p-6 rounded-lg shadow">
        <h3 class="text-2xl font-semibold mb-3">Objetivos Específicos</h3>
        <ul class="list-disc list-inside">
          <li>Crear API REST con Laravel 12.</li>
          <li>Implementar autenticación y validación.</li>
          <li>Exponer documentación con Swagger.</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- Footer / Contacto -->
  <footer id="contact" class="py-12 bg-gray-900 text-gray-300">
    <div class="max-w-4xl mx-auto px-6 text-center">
      <p>© {{ date('Y') }} Universidad del Pacífico – Seminario de Actualización I</p>
      <p>Desarrollado por estudiantes de Ingeniería de Sistemas</p>
    </div>
  </footer>

  <script>
    // Cambiar fondo de navbar al hacer scroll
    const nav = document.getElementById('nav');
    window.addEventListener('scroll', () => {
      nav.classList.toggle('scrolled', window.scrollY > 50);
    });
  </script>

</body>
</html>
