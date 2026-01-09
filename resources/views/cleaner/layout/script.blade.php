 <script src="{{ asset('backend/assets/vendor/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('backend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
 <script src="{{ asset('backend/assets/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
 <script src="{{ asset('backend/assets/js/ruang-admin.min.js') }}"></script>
 <script src="{{ asset('backend/assets/vendor/chart.js/Chart.min.js') }}"></script>
 <script src="{{ asset('backend/assets/js/demo/chart-area-demo.js') }}"></script>
 <!-- Page level plugins -->
 <script src="{{ asset('backend/assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
 <script src="{{ asset('backend/assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

 <!-- Page level custom scripts -->
 <script>
     $(document).ready(function() {
         $('#dataTable').DataTable(); // ID From dataTable 
         $('#dataTableHover').DataTable(); // ID From dataTable with Hover
     });
 </script>

 <script src="https://cdn.jsdelivr.net/npm/summernote@0.9.0/dist/summernote.min.js"></script>
 <script>
     $(document).ready(function() {
         $('.summernote').summernote();
     });
 </script>

 <script>
     function confirmDelete(id) {
         Swal.fire({
             title: 'Are you sure?',
             text: "This item will be deleted!",
             icon: 'warning',
             showCancelButton: true,
             confirmButtonColor: '#d33',
             confirmButtonText: 'Yes, delete it!'
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById('delete-form-' + id).submit();
             }
         });
     }
 </script>
