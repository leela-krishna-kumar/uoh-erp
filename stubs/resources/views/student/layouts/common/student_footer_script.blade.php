 <!-- Javascript
    ================================================== -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="{{ asset('assets/js/uikit.js') }}"></script>
    <script src="{{ asset('assets/js/tippy.all.min.js') }}"></script>
    <script src="{{ asset('assets/js/simplebar.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script src="{{ asset('assets/js/bootstrap-select.min.js') }}"></script>
    <script src="https://unpkg.com/ionicons@5.2.3/dist/ionicons.js"></script>
    @stack('script')
    <!-- datatable Js -->
    
    <script src="{{ asset('dashboard/plugins/data-tables/js/datatables.min.js') }}"></script>
    <!-- Full calendar js -->

    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/moment.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/lib/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('dashboard/plugins/fullcalendar/js/fullcalendar.min.js') }}"></script>
    
    <script>
            // Find the element with the class "font-medium md:mt-1 md:text-base"
      const semesterElement = document.querySelector('.font-medium.md\\:mt-1.md\\:text-base');
      
      // Use a for loop to iterate from 1 to 5
      for (let i = 1; i <= 5; i++) {
         // Update the content of the element to display the current step
         semesterElement.textContent = i + ' Sem';
      
         // Use a delay to show each step
         await new Promise((resolve) => setTimeout(resolve, 1000));
      }
      
   @yield('page_js')
  </script>