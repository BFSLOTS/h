@can('edit-module')
<a class="btn  btn-info edit_module" href="{{ route('module.edit', $module->id) }}" id="edit-module" data-action="module/{{$module->id}}/edit"><i class="ti ti-edit"></i></a>
@endcan
@can('delete-module')
{!! Form::open(['method' => 'DELETE', 'route' => ['module.destroy', $module->id], 'id' => 'delete-form-' . $module->id],'class'=>'d-inline') !!}
<a href="#" class="btn btn-sm small btn-danger show_confirm" id="delete-form-{{ $module->id }}"><i
    class="ti ti-trash mr-0"></i></a>
{!! Form::close() !!}
@endcan


