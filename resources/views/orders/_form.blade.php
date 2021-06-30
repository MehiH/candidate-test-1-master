@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Customer</label>
            <select class="form-control first_name" name="customer_id">
              @foreach ($customers as $c)
                @if( $c->id == $order->customer_id)
                <option selected value="{{ $c->id }}">{{ $c->first_name }} {{ $c->last_name }}</option>
                @else
                <option value="{{ $c->id }}">{{ $c->first_name }} {{ $c->last_name }}</option>
                @endif
              @endforeach
              
            </select>
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Title</label>
          <input type="text" name="title" class="form-control" value="{{ old('title', $order->title) }}">
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-12">
        <div class="form-group">
          <label>Description</label>
          <textarea type="description" name="description" class="form-control" value="{{ old('description', $order->description) }}">{{ old('description', $order->description) }} </textarea>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label>Cost</label>
          <input type="text" name="cost" class="form-control" value="{{ old('cost', $order->cost) }}">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label>Tags</label>
            <select class="form-control tags" name="tags[]" multiple="multiple">
                @foreach ($tags as $t)
                  @if(in_array($t->id, $selectedtag))
                  <option selected value="{{ $t->id }}">{{ $t->name }}</option>
                  @else
                  <option value="{{ $t->id }}">{{ $t->name }}</option>
                  @endif
                @endforeach
            </select>
        </div>
      </div>
    </div>
    <script>
    $(document).ready(function() {
        $('.first_name').select2();
        $('.tags').select2();
    });
    </script>
