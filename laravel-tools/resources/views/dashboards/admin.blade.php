@extends('dashboards.template')
@section('content')
hello admin 

<script>
document.addEventListener('DOMContentLoaded', () => {
  if ('pushState' in window.history) {
    // Push a dummy state so back button triggers popstate
    window.history.pushState(null, '', window.location.href);

    // Listen for back button event
    window.addEventListener('popstate', () => {
      // Redirect to your desired route
      window.location.replace('/users/check-role');
    });
  }
});
</script>

@endsection


   
