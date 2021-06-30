@extends('layouts.app')

@section('content')
<div class="row">
  <div class="offset-md-10 col-md-2">
    <a href="{{ route('orders.create') }}" class="btn btn-primary btn-block">+ New Order</a>
  </div>
</div>
<br>
<div class="row">
  <div class="col-md-12">
    <table class="table">
      <thead class="thead-dark">
        <tr>
          <th scope="col">#</th>
          <th scope="col">Title</th>
          <th scope="col">Description</th>
          <th scope="col" colspan="2" class="text-center">Actions</th>
        </tr>
      </thead>
      <tbody>
        @foreach($orders as $order)
          <tr>
            <th scope="row">{{ $order->id }}</th>
            <td>{{ $order->title }}</td>
            <td>{{ $order->description }}</td>
            <td><a href="{{ route('orders.edit', $order) }}">[Edit]</a></td>
            <td><a href="#" onclick="save({{ $order }})">[Delete]</a></td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    {{ $orders->links() }}
  </div>
</div>

<script>
    $(document).ready(function() {
        
    });
    function save(order_here) {
          var token = $('meta[name="csrf-token"]').attr('content');
          $.ajax(
          {
              url: "{{ route('orders.destroy',"") }}"+"/"+order_here.id,
              type: 'DELETE',
              dataType: "JSON",
              data: {
                  "id": order_here,
                  "_method": 'DELETE',
                  "_token": token,
              },
              success: function (response)
              {
                alert(response.message);
                window.location.href = "{{route('orders.index')}}";
              }
          });
        }
</script>

@stop
