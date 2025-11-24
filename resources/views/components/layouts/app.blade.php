<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main>
        {{ $slot }}
        <!-- Modal de Confirmación Global -->
        <div class="modal-overlay" id="confirmModalOverlay" onclick="closeModalOnBackdrop(event)">
            <div class="modal-container">
                <div class="modal-icon">
                    ⚠️
                </div>
                <h2 class="modal-title" id="confirmModalTitle">¿Estás seguro?</h2>
                <p class="modal-message" id="confirmModalMessage">
                    ¿Estás seguro de que deseas realizar esta acción?
                </p>
                <div class="modal-buttons">
                    <button class="btn-modal btn-modal-cancel" onclick="closeConfirmModal()">
                        Cancelar
                    </button>
                    <button class="btn-modal btn-modal-confirm" id="confirmModalButton">
                        Confirmar
                    </button>
                </div>
            </div>
        </div>

        <script>
            let confirmCallback = null;

            // Mostrar modal de confirmación
            function showConfirmModal(title, message, confirmText, callback) {
                document.getElementById('confirmModalTitle').textContent = title;
                document.getElementById('confirmModalMessage').textContent = message;
                document.getElementById('confirmModalButton').textContent = confirmText;

                confirmCallback = callback;
                document.getElementById('confirmModalOverlay').classList.add('active');
            }

            // Cerrar modal
            function closeConfirmModal() {
                document.getElementById('confirmModalOverlay').classList.remove('active');
                confirmCallback = null;
            }

            // Cerrar al hacer clic en el fondo
            function closeModalOnBackdrop(event) {
                if (event.target === event.currentTarget) {
                    closeConfirmModal();
                }
            }

            // Confirmar acción
            document.getElementById('confirmModalButton').addEventListener('click', function() {
                if (confirmCallback) {
                    confirmCallback();
                }
                closeConfirmModal();
            });

            // Cerrar con tecla ESC
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeConfirmModal();
                }
            });
        </script>
        </body>
        </html>
    </flux:main>
</x-layouts.app.sidebar>
