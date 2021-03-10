<!-- Seats Field -->
<div class="form-group col-sm-6">
    {!! Form::label('seats', 'Seats:') !!}
    {!! Form::number('seats', null, ['class' => 'form-control']) !!}
</div>

<!-- Weight Capacity Field -->
<div class="form-group col-sm-6">
    {!! Form::label('weight_capacity', 'Weight Capacity:') !!}
    {!! Form::number('weight_capacity', null, ['class' => 'form-control']) !!}
</div>

<!-- Gas Mileage Field -->
<div class="form-group col-sm-6">
    {!! Form::label('gas_mileage', 'Gas Mileage:') !!}
    {!! Form::number('gas_mileage', null, ['class' => 'form-control']) !!}
</div>

<!-- Make Field -->
<div class="form-group col-sm-6">
    {!! Form::label('make', 'Make:') !!}
    {!! Form::text('make', null, ['class' => 'form-control']) !!}
</div>

<!-- Model Field -->
<div class="form-group col-sm-6">
    {!! Form::label('model', 'Model:') !!}
    {!! Form::text('model', null, ['class' => 'form-control']) !!}
</div>

<!-- Year Field -->
<div class="form-group col-sm-6">
    {!! Form::label('year', 'Year:') !!}
    {!! Form::number('year', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('trucks.index') !!}" class="btn btn-default">Cancel</a>
</div>
