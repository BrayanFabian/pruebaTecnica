@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
    <div class="page-header">
      <h1>Usuarios <small>Listado de Usuarios</small></h1>
    </div>
    <div class="panel panel-primary">
      <div class="panel-heading">
        <h3 class="panel-title">Inicio</h3>
      </div>
      <div class="panel-body">
        <div class="alert alert-success">
          @if(Auth::user()->hasRole('admin'))Acceso como administrador
          @else Acceso usuario
          @endif
          -- Bienvenido, {{Auth::user()->name}}.
        </div>
        <div class="container-fluid">
          <div class="btn btn-info glyphicon glyphicon-pencil" data-toggle="modal" data-target="#myModal"> Nuevo Usuario</div>
          <hr>
          <table id="users" class="table table-hover table-condensed">
            <thead>
              <tr>
                <th>Id</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Fecha de creación</th>
                <th>Acciones</th>
              </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Nuevo Usuario</h4>
        </div>
        <div class="modal-body w-50 p-3">
          <form name="userForm" autocomplete="off">
            <input type="hidden" name="idU">
            <div class="wrap-input100">
              <input class="input100" id="name" type="text" name="name" value="{{ old('name') }}" required placeholder="@lang('all.name')" required>
              <span class="focus-input100"></span>
            </div>
            <p class="statusMsgName"></p>
            <div class="wrap-input100">
              <input class="input100" id="email" type="email" name="email" value="{{ old('email') }}" required placeholder="@lang('all.email')" >
              <span class="focus-input100"></span>
            </div>
            <p class="statusMsgEmail"></p>
            <div class="wrap-input100">
              <select class="input100" id="role"  name="role" value="{{ old('role') }}" required >
                <option value="admin">Administrador</option>
                <option value="user">Usuario</option>
              </select>
            </div>
            <div class="wrap-input100">
              <span class="btn-show-pass">
                <i class="far fa-eye"></i>
              </span>
              <input class="input100" id="password" type="password" name="password" placeholder="@lang('all.password')" required>
              <span class="focus-input100"></span>
            </div>
            <p class="statusMsgPass"></p>
          </form>
        </div>
        <div class="modal-footer">
          <button type="submit" id="new" class="btn btn-success ">Registrar</button>
          <button type="submit" id="edit" class="btn btn-alert ">Modificar</button>
          <button type="submit" id="delete" class="btn btn-danger ">Borrar</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>

    </div>
  </div>
  <!-- modal -->
</div>
@endsection

@section('scripts')

<!-- Dtatables Bootstrap -->
<script type="text/javascript" src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var  oTable = $('#users').DataTable({
    "language": {
      "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
    },
    "processing": true,
    "serverSide": true,
    "ajax": "{{ route('datatable.users') }}",
    "columns": [
      {data: 'id', name: 'id'},
      {data: 'name', name: 'name'},
      {data: 'email', name: 'email'},
      {data: 'role', name: 'role'},
      {data: 'created_at', name: 'created_at'},
      {data: 'actions', name: 'actions'},
    ]
  });
