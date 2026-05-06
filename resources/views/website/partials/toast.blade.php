<!-- ✅ Bootstrap Toasts -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 1100;">
    {{-- ✅ Success Toast --}}
    @if (session('success'))
        <div class="toast align-items-center border-0 show fade" style="background-color:#b3d33c !important; color:#000;"
            role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    {{ session('success') }}
                </div>
                <button type="button" class="btn-close btn-close-black me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    {{-- ❌ Error Toast --}}
    @if (session('error'))
        <div class="toast align-items-center border-0 show fade"
            style="background-color:#dc3545 !important; color:#fff;" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    {{ session('error') }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif

    {{-- ⚠ Validation Error Toast --}}
    @if ($errors->any())
        <div class="toast align-items-center border-0 show fade"
            style="background-color:#dc3545 !important; color:#fff;" role="alert">
            <div class="d-flex">
                <div class="toast-body fw-semibold">
                    {{ $errors->first() }}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    @endif
</div>

<!-- Bootstrap Toast JS -->
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const toastElList = [].slice.call(document.querySelectorAll('.toast'));
        toastElList.map(toastEl => {
            const toast = new bootstrap.Toast(toastEl, {
                delay: 3500
            });
            toast.show();
        });
    });
</script>
