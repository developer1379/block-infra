    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('website/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('website/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('website/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('website/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('website/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('website/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>
    <script src="{{ asset('website/lib/isotope/isotope.pkgd.min.js') }}"></script>
    <script src="{{ asset('website/lib/lightbox/js/lightbox.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('website/js/main.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        console.log("Calculator JS loaded"); // DEBUG

        $(document).ready(function() {

            console.log("jQuery working"); // DEBUG

            $('.select2').select2();

            // CATEGORY CHANGE
            $('#categorySelect').change(function() {
                const cat = $(this).val();

                $('#workSelect option').each(function() {
                    const wCat = $(this).data('category');
                    if ($(this).val() === "" || wCat == cat) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });

                $('#workSelect').val('').trigger('change');
            });

            // UPDATE ON SELECT CHANGE
            $('#workSelect, #qty').on('change keyup', function() {
                calculate();
            });

            // BUTTON CLICK
            $('#calculateBtn').click(function() {
                console.log("Button clicked");
                calculate();
            });

            // MAIN CALCULATE FUNCTION
            function calculate() {

                const work = $('#workSelect option:selected');
                const qty = parseFloat($('#qty').val());

                if (!work.val() || !qty || qty <= 0) {
                    $('#resultCard').addClass('d-none');
                    return;
                }

                let lmin = parseFloat(work.data('lmin')) || 0;
                let lmax = parseFloat(work.data('lmax')) || 0;
                let mmin = parseFloat(work.data('mmin')) || 0;
                let mmax = parseFloat(work.data('mmax')) || 0;
                let unit = work.data('unit') || '';

                $('#laborRange').text(lmin + ' - ' + lmax + ' / ' + unit);
                $('#materialRange').text(mmin + ' - ' + mmax + ' / ' + unit);

                $('#laborTotal').text((lmin * qty) + ' - ' + (lmax * qty));
                $('#materialTotal').text((mmin * qty) + ' - ' + (mmax * qty));

                const finalCost = mmax ? (mmax * qty) : (lmax * qty);

                $('#finalCost').text(finalCost);
                $('#rWork').text(work.text());

                $('#resultCard').removeClass('d-none');
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="categories[]"]').select2({
                placeholder: 'Select multiple categories',
                width: '100%'
            });
        });
    </script>
    @RegisterServiceWorkerScript

    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
