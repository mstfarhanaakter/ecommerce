<!-- includes/footer.php -->
    <!-- Main Content End -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Sidebar toggle for desktop
        document.getElementById('sidebarToggle')?.addEventListener('click', function () {
            document.querySelector('.sidebar').classList.toggle('collapsed');
            document.querySelector('main').style.marginLeft = 
                document.querySelector('.sidebar').classList.contains('collapsed') 
                ? 'var(--sidebar-collapsed-width)' 
                : 'var(--sidebar-width)';
        });
    </script>
</body>
</html>