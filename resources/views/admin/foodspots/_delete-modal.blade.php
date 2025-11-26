<div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center">
    <div class="absolute inset-0 bg-black bg-opacity-50 z-40"></div>
    <div class="bg-white rounded shadow-lg z-50 w-11/12 max-w-lg p-6">
        <h3 class="text-lg font-semibold">Confirm Delete</h3>
        <p class="text-sm text-gray-700 mt-2">Are you sure you want to delete this item? This action cannot be undone.</p>

        <form id="delete-modal-form" method="POST" class="mt-4">
            @csrf
            @method('DELETE')
            <div class="flex justify-end space-x-2">
                <button type="button" id="delete-modal-cancel" class="px-3 py-2 rounded border">Cancel</button>
                <button type="submit" class="px-3 py-2 rounded bg-red-600 text-white">Delete</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('delete-modal');
            const form = document.getElementById('delete-modal-form');
            const cancel = document.getElementById('delete-modal-cancel');

            function openDeleteModal(action) {
                form.action = action;
                modal.classList.remove('hidden');
                // focus the cancel button for immediate keyboard availability
                cancel.focus();
            }

            function closeDeleteModal() {
                form.action = '';
                modal.classList.add('hidden');
            }

            document.body.addEventListener('click', function (e) {
                const btn = e.target.closest && e.target.closest('.delete-btn');
                if (btn) {
                    e.preventDefault();
                    const action = btn.getAttribute('data-action');
                    if (action) openDeleteModal(action);
                }
            });

            cancel.addEventListener('click', function () {
                closeDeleteModal();
            });

            // close when clicking outside modal content
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeDeleteModal();
            });
        });
    </script>
@endpush
