<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Anthony Gibert">

  <!-- Favicon -->
  <link rel="shortcut icon" href="{{ asset('images/favicon.jpg') }}">
  <!-- CSFR token for ajax call -->
  <meta name="_token" content="{{ csrf_token() }}"/>
  <title>Manage trucks</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <!-- icheck checkboxes -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/yellow.css">
  <!-- toastr notifications -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

  <style>
  .panel-heading {
    padding: 0;
  }
  .panel-heading ul {
    list-style-type: none;
    margin: 0;
    padding: 0;
    overflow: hidden;
  }
  .panel-heading li {
    float: left;
    border-right:1px solid #bbb;
    display: block;
    padding: 14px 16px;
    text-align: center;
  }
  .panel-heading li:last-child:hover {
    background-color: #ccc;
  }
  .panel-heading li:last-child {
    border-right: none;
  }
  .panel-heading li a:hover {
    text-decoration: none;
  }
  .table.table-bordered tbody td {
    vertical-align: baseline;
  }
  /* icheck checkboxes */
  .icheckbox_square-yellow {
    background: url(https://i.pinimg.com/originals/f0/49/f0/f049f04d36f739137c2fcab4bb3905a7.png) no-repeat;
    background-position: center;
    background-size: contain;
  }
  .icheckbox_square-yellow.checked {
    background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Full_Star_Red.svg/64px-Full_Star_Red.svg.png) no-repeat;
    background-position: center;
    background-size: contain;
  }
  .icheckbox_square-yellow.hover {
    background: url(https://i.pinimg.com/originals/f0/49/f0/f049f04d36f739137c2fcab4bb3905a7.png) no-repeat;
    background-position: center;
    background-size: contain;
  }
  .icheckbox_square-yellow.checked.hover {
    background: url(https://upload.wikimedia.org/wikipedia/commons/thumb/f/f9/Full_Star_Red.svg/64px-Full_Star_Red.svg.png) no-repeat;
    background-position: center;
    background-size: contain;
  }
  </style>

</head>

<body>
  <div class="col-md-12">
    <h2 class="text-center">Manage trucks</h2>
  <br>
    <div class="panel panel-default">
      <div class="panel-heading">
        <ul>
          <li><i class="fa fa-file-text-o"></i> All the current trucks</li>
          <a href="#" class="add-modal" data-target="addData"><li >Add a truck</li></a>
        </ul>
      </div>

      <div class="panel-body">
        <table class="table table-striped table-bordered table-hover" id="postTable" style="visibility: hidden;">
          <thead>
            <tr>
              <th valign="middle">ID</th>
              <th>Seats</th>
              <th>Weight Capacity</th>
              <th>Gas Mileage</th>
              <th>Make</th>
              <th>Model</th>
              <th>Year</th>
              <th>Favorite?</th>
              <th>Last Updated</th>
              <th>Actions</th>
            </tr>
            {{ csrf_field() }}
          </thead>
          <tbody>
            @foreach($trucks as $truck)
              <tr class="item{{$truck->id}}
                @if($truck->favorite) warning @endif">
                  <td>{{$truck->id}}</td>
                  <td>{{$truck->seats}}</td>
                  <td>{{$truck->weight_capacity}}</td>
                  <td>{{$truck->gas_mileage}}</td>
                  <td>{{$truck->make}}</td>
                  <td>{{$truck->model}}</td>
                  <td>{{$truck->year}}</td>
                  <td class="text-center"><input type="checkbox" class="published" data-id="{{$truck->id}}"
                    @if ($truck->favorite) checked @endif></td>
                      <td>{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $truck->updated_at)->diffForHumans() }}</td>
                      <td>
                        <button class="show-modal btn btn-success" data-id="{{$truck->id}}" data-seats="{{$truck->seats}}" data-weightcapacity="{{$truck->weight_capacity}}"
                          data-gasmileage="{{$truck->gas_mileage}}" data-make="{{$truck->make}}" data-model="{{$truck->model}}" data-year="{{$truck->year}}">
                          <span class="glyphicon glyphicon-eye-open"></span> Show</button>
                          <button class="edit-modal btn btn-info" data-id="{{$truck->id}}" data-seats="{{$truck->seats}}" data-weightcapacity="{{$truck->weight_capacity}}"
                            data-gasmileage="{{$truck->gas_mileage}}" data-make="{{$truck->make}}" data-model="{{$truck->model}}" data-year="{{$truck->year}}">
                            <span class="glyphicon glyphicon-edit"></span> Edit</button>
                            <button class="delete-modal btn btn-danger" data-id="{{$truck->id}}" data-seats="{{$truck->seats}}" data-weightcapacity="{{$truck->weight_capacity}}"
                              data-gasmileage="{{$truck->gas_mileage}}" data-make="{{$truck->make}}" data-model="{{$truck->model}}" data-year="{{$truck->year}}">
                              <span class="glyphicon glyphicon-trash"></span> Delete</button>
                            </td>
                          </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </table>
                </div><!-- /.panel-body -->
              </div><!-- /.panel panel-default -->
            </div><!-- /.col-md-8 -->

            <!-- Modal form to add a truck -->
            <div id="addModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" >×</button>
                    <h4 class="modal-seats"></h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="seats">Seats:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="seat_add" autofocus>
                          <small>Min: 2, Max: 32, only text</small>
                          <p class="errorSeats text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="weightcapacity">Weight Capacity:</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="weightcapacity_add" cols="40" rows="5"></input>
                          <small>Min: 2, Max: 128, only text</small>
                          <p class="errorWeightcapacity text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="gasmileage">Gas Mileage:</label>
                        <div class="col-sm-10">
                          <input class="form-control" id="gasmileage_add" cols="40" rows="5"></input>
                          <small>Min: 2, Max: 128, only text</small>
                          <p class="errorGasmileage text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="make">Make:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="make_add" cols="40" rows="5"></textarea>
                          <small>Min: 2, Max: 128, only text</small>
                          <p class="errorMake text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="model">Model:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="model_add" cols="40" rows="5"></textarea>
                          <small>Min: 2, Max: 128, only text</small>
                          <p class="errorModel text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="year">Year:</label>
                        <div class="col-sm-10">
                          <textarea class="form-control" id="year_add" cols="40" rows="5"></textarea>
                          <small>Min: 2, Max: 128, only text</small>
                          <p class="errorYear text-center alert alert-danger hidden"></p>
                        </div>
                      </div>
                    </form>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-success add" data-dismiss="modal">
                        <span id="" class='glyphicon glyphicon-check'></span> Add
                      </button>
                      <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                      </button>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            {{-- <!-- Modal form to show a truck --> --}}
            <div id="showModal" class="modal fade" role="dialog">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-seats"></h4>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" role="form">
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="id">ID:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="id_show" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="seats">Seats:</label>
                        <div class="col-sm-10">
                          <input type="name" class="form-control" id="seats_show" disabled>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="weightcapacity">Weight Capacity:</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="weightcapacity_show" cols="40" rows="5" disabled></input>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="gasmileage">Gas Mileage:</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="gasmileage_show" cols="40" rows="5" disabled></input>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="make">Make:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="make_show" cols="40" rows="5" disabled></input>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="model">Model:</label>
                        <div class="col-sm-10">
                          <input type="text" class="form-control" id="model_show" cols="40" rows="5" disabled></textarea>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-sm-2" for="year">Year:</label>
                        <div class="col-sm-10">
                          <input type="number" class="form-control" id="year_show" cols="40" rows="5" disabled></input>
                        </div>
                      </div>
                    </form>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-warning" data-dismiss="modal">
                        <span class='glyphicon glyphicon-remove'></span> Close
                      </button>
                      <div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
                {{-- <!-- Modal form to edit a form --> --}}
                <div id="editModal" class="modal fade" role="dialog">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-seats"></h4>
                      </div>
                      <div class="modal-body">
                        <form class="form-horizontal" role="form">
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="id">ID:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="id_edit" disabled>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="seats">Seats:</label>
                            <div class="col-sm-10">
                              <input type="text" class="form-control" id="seats_edit" autofocus>
                              <p class="errorSeats text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="weightcapacity">Weight Capacity:</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="weightcapacity_edit" cols="40" rows="5"></textarea>
                              <p class="errorWeightcapacity text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="gasmileage">Gas Mileage:</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="gasmileage_edit" cols="40" rows="5"></textarea>
                              <p class="errorGasmileage text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="make">Make:</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="make_edit" cols="40" rows="5"></textarea>
                              <p class="errorMake text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="model">Model:</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="model_edit" cols="40" rows="5"></textarea>
                              <p class="errorModel text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                          <div class="form-group">
                            <label class="control-label col-sm-2" for="year">Year:</label>
                            <div class="col-sm-10">
                              <textarea class="form-control" id="year_edit" cols="40" rows="5"></textarea>
                              <p class="errorYear text-center alert alert-danger hidden"></p>
                            </div>
                          </div>
                        </form>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-primary edit" data-dismiss="modal">
                            <span class='glyphicon glyphicon-check'></span> Edit</button>
                            <button type="button" class="btn btn-warning" data-dismiss="modal">
                              <span class='glyphicon glyphicon-remove'></span> Close</button>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <!-- Modal form to delete a form -->
                    <div id="deleteModal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">×</button>
                                    <h4 class="modal-title">Delete</h4>
                                </div>
                                <div class="modal-body">
                                    <h3 class="text-center">Are you sure you want to delete the following post?</h3>
                                    <br />
                                    <form class="form-horizontal" role="form">
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="id">ID:</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="id_delete" disabled>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="seats">Seats:</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control" id="seats_delete" disabled>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="weightcapacity">Weight Capacity:</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control" id="weightcapacity_delete" disabled>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="gasmileage">Gas Mileage:</label>
                                        <div class="col-sm-10">
                                          <input type="number" class="form-control" id="gasmileage_delete" disabled>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="make">Make:</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="make_delete" disabled>
                                        </div>
                                      </div>
                                      <div class="form-group">
                                        <label class="control-label col-sm-2" for="model">Model:</label>
                                        <div class="col-sm-10">
                                          <input type="text" class="form-control" id="model_delete" disabled>
                                        </div>
                                      </div>
                                        <div class="form-group">
                                          <label class="control-label col-sm-2" for="year">Year:</label>
                                          <div class="col-sm-10">
                                            <input type="text" class="form-control" id="year_delete" disabled>
                                          </div>
                                        </div>
                                    </form>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-danger delete" data-dismiss="modal">
                                            <span id="" class='glyphicon glyphicon-trash'></span> Delete
                                        </button>
                                        <button type="button" class="btn btn-warning" data-dismiss="modal">
                                            <span class='glyphicon glyphicon-remove'></span> Close
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                          <!-- jQuery -->
                          <script src="https://code.jquery.com/jquery-2.2.4.js" integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI=" crossorigin="anonymous"></script>
                          {{-- <!-- Bootstrap JavaScript --> --}}
                          <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.0.1/js/bootstrap.min.js"></script>
                          <!-- toastr notifications -->
                          <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
                          {{-- <!-- icheck checkboxes --> --}}
                          <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
                          {{-- <!-- Delay table load until everything else is loaded --> --}}
                          <script>
                          $(window).load(function(){
                            $('#postTable').removeAttr('style');
                          })
                          </script>

                          <script>
                          $(document).ready(function(){
                            $('.published').iCheck({
                              checkboxClass: 'icheckbox_square-yellow',
                              radioClass: 'iradio_square-yellow',
                              increaseArea: '20%'
                            });
                            $('.published').on('ifClicked', function(event){
                              var id = $(this).data('id');
                              console.log(window.location.protocol+"/trucks/changeStatus");
                              $.ajax({
                                type: 'POST',
                                url:window.location.protocol+"/trucks/changeStatus",
                                data: {
                                  '_token': $('input[name=_token]').val(),
                                  'id': id
                                },
                                success: function(data) {
                                  // empty
                                },
                                error: function(data) {
                                  console.log(data);
                                $('html').html(data.responseText);
                                },
                                    });
                                });
                                $('.published').on('ifToggled', function(event) {
                                  $(this).closest('tr').toggleClass('warning');
                                });
                              });

                              </script>

                              {{-- <!-- AJAX CRUD operations --> --}}
                              <script type="text/javascript">
                              {{-- // add a new truck --}}
                              $(document).on('click', '.add-modal', function() {
                                $('.modal-seats').text('Add');
                                $('#addModal').modal('show');
                              });
                              $('.modal-footer').on('click', '.add', function() {
                                console.log("seats: ",$('#seat_add').val());
                                $.ajax({
                                  type: 'POST',
                                  url:window.location.protocol+"api/trucks",
                                  data: {
                                    '_token': $('input[name=_token]').val(),

                                    'seats': $('#seat_add').val(),
                                    'weight_capacity': $('#weightcapacity_add').val(),
                                    'gas_mileage': $('#gasmileage_add').val(),
                                    'make': $('#make_add').val(),
                                    'model': $('#model_add').val(),
                                    'year': $('#year_add').val(),
                                    'favorite': null,
                                  },
                                  success: function(data) {
                                    $('.errorSeats').addClass('hidden');
                                    $('.errorWeightcapacity').addClass('hidden');
                                    $('.errorGasmileage').addClass('hidden');
                                    $('.errorMake').addClass('hidden');
                                    $('.errorModel').addClass('hidden');
                                    $('.errorYear').addClass('hidden');

                                    if ((data.errors)) {
                                        $('#addModal').modal('show');
                                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});

                                      if (data.errors.seats) {
                                        $('.errorSeats').removeClass('hidden');
                                        $('.errorSeats').text(data.errors.seats);
                                      }
                                      if (data.errors.weightcapacity) {
                                        $('.errorWeightcapacity').removeClass('hidden');
                                        $('.errorWeightcapacity').text(data.errors.weightcapacity);
                                      }
                                      if (data.errors.gasmileage) {
                                        $('.errorGasmileage').removeClass('hidden');
                                        $('.errorGasmileage').text(data.errors.gasmileage);
                                      }
                                      if (data.errors.make) {
                                        $('.errorMake').removeClass('hidden');
                                        $('.errorMake').text(data.errors.make);
                                      }
                                      if (data.errors.model) {
                                        $('.errorModel').removeClass('hidden');
                                        $('.errorModel').text(data.errors.model);
                                      }
                                      if (data.errors.year) {
                                        $('.errorYear').removeClass('hidden');
                                        $('.errorYear').text(data.errors.year);
                                      }

                                      console.log("server error response", data);

                                    } else {
                                      console.log("server response", data);
                                      toastr.success('Successfully added Truck!', 'Success Alert', {timeOut: 5000});
                                      $('#postTable').append(
                                        "<tr class='item" + data.id + "'>"+
                                        "<td>" + data.data.id + "</td>"+
                                        "<td>" + data.data.seats + "</td>"+
                                        "<td>" + data.data.weight_capacity+ "</td>"+
                                        "<td>" + data.data.gas_mileage + "</td>"+
                                        "<td>" + data.data.make  + "</td>"+
                                        "<td>" + data.data.model   + "</td>"+
                                        "<td>" + data.data.year+ "</td>"+
                                        "<td class='text-center'><input type='checkbox' class='new_published' data-id='" + data.data.id + " '></td>"+
                                        "<td>Right now</td>"+
                                        "<td><button class='show-modal btn btn-success' data-id='" + data.data.id + "' data-seats='" + data.data.seats +
                                        "' data-weightcapacity='" + data.data.weight_capacity +
                                          "'data-gasmileage='" + data.data.gas_mileage +
                                        "' data-make='" + data.data.make + "   'data-model='" + data.data.model + "  'data-year='" + data.data.year +
                                        " '><span  class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.data.id + "' data-seats='" + data.data.seats +
                                        "' data-weightcapacity='" + data.data.weight_capacity + "'data-gasmileage='" + data.data.gas_mileage +
                                        "' data-make='" + data.data.make + " 'data-model='" + data.data.model + "   'data-year='" + data.data.year +
                                        "'><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.data.id + "' data-seats='" + data.data.seats +
                                        "' data-weightcapacity='" + data.data.weight_capacity + "'data-gasmileage='" + data.data.gas_mileage +
                                        "' data-make='" + data.data.make + "    'data-model='" + data.data.model + " 'data-year='" + data.data.year +
                                        "'><span class='glyphicon glyphicon-trash'></span> Delete</button></td>"+
                                      "</tr>"
                                    );
                                      $('.new_published').iCheck({
                                        checkboxClass: 'icheckbox_square-yellow',
                                        radioClass: 'iradio_square-yellow',
                                        increaseArea: '20%'
                                      });
                                      $('.new_published').on('ifToggled', function(event){
                                        $(this).closest('tr').toggleClass('warning');
                                      });
                                      $('.new_published').on('ifChanged', function(event){
                                        id = $(this).data('id');
                                        $.ajax({
                                          type: 'POST',
                                          url:window.location.protocol+"/trucks/changeStatus",
                                          data: {
                                            '_token': $('input[name=_token]').val(),
                                            'id': id
                                          },
                                          success: function(data) {
                                            // empty
                                          },
                                          error: function(data) {
                                            console.log(data);
                                            $('html').html(data.responseText);
                                          },
                                        });
                                      });
                                      $('.col1').each(function (index) {
                                        $(this).html(index+1);

                                      });
                                    }
                                  },




                                  error: function(data) {
                                    console.log(data.responseText);
                                    // $('html').html(data.responseText);
                                  },
                                });
                              });

                              // Show a truck
                              $(document).on('click', '.show-modal', function() {
                               $('.modal-seats ').text('Show');
                               $('#id_show').val($(this).data('id'));
                               $('#seats_show').val($(this).data('seats'));
                               $('#weightcapacity_show').val($(this).data('weightcapacity'));
                               $('#gasmileage_show').val($(this).data('gasmileage'));
                               $('#make_show').val($(this).data('make'));
                               $('#model_show').val($(this).data('model'));
                               $('#year_show').val($(this).data('year'));
                               $('#showModal').modal('show');
                             });



                              $('.modal-footer').on('click', '.show', function() {
                                console.log(window.location.protocol+"/api/trucks/"+$("#id_show").val());
                                $.ajax({
                                  type: 'PUT',
                                  url: window.location.protocol+"/api/trucks/"+$("#id_show").val(),
                                  data: {
                                    '_token': $('input[name=_token]').val(),
                                    'id': $("#id_show").val(),
                                    'seats': $('#seats_show').val(),
                                    'weightcapacity': $('#weightcapacity_show').val(),
                                    'gasmileage': $('#gasmileage_show').val(),
                                    'make': $('#make_show').val(),
                                    'model': $('#model_show').val(),
                                    'year': $('#year_show').val(),
                                  },
                                  success: function(data) {
                                    $('.errorSeats').addClass('hidden');
                                    $('.errorWeightcapacity').addClass('hidden');
                                    $('.errorGasmileage').addClass('hidden');
                                    $('.errorMake').addClass('hidden');
                                    $('.errorModel').addClass('hidden');
                                    $('.errorYear').addClass('hidden');
                                  },
                                      });
                                  });

                              // Edit a truck
                              $(document).on('click', '.edit-modal', function() {
                                $('.modal-seats').text('Edit');
                                $('#id_edit').val($(this).data('id'));

                                $('#seats_edit').val($(this).data('seats'));
                                $('#weightcapacity_edit').val($(this).data('weightcapacity'));
                                $('#gasmileage_edit').val($(this).data('gasmileage'));
                                $('#make_edit').val($(this).data('make'));
                                $('#model_edit').val($(this).data('model'));
                                $('#year_edit').val($(this).data('year'));

                                id = $('#id_edit').val();
                                $('#editModal').modal('show');
                              });

                              $('.modal-footer').on('click', '.edit', function() {
                                $.ajax({
                                  type: 'PUT',
                                  url:window.location.protocol+"/api/trucks/"+$("#id_edit").val(),
                                  data: {
                                    '_token': $('input[name=_token]').val(),
                                    'id': $("#id_edit").val(),
                                    'seats': $('#seats_edit').val(),
                                    'weight_capacity': $('#weightcapacity_edit').val(),
                                    'gas_mileage': $('#gasmileage_edit').val(),
                                    'make': $('#make_edit').val(),
                                    'model': $('#model_edit').val(),
                                    'year': $('#year_edit').val()
                                  },
                                  success: function(data) { $('.errorSeats').addClass('hidden'); $('.errorWeightcapacity').addClass('hidden'); $('.errorGasmileage').addClass('hidden'); $('.errorMake').addClass('hidden');  $('.errorModel').addClass('hidden'); $('.errorYear').addClass('hidden');

                                    if ((data.errors)) {
                                      setTimeout(function () {
                                        $('#editModal').modal('show');
                                        toastr.error('Validation error!', 'Error Alert', {timeOut: 5000});
                                      }, 500);

                                      if (data.errors.seats) {
                                        $('.errorSeats').removeClass('hidden');
                                        $('.errorSeats').text(data.errors.seats);
                                      }
                                      if (data.errors.weightcapacity) {
                                        $('.errorWeightcapacity').removeClass('hidden');
                                        $('.errorWeightcapacity').text(data.errors.weightcapacity);
                                      }
                                      if (data.errors.gasmileage) {
                                        $('.errorGasmileage').removeClass('hidden');
                                        $('.errorGasmileage').text(data.errors.gasmileage);
                                      }
                                      if (data.errors.make) {
                                        $('.errorMake').removeClass('hidden');
                                        $('.errorMake').text(data.errors.make);
                                      }
                                      if (data.errors.model) {
                                        $('.errorModel').removeClass('hidden');
                                        $('.errorModel').text(data.errors.model);
                                      }
                                      if (data.errors.year) {
                                        $('.errorYear').removeClass('hidden');
                                        $('.errorYear').text(data.errors.year);
                                      }
                                    }
                                    else {
                                      toastr.success('Successfully updated Truck!', 'Success Alert', {timeOut: 5000});
                                      $('.item' + data.data.id).replaceWith(
                                        "<tr class='item" + data.data.id + "'><td>" + data.data.id +
                                         "</td><td>"  +
                                         data.data.seats + "</td><td>" + data.data.weight_capacity + "</td><td>"
                                        + data.data.gas_mileage + "</td><td>" + data.data.make +
                                        "</td><td>" + data.data.model + "</td><td>" + data.data.year +
                                      "</td><td class='text-center'><input type='checkbox' class='edit_published' data-id='" + data.data.id + "'></td><td>Right now</td><td><button class='show-modal btn btn-success' data-id='" + data.data.id + "' data-seats='" + data.seats +
                                      " ' data-weightcapacity='" + data.data.weight_capacity + "'data-gasmileage='" + data.data.gas_mileage +
                                      "' data-make='" + data.data.make + "   'data-model='" + data.data.model +
                                      " 'data-year='" + data.data.year + "    '><span class='glyphicon glyphicon-eye-open'></span> Show</button> <button class='edit-modal btn btn-info' data-id='" + data.data.id +
                                       " ' data-seats='" + data.data.seats + " ' data-weightcapacity='" + data.data.weight_capacity +
                                        " ' data-gasmileage='" + data.data.gas_mileage + "' data-make='" + data.data.make + "' data-model='" + data.data.model +
                                        " ' data-year='" + data.data.year + "   '><span class='glyphicon glyphicon-edit'></span> Edit</button> <button class='delete-modal btn btn-danger' data-id='" + data.data.id + "' data-seats='" + data.data.seats +
                                        " ' data-weightcapacity='" + data.data.weight_capacity + "'data-gasmileage='" + data.data.gas_mileage +
                                         " ' data-make='" + data.make + "' data-model='" + data.data.model + "' data-year='" + data.data.year +
                                          " '><span class='glyphicon glyphicon-trash'></span> Delete</button></td></tr>");

                                      if (data.is_published) {
                                        $('.edit_published').prop('checked', true);
                                        $('.edit_published').closest('tr').addClass('warning');
                                      }
                                      $('.edit_published').iCheck({
                                        checkboxClass: 'icheckbox_square-yellow',
                                        radioClass: 'iradio_square-yellow',
                                        increaseArea: '20%'
                                      });
                                      $('.edit_published').on('ifToggled', function(event) {
                                        $(this).closest('tr').toggleClass('warning');
                                      });
                                      $('.edit_published').on('ifChanged', function(event){
                                        id = $(this).data('id');
                                        $.ajax({
                                          type: 'POST',
                                          url: window.location.protocol+"/trucks/changeStatus",
                                          data: {
                                            '_token': $('input[name=_token]').val(),
                                            'id': id
                                          },
                                          success: function(data) {
                                            // empty
                                          },
                                          error: function(data) {
                                            // console.log(data);
                                            $('html').html(data.responseText);
                                          },
                                        });
                                      });
                                      $('.col1').each(function (index) {
                                        $(this).html(index+1);
                                      });
                                    }
                                  }
                                });
                              });


                              // delete a truck
                              $(document).on('click', '.delete-modal', function() {
                                $('.modal-seats').text('Delete');
                                $('#id_delete').val($(this).data('id'));

                                $('#seats_delete').val($(this).data('seats'));
                                $('#weightcapacity_delete').val($(this).data('weightcapacity'));
                                $('#gasmileage_delete').val($(this).data('gasmileage'));
                                $('#make_delete').val($(this).data('make'));
                                $('#model_delete').val($(this).data('model'));
                                $('#year_delete').val($(this).data('year'));

                                $('#deleteModal').modal('show');
                                id = $('#id_delete').val();
                              });

                              $('.modal-footer').on('click', '.delete', function() {
                                $.ajax({
                                  type: 'DELETE',
                                  url:window.location.protocol+"/api/trucks/" +$('#id_delete').val(),
                                  data: {
                                    '_token': $('input[name=_token]').val(),
                                  },

                                  success: function(data) {
                                    console.log("id: ", data);
                                    toastr.success('Successfully deleted Post!', 'Success Alert', {timeOut: 5000});
                                    $('tr.item' + data.data).remove();
                                    $('.col1').each(function (index) {
                                      $(this).html(index+1);
                                    });
                                  }
                                });
                              });
                              </script>

  </body>
</html>
