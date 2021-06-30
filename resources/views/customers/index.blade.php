@extends('layouts.app')

@section('content')
<div class="row">
  <div class="offset-md-10 col-md-2">
    <a href="{{ route('customers.create') }}" class="btn btn-primary btn-block">+ New Customer</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">First</th>
          <th scope="col">Last</th>
          <th scope="col">Email</th>
          <th scope="col">Phone</th>
          <th scope="col">Company</th>
          <th scope="col" colspan="2" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($customers as $customer)
          <tr>
            <th scope="row">{{ $customer->id }}</th>
            <td>{{ $customer->first_name }}</td>
            <td>{{ $customer->last_name }}</td>
            <td>{{ $customer->email }}</td>
            <td>{{ $customer->phone }}</td>
            <td>{{ $customer->company }}</td>
            <td><a href="{{ route('customers.edit', $customer) }}">[Edit]</a></td>
            <td><a href="#" onclick="save({{ $customer}})">[Delete]</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    {{ $customers->links() }}
  </div>
</div>

<script>
    $(document).ready(function() {
        $('.first_name').select2();
        $('.tags').select2();
        
    });
    function save(custom_here) {
          var token = $('meta[name="csrf-token"]').attr('content');
          $.ajax(
          {
              url: "{{ route('customers.destroy',"") }}"+"/"+custom_here.id,
              type: 'DELETE',
              dataType: "JSON",
              data: {
                  "id": custom_here,
                  "_method": 'DELETE',
                  "_token": token,
              },
              success: function (response)
              {
                alert(response.message);
                window.location.href = "{{route('customers.index')}}";
              }
          });
        }
</script>

@stop
