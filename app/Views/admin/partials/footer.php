<?php
/**
 * ===============================================
 * TEMPORARY COMMIT MARKER
 * Branch: lint_tests
 * Date: 2026-02-18
 * Description: Temporary header for CI validation.
 * ===============================================
 */

    </div>
    <script>
        const mobileMenuButton = document.getElementById('mobileMenuButton');
        const sidebar = document.querySelector('aside');

        mobileMenuButton.addEventListener('click', () => {
            sidebar.classList.toggle('-translate-x-full');
        });

        // Opcional: fechar sidebar ao clicar fora em mobile
        document.addEventListener('click', (event) => {
            if (!sidebar.contains(event.target) && !mobileMenuButton.contains(event.target) && window.innerWidth < 768) {
                if (!sidebar.classList.contains('-translate-x-full')) {
                    sidebar.classList.add('-translate-x-full');
                }
            }
        });
    </script>

</body>
</html>