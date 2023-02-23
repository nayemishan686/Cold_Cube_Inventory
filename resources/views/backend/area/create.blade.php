@extends('backend.layout.main')
@section('content')
@if($errors->has('name'))
<div class="alert alert-danger alert-dismissible text-center">
    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ $errors->first('name') }}</div>
@endif
@if(session()->has('message'))
  <div class="alert alert-success alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('message') }}</div>
@endif
@if(session()->has('not_permitted'))
  <div class="alert alert-danger alert-dismissible text-center"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>{{ session()->get('not_permitted') }}</div>
@endif

<section>
    <div class="container-fluid">
        <a href="#" data-toggle="modal" data-target="#createModal" class="btn btn-info"><i class="dripicons-plus"></i> {{trans('file.Add Area')}}</a>
    </div>
    <div class="table-responsive">
        <table id="area-table" class="table">
            <thead>
                <tr>
                    <th class="not-exported"></th>
                    <th>{{trans('file.Area')}}</th>
                    <th>{{trans('file.Phone Number')}}</th>
                    <th>{{trans('file.Address')}}</th>
                    <th>{{trans('file.Number of Dealer')}}</th>
                    <th>{{trans('file.Number of Customer')}}</th>
                    <th class="not-exported">{{trans('file.action')}}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lims_area_all as $key=>$area)
                <?php
                    // $number_of_product = App\Product_Warehouse::
                    // join('products', 'product_warehouse.product_id', '=', 'products.id')
                    // ->where([ ['product_warehouse.area_id', $warehouse->id],
                    //           ['products.is_active', true]
                    // ])->count();

                    // $stock_qty = App\Product_Warehouse::
                    // join('products', 'product_warehouse.product_id', '=', 'products.id')
                    // ->where([ ['product_warehouse.area_id', $warehouse->id],
                    //           ['products.is_active', true]
                    // ])->sum('product_warehouse.qty');
                ?>
                <tr data-id="{{$area->id}}">
                    <td>{{$key}}</td>
                    <td>{{ $area->name }}</td>
                    <td>{{ $area->phone}}</td>
                    <td>{{ $area->address}}</td>
                    <td>0</td>
                    <td>0</td>
                    <td>
                        <div class="btn-group">
                            <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">{{trans('file.action')}}
                                <span class="caret"></span>
                                <span class="sr-only">Toggle Dropdown</span>
                            </button>
                            <ul class="dropdown-menu edit-options dropdown-menu-right dropdown-default" user="menu">
                                <li>
                                	<button type="button" data-id="{{$area->id}}" class="open-EditAreaDialog btn btn-link" data-toggle="modal" data-target="#editModal"><i class="dripicons-document-edit"></i> {{trans('file.edit')}}
                                </button>
                                </li>
                                <li class="divider"></li>
                                {{ Form::open(['route' => ['area.destroy', $area->id], 'method' => 'DELETE'] ) }}
                                <li>
                                    <button type="submit" class="btn btn-link" onclick="return confirmDelete()"><i class="dripicons-trash"></i> {{trans('file.delete')}}</button>
                                </li>
                                {{ Form::close() }}
                            </ul>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
    	{!! Form::open(['route' => 'area.store', 'method' => 'post']) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Add Area')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
          <div class="form-group">
            <label>{{trans('file.name')}} *</label>
            <input type="text" placeholder="Type Area Name..." name="name" required="required" class="form-control">
          </div>
          <div class="form-group">
            <label>{{trans('file.Phone Number')}}</label>
            <input type="text" name="phone" class="form-control">
          </div>
          <div class="form-group">
            <label>{{trans('file.Address')}} *</label>
            <textarea required class="form-control" rows="3" name="address"></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
          </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<div id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
    	{!! Form::open(['route' => ['area.update',1], 'method' => 'put']) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title"> {{trans('file.Update Area')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
        <p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
          <div class="form-group">
          	<input type="hidden" name="area_id">
            <label>{{trans('file.name')}} *</label>
            <input type="text" placeholder="Type Area Name..." name="name" required="required" class="form-control">
          </div>
          <div class="form-group">
            <label>{{trans('file.Phone Number')}} *</label>
            <input type="text" name="phone" class="form-control" required>
          </div>
          <div class="form-group">
            <label>{{trans('file.Address')}} *</label>
            <textarea class="form-control" rows="3" name="address" required></textarea>
          </div>
          <div class="form-group">
            <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
          </div>
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>

<div id="importWarehouse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" class="modal fade text-left">
  <div role="document" class="modal-dialog">
    <div class="modal-content">
    	{!! Form::open(['route' => 'warehouse.import', 'method' => 'post', 'files' => true]) !!}
      <div class="modal-header">
        <h5 id="exampleModalLabel" class="modal-title">{{trans('file.Import Warehouse')}}</h5>
        <button type="button" data-dismiss="modal" aria-label="Close" class="close"><span aria-hidden="true"><i class="dripicons-cross"></i></span></button>
      </div>
      <div class="modal-body">
  		<p class="italic"><small>{{trans('file.The field labels marked with * are required input fields')}}.</small></p>
         <p>{{trans('file.The correct column order is')}} (name*, phone, email, address*) {{trans('file.and you must follow this')}}.</p>
        <div class="row">
              <div class="col-md-6">
                  <div class="form-group">
                      <label>{{trans('file.Upload CSV File')}} *</label>
                      {{Form::file('file', array('class' => 'form-control','required'))}}
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="form-group">
                      <label> {{trans('file.Sample File')}}</label>
                      <a href="sample_file/sample_warehouse.csv" class="btn btn-info btn-block btn-md"><i class="dripicons-download"></i>  {{trans('file.Download')}}</a>
                  </div>
              </div>
        </div>
        <input type="submit" value="{{trans('file.submit')}}" class="btn btn-primary">
      </div>
      {{ Form::close() }}
    </div>
  </div>
</div>


@endsection

@push('scripts')
<script type="text/javascript">

    $("ul#setting").siblings('a').attr('aria-expanded','true');
    $("ul#setting").addClass("show");
    $("ul#setting #area-menu").addClass("active");

    var area_id = [];
    var user_verified = <?php echo json_encode(env('USER_VERIFIED')) ?>;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

  function confirmDelete() {
      if (confirm("Are you sure want to delete?")) {
          return true;
      }
      return false;
  }

	$(document).ready(function() {

	    $(document).on('click', '.open-EditAreaDialog', function() {
	        var url = "area/"
	        var id = $(this).data('id').toString();
	        url = url.concat(id).concat("/edit");

	        $.get(url, function(data) {
	            $("#editModal input[name='name']").val(data['name']);
	            $("#editModal input[name='phone']").val(data['phone']);
	            $("#editModal textarea[name='address']").val(data['address']);
	            $("#editModal input[name='area_id']").val(data['id']);

	        });
	    });
  });

  $('#area-table').DataTable( {
        "order": [],
        'language': {
            'lengthMenu': '_MENU_ {{trans("file.records per page")}}',
             "info":      '<small>{{trans("file.Showing")}} _START_ - _END_ (_TOTAL_)</small>',
            "search":  '{{trans("file.Search")}}',
            'paginate': {
                    'previous': '<i class="dripicons-chevron-left"></i>',
                    'next': '<i class="dripicons-chevron-right"></i>'
            }
        },
        'columnDefs': [
            {
                "orderable": false,
                'targets': 0,
            },
            {
                'render': function(data, type, row, meta){
                    if(type === 'display'){
                        data = '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>';
                    }

                   return data;
                },
                'checkboxes': {
                   'selectRow': true,
                   'selectAllRender': '<div class="checkbox"><input type="checkbox" class="dt-checkboxes"><label></label></div>'
                },
                'targets': [0]
            }
        ],
        'select': { style: 'multi',  selector: 'td:first-child'},
        'lengthMenu': [[10, 25, 50, -1], [10, 25, 50, "All"]],
        dom: '<"row"lfB>rtip',
        buttons: [
            {
                extend: 'pdf',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'excel',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'csv',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                extend: 'print',
                exportOptions: {
                    columns: ':visible:Not(.not-exported)',
                    rows: ':visible'
                },
            },
            {
                text: '<i title="delete" class="dripicons-cross"></i>',
                className: 'buttons-delete',
                action: function ( e, dt, node, config ) {
                    if(user_verified == '1') {
                        area_id.length = 0;
                        $(':checkbox:checked').each(function(i){
                            if(i){
                                area_id[i-1] = $(this).closest('tr').data('id');
                            }
                        });
                        if(area_id.length && confirm("Are you sure want to delete?")) {
                            $.ajax({
                                type:'POST',
                                url:'area/deletebyselection',
                                data:{
                                    areaIdArray: area_id
                                },
                                success:function(data){
                                    alert(data);
                                }
                            });
                            dt.rows({ page: 'current', selected: true }).remove().draw(false);
                        }
                        else if(!area_id.length)
                            alert('No area is selected!');
                    }
                    else
                        alert('This feature is disable for demo!');
                }
            },
            {
                extend: 'colvis',
                columns: ':gt(0)'
            },
        ],
    } );

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$( "#select_all" ).on( "change", function() {
    if ($(this).is(':checked')) {
        $("tbody input[type='checkbox']").prop('checked', true);
    }
    else {
        $("tbody input[type='checkbox']").prop('checked', false);
    }
});

$("#export").on("click", function(e){
    e.preventDefault();
    var warehouse = [];
    $(':checkbox:checked').each(function(i){
      warehouse[i] = $(this).val();
    });
    $.ajax({
       type:'POST',
       url:'/exportwarehouse',
       data:{

            warehouseArray: warehouse
        },
       success:function(data){
        alert('Exported to CSV file successfully! Click Ok to download file');
        window.location.href = data;
       }
    });
});
</script>
@endpush
