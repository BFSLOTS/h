<span>
    @if ($user->active_status != 1)
        <a class="btn btn-icon btn-danger btn-sm d-inline" href="account-status/{{ $user->id }}" id="edit-user"
            data-action="users/{{ $user->id }}/edit"><i class="ti ti-user-off"></i></a>
    @else
        <a class="btn btn-icon btn-success btn-sm d-inline" href="account-status/{{ $user->id }}"
            data-action="users/{{ $user->id }}/edit"><i class="ti ti-user-check"></i></a>
    @endif
    @can('edit-user')
        <a class="btn btn-icon btn-primary btn-sm d-inline" href="javascript:void(0);" id="edit-user"
            data-action="users/{{ $user->id }}/edit"><i class="ti ti-edit"></i></a>
    @endcan
    @can('delete-user')
    {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'id' => 'delete-form-' . $user->id,'class'=>'d-inline']) !!}
        <a href="#" class="btn btn-sm small btn-danger show_confirm" id="delete-form-{{ $user->id }}"><i
            class="ti ti-trash mr-0"></i></a>
        {!! Form::close() !!}
    @endcan
</span>
