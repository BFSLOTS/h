@can('edit-submitted-form')
    <a href="{{ route('formvalues.edit', $formValue->id) }}" target="_blank" title="{{ __('Edit Survey') }}"
        class="btn btn-info mr-1 btn-sm small" data-toggle="tooltip" data-original-title="{{ __('Edit') }}"><i
            class="ti ti-edit mr-0"></i> </a>
@endcan

@can('show-submitted-form')
    <a href="{{ route('formvalues.show', $formValue->id) }}" title="{{ __('View Survey') }}"
        class="btn btn-primary  mr-1 btn-sm small" data-toggle="tooltip" data-original-title="{{ __('View') }}"><i
            class="ti ti-eye mr-0"></i> </span></a>
@endcan

@can('download-submitted-form')
    <a href="{{ route('download.form.values.pdf', $formValue->id) }}" title="{{ __('Download PDF') }}"
        class="btn btn-success  mr-1 btn-sm small" data-toggle="tooltip" data-original-title="{{ __('Download') }}"><i
            class="ti ti-file-download mr-0"></i></a>
@endcan

@can('delete-submitted-form')
    {{--  <a href="#" class="btn btn-danger delete-action btn-sm small" data-form-id="delete-form-{{ $formValue->id }}"><i
            class="ti ti-trash mr-0"></i> </a>
    {!! Form::open(['method' => 'DELETE', 'route' => ['formvalues.destroy', $formValue->id], 'id' => 'delete-form-' . $formValue->id]) !!}
    {!! Form::close() !!}  --}}
    {!! Form::open(['method' => 'DELETE', 'route' => ['formvalues.destroy', $formValue->id], 'id' => 'delete-form-' . $formValue->id,'class'=>'d-inline']) !!}
    <a href="#" class="btn btn-sm small btn-danger show_confirm" id="delete-form-{{ $formValue->id }}"><i
        class="ti ti-trash mr-0"></i></a>
{!! Form::close() !!}
@endcan
