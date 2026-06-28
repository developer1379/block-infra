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

            // Format numbers with commas
            function formatCurrency(num) {
                return num.toLocaleString('en-IN', {
                    maximumFractionDigits: 0
                });
            }

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

            // WORK CHANGE -> UPDATE UNIT BADGE
            $('#workSelect').change(function() {
                const selected = $('#workSelect option:selected');
                const unit = selected.val() ? (selected.data('unit') || '-') : '-';
                $('#qty-unit-badge').text(unit);
                calculate();
            });

            // UPDATE ON QUANTITY INPUT
            $('#qty').on('input keyup', function() {
                calculate();
            });

            // RESET BUTTON CLICK
            $('#resetBtn').click(function() {
                $('#categorySelect').val('').trigger('change');
                $('#workSelect').val('').trigger('change');
                $('#qty').val('');
                $('#qty-unit-badge').text('-');
                $('#resultCard').addClass('d-none');
                $('#resultPlaceholder').removeClass('d-none');
            });

            // CALCULATE BUTTON CLICK
            $('#calculateBtn').click(function() {
                calculate();
            });

            // MAIN CALCULATE FUNCTION
            function calculate() {
                const work = $('#workSelect option:selected');
                const qtyVal = $('#qty').val();
                const qty = parseFloat(qtyVal);

                if (!work.val() || !qtyVal || isNaN(qty) || qty <= 0) {
                    $('#resultCard').addClass('d-none');
                    $('#resultPlaceholder').removeClass('d-none');
                    return;
                }

                let lmin = parseFloat(work.data('lmin')) || 0;
                let lmax = parseFloat(work.data('lmax')) || 0;
                let mmin = parseFloat(work.data('mmin')) || 0;
                let mmax = parseFloat(work.data('mmax')) || 0;
                let unit = work.data('unit') || '';

                // Show formatted cost ranges
                $('#laborRange').text(formatCurrency(lmin) + ' - ' + formatCurrency(lmax) + ' / ' + unit);
                $('#materialRange').text(formatCurrency(mmin) + ' - ' + formatCurrency(mmax) + ' / ' + unit);

                // Show formatted totals
                $('#laborTotal').text(formatCurrency(lmin * qty) + ' - ' + formatCurrency(lmax * qty));
                $('#materialTotal').text(formatCurrency(mmin * qty) + ' - ' + formatCurrency(mmax * qty));

                // Recommend final cost (Labor + Material max if exists, else Labor max)
                const finalCostVal = mmax ? (mmax * qty) : (lmax * qty);
                $('#finalCost').text(formatCurrency(finalCostVal));
                
                // Set receipt metadata
                $('#rWork').text(work.text().trim());
                $('#rQty').text(qty);
                $('#rUnit').text(unit);

                // Calculate ratio progress bar (Labor max vs Material max)
                // If labor_material is mmax, it includes labor. So material ratio is mmax - lmax.
                let matPortion = Math.max(0, mmax - lmax);
                let totalMax = lmax + matPortion;
                let laborPct = totalMax ? Math.round((lmax / totalMax) * 100) : 40;
                let materialPct = 100 - laborPct;

                $('.comparison-bar-labor').css('width', laborPct + '%');
                $('.comparison-bar-material').css('width', materialPct + '%');

                // Toggle visibility cards
                $('#resultPlaceholder').addClass('d-none');
                $('#resultCard').removeClass('d-none');
            }

        });
    </script>
    <script>
        $(document).ready(function() {
            $('select[name="categories[]"]').select2({
                placeholder: '{{ __('Select multiple categories') }}',
                width: '100%'
            });
        });
    </script>
    @RegisterServiceWorkerScript
