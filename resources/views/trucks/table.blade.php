<table class="table table-responsive" id="trucks-table">
  <thead>
    <tr>
      <th>Seats</th>
      <th>Weight Capacity</th>
      <th>Gas Mileage</th>
      <th>Make</th>
      <th>Model</th>
      <th>Year</th>
      <th colspan="3">Action</th>
    </tr>
  </thead>
  <tbody>
    @foreach($trucks as $truck)
      <tr>
        <td>{!! $truck->seats !!}</td>
        <td>{!! $truck->weight_capacity !!}</td>
        <td>{!! $truck->gas_mileage !!}</td>
        <td>{!! $truck->make !!}</td>
        <td>{!! $truck->model !!}</td>
        <td>{!! $truck->year !!}</td>
        <td>
          {!! Form::open(['route' => ['trucks.destroy', $truck->id], 'method' => 'delete']) !!}
          <div class='btn-group'>
            <a href="{!! route('trucks.show', [$truck->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-eye-open"></i></a>
            <a href="{!! route('trucks.edit', [$truck->id]) !!}" class='btn btn-default btn-xs'><i class="glyphicon glyphicon-edit"></i></a>
            {!! Form::button('<i class="glyphicon glyphicon-trash"></i>', ['type' => 'submit', 'class' => 'btn btn-danger btn-xs', 'onclick' => "return confirm('Are you sure?')"]) !!}
          </div>
          {!! Form::close() !!}
        </td>
      </tr>
    @endforeach
  </tbody>
</table>
