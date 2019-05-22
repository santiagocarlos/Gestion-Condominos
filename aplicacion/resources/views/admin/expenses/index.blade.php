@extends('adminlte::layouts.app')

@section('htmlheader_title')
	{{ trans('adminlte_lang::message.home') }}
@endsection

@section('main-content')
	<div class="container-fluid spark-screen">
    <div class="row">
    <div class="col-md-6">
      <p>Sección donde se muestran los gastos.</p>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.invoices.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Factura"><i class="fa fa-plus"></i> Agregar Factura</button>
      </a>
    </div>
    <div class="col-md-3">
      <a href="{{ route('admin.expenses.create') }}">
        <button class="btn btn-success btn-block" title="Agregar Gasto"><i class="fa fa-plus"></i> Agregar Gasto</button>
      </a>
    </div>
   </div>
   <br>
	 <div class="row">
      <div class="box box-info">
            <div class="box-header">
              <h3 class="box-title">Lista de Gastos</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>Nombre</th>
                  <th>Compañía</th>
                  <th>Descripción</th>
                  <th>Común</th>
                  <th>Torres</th>
                  <th>Apartamentos</th>
                  <th>Acciones</th>
                </tr>
                </thead>
                <tbody>
                @foreach($expenses as $expense)
                <tr>
                  <td>{{ $expense->name }}</td>
                  <td>{{ $expense->company }}</td>
                  <td>{{ $expense->description }}</td>
                  <td>
                    @if($expense->common == "0")
                    <center><span class="fa fa-check"></span></center>
                    @else
                    <center><i class="fa fa-close"></i></center>
                    @endif
                  </td>
                  <td>
                    @if($expense->towers->count() > 0)
                      {!! "<li>".$expense->towers->pluck("name")->implode("<br><li> ")."</li>" !!}
                    @else
                    <center><i class="fa fa-close"></i></center>
                    @endif
                  </td>
                  <td>
                    @if($expense->apartments->count() > 0)
                    <center><i class="fa fa-check"></i></center>

                      {{-- {!! $expense->apartments->pluck('apartment')->implode("<br> ") !!} --}}
                    @elseif($expense->towers->count() > 0)
                    <center><small><strong>incluye todos</strong></small></center>
                    @else
                    <center><strong><small>incluye todos</small></strong></center>
                    @endif
                  </td>
                  <td>
                    {!!link_to_route('admin.expenses.edit', $title = ' Editar',
                                                    $parameters = ['id' => Crypt::encrypt($expense->id)],
                                                    $attributes = ['class'=>'btn btn-warning fa fa-edit']);!!}
                    @if($expense->invoices->count() == 0)
                    <form style="display:inline" action="{{ route('admin.expenses.destroy', $expense->id) }}" method="POST">
                        {!! csrf_field() !!}
                        {!! method_field('DELETE') !!}
                      <button type="submit" id="deleteButtonExpense" class="btn btn-danger"><span class="fa fa-trash" title="Eliminar"></span> Eliminar</button>
                    </form>
                    @endif
                  </td>
                </tr>
                @endforeach
                </tbody>
                <tfoot>
                <tr>
                  <th>Nombre</th>
                  <th>Compañía</th>
                  <th>Descripción</th>
                  <th>Común</th>
                  <th>Torres</th>
                  <th>Apartamentos</th>
                  <th>Acciones</th>
                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.box-body -->
          </div>
   </div>
	</div>
@endsection
