document.addEventListener('DOMContentLoaded', () => {
  const themeToggle = document.getElementById('theme-toggle');
  const html = document.documentElement;
  const body = document.body;

  // Fungsi untuk set theme
  function setTheme(theme) {
    if (theme === 'dark') {
      html.setAttribute('data-bs-theme', 'dark');
      body.classList.add('dark-mode');
      themeToggle.innerHTML = '<i class="bi bi-sun-fill"></i> Light Mode';
      localStorage.setItem('theme', 'dark');
    } else {
      html.setAttribute('data-bs-theme', 'light');
      body.classList.remove('dark-mode');
      themeToggle.innerHTML = '<i class="bi bi-moon-fill"></i> Dark Mode';
      localStorage.setItem('theme', 'light');
    }
  }

  // Cek preferensi mode dari localStorage, default selalu Light Mode
  const savedTheme = localStorage.getItem('theme');
  const initialTheme = savedTheme || 'light'; // Default: light mode
  
  setTheme(initialTheme);

  // Event listener untuk tombol toggle
  themeToggle.addEventListener('click', () => {
    const currentTheme = body.classList.contains('dark-mode') ? 'dark' : 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    setTheme(newTheme);
  });
});