var idU= $("input[name=idU]:hidden");
  $('#edit').css('display','none');
  $('#delete').css('display','none');


  $(document).on("click", ".edit", function () {
    $('.modal-title').text('Editar Usuario');
    $('#edit').css('display','block');
    $('#new').css('display','none');
    $('#delete').css('display','none');
            var valores = new Array();
            i=0;

            $(this).parents("tr").find("td").each(function(){
            valores[i] =$(this).html();
            i++;
            });
    idU.val(valores[0]);
    $('#name').val(valores[1]);
    $('#email').val(valores[2]);
    if (valores[3]=="Administrador") {
      $('#role').val("admin");
    }else $('#role').val("user");
    $("#myModal").modal('show');
    console.log(idU.val());
    console.log(valores[0]);

    console.log(valores);

  });

  $(document).on("click", ".delete", function () {
    $('.modal-title').text('Borrar Usuario');
    $('#edit').css('display','none');
    $('#new').css('display','none');
    $('#delete').css('display','block');

            var valores = new Array();
            i=0;

            $(this).parents("tr").find("td").each(function(){
            valores[i] =$(this).html();
            i++;
            });
    idU.val(valores[0]);
    $('#name').val(valores[1]);
    $('#email').val(valores[2]);
    if (valores[3]=="Administrador") {
      $('#role').val("admin");
    }else $('#role').val("user");
    console.log(valores);
    $("#myModal").modal('show');
  });

  $('#new').click(function(){
    var name=$('#name').val();
    var email=$('#email').val();
    var role=$('#role').val();
    var password=$('#password').val();
      var route="{{route('datatable.users.new')}}";
    $.ajax({
      url:route,
      headers:{'X-CSRF-TOKEN':"{{ csrf_token() }}"},
      dataType: 'json',
      type:'POST',
      data:{name,email,role,password},
      success:function(res){
        console.log(res);
        if (res.status=="ok") {
          oTable.ajax.reload();
          $('#name').val("");
          $('#email').val("");
          $('#password').val("");
          $('#myModal').modal('hide');
          $('#new').css('display','block');
          $('#edit').css('display','none');
          $('#edit').css('display','none');
        }
      },
      error: function (data) {
        if(data.status === 422) {
          var dat=data.responseJSON.errors;
          console.log(data.responseJSON.message);
          if (dat.name) $(".statusMsgName").text(dat.name[0]);
          if (dat.email) $(".statusMsgEmail").text(dat.email[0]);
          if (dat.password) $(".statusMsgPass").text(dat.password[0]);
        } else {
          console.log("otro error");
        }
      }
    });
  });

  $('#edit').click(function(){
    var name=$('#name').val();
    var email=$('#email').val();
    var role=$('#role').val();
    var password=$('#password').val();
    var id=idU.val();
    console.log(idU);
    var newUrl = "{{ route('datatable.users.edit', ['id' => ':id']) }}";
  newUrl = newUrl.replace(':id', id);
    $.ajax({
      url:newUrl,
      headers:{'X-CSRF-TOKEN':"{{ csrf_token() }}"},
      dataType: 'json',
      type:'PUT',
      data:{name,email,role,password},
      success:function(res){
        console.log(res);
        if (res.status=="ok") {
          oTable.ajax.reload();
          $('#name').val("");
          $('#email').val("");
          $('#password').val("");
          $('#myModal').modal('hide');
          $('#new').css('display','block');
          $('#edit').css('display','none');
          $('#edit').css('display','none');
        }
      },
      error: function (data) {
        if(data.status === 422) {
          var dat=data.responseJSON.errors;
          console.log(data.responseJSON.message);
          if (dat.name) $(".statusMsgName").text(dat.name[0]);
          if (dat.email) $(".statusMsgEmail").text(dat.email[0]);
          if (dat.password) $(".statusMsgPass").text(dat.password[0]);
        } else {
          console.log("otro error");
        }
      }
    });
  });

  $('#delete').click(function(){
    var id=idU.val();
    var newUrl = "{{ route('datatable.users.delete', ['id' => ':id']) }}";
  newUrl = newUrl.replace(':id', id);
  console.log(id);
    $.ajax({
      url:newUrl,
      headers:{'X-CSRF-TOKEN':"{{ csrf_token() }}"},
      dataType: 'json',
      type:'DELETE',
      success:function(res){
        console.log(res);
        if (res.status=="ok") {
          oTable.ajax.reload();
          $('#name').val("");
          $('#email').val("");
          $('#password').val("");
          $('#myModal').modal('hide');
          $('#new').css('display','block');
          $('#edit').css('display','none');
          $('#edit').css('display','none');


        }
      },
      error: function (data) {
        if(data.status === 422) {
          var dat=data.responseJSON.errors;
          console.log(data.responseJSON.message);
        } else {
          console.log("otro error");
        }
      }
    });
  });

});
</script>
@endsection
