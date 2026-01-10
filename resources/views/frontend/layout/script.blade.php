{{-- SweetAlert2 --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>


{{-- Service Booking Payment Method --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {

        // 1) Confirm before submit (only when submit button exists)
        const form = document.getElementById('bookingForm');
        if (form && form.querySelector('button[type="submit"]')) {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Confirm Booking?',
                    text: 'Do you want to submit this booking request?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Submit',
                    cancelButtonText: 'Cancel',
                    confirmButtonColor: '#16a34a',
                    cancelButtonColor: '#64748b',
                }).then((result) => {
                    if (result.isConfirmed) form.submit();
                });
            });
        }

        // 2) Payment active class + toggle bKash fields
        const radios = document.querySelectorAll('input[name="payment_method"]');
        const bkashFields = document.getElementById('bkashFields');
        const bkashInfo = document.getElementById('bkashInfo');
        const bkashNumber = document.querySelector('input[name="bkash_number"]');
        const trxId = document.querySelector('input[name="transaction_id"]');

        function updatePaymentUI() {
            const checked = document.querySelector('input[name="payment_method"]:checked');
            const method = checked ? checked.value : 'cod';
            const isBkash = method === 'bkash';

            radios.forEach(r => {
                const li = r.closest('.payment-li');
                if (li) li.classList.toggle('active', r.checked);
            });

            if (bkashFields) bkashFields.hidden = !isBkash;
            if (bkashInfo) bkashInfo.hidden = !isBkash;

            if (bkashNumber) bkashNumber.required = isBkash;
            if (trxId) trxId.required = isBkash;

            if (!isBkash) {
                if (bkashNumber) bkashNumber.value = '';
                if (trxId) trxId.value = '';
            }
        }

        radios.forEach(r => r.addEventListener('change', updatePaymentUI));
        updatePaymentUI();
    });
</script>

{{-- SweetAlert2: show session messages --}}
@if (session('message'))
    <script>
        Swal.fire({
            icon: @json(session('alert-type') === 'success' ? 'success' : (session('alert-type') === 'warning' ? 'warning' : 'error')),
            title: @json(session('alert-type') === 'success' ? 'Success' : (session('alert-type') === 'warning' ? 'Warning' : 'Error')),
            text: @json(session('message')),
            confirmButtonColor: '#16a34a',
        });
    </script>
@endif

{{-- SweetAlert2: show validation errors --}}
@if ($errors->any())
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Please fix these errors',
            html: `{!! '<ul style="text-align:left;margin:0;padding-left:18px;">' . implode('', $errors->all('<li>:message</li>')) . '</ul>' !!}`,
            confirmButtonColor: '#16a34a',
        });
    </script>
@endif


<script>
    var swiper = new Swiper(".bannerSwiper", {
        loop: true,
        autoplay: {
            delay: 3000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        effect: "slide",
        speed: 800,
    });
</script>
