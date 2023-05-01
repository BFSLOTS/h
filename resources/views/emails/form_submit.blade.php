@component('mail::message')
# {{ $form_value->Form->title }}
@php
$array = json_decode($form_value->json);
@endphp
<link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">
<div class="section-body">
<div class="row">
<div class="card col-md-6 mx-auto">
<div class="card-body">
@if (!empty($form_value->Form->logo))
<div class="text-center">
<img id="app-dark-logo" class="img img-responsive my-5 w-30 justify-content-center text-center"
src="{{ asset('storage/app/' . $form_value->Form->logo) }}" alt="form_logo">
</div>
@endif
<table class="table table-bordered" style="width: 100%">
@foreach ($array as $rows)
@foreach ($rows as $row_key => $row)
@if ($row->type == 'checkbox-group')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif
</td>
<td>
<ul>
@foreach ($row->values as $key => $options)
@if (isset($options->selected))
<li>
<label>{{ $options->label }}</label>
</li>
@endif
@endforeach
</ul>
</td>
</tr>
@elseif($row->type == 'file')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif
</td>
<td>
@if (isset($row->value))
@if (isset($row->multiple))
<div class="row">
@foreach ($row->value as $img)
<div class="col-6">
<img src="{{ asset('storage/app/' . $img) }}"
class="img-responsive img-thumbnail mb-2">
</div>
@endforeach
</div>
@else
<div class="row">
<div class="col-6">
<img src="{{ asset('storage/app/' . $row->value) }}"
class="img-responsive img-thumbnail mb-2">
</div>
</div>
@endif
@endif
</td>
</tr>
@elseif($row->type == 'header')
<tr>
<td colspan="2">
<{{ $row->subtype }}>{{ $row->label }}</{{ $row->subtype }}>
</td>
</tr>
@elseif($row->type == 'paragraph')
<tr>
<td colspan="2">
<{{ $row->subtype }}>{{ $row->label }}</{{ $row->subtype }}>
</td>
</tr>
@elseif($row->type == 'radio-group')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>
@foreach ($row->values as $key => $options)
@if (isset($options->selected))
{{ $options->label }}
@endif
@endforeach
</td>
</tr>
@elseif($row->type == 'select')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif</td>
<td>
@foreach ($row->values as $options)
@if (isset($options->selected))
{{ $options->label }}
@endif
@endforeach
</td>
</tr>
@elseif($row->type == 'autocomplete')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>
@foreach ($row->values as $options)
@if (isset($options->selected))
{{ $options->label }}
@endif
@endforeach
</td>
</tr>
@elseif($row->type == 'text')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>{{ isset($row->value) ? $row->value : '' }}</td>
</tr>
@elseif($row->type == 'date')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>{{ isset($row->value) ? date('d-m-Y', strtotime($row->value)) : '' }}</td>
</tr>
@elseif($row->type == 'textarea')
<tr>
<td>{{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>{{ isset($row->value) ? $row->value : '' }}</td>
</tr>
@elseif($row->type == 'starRating')
<tr>
@php
$attr = ['class' => 'form-control'];
if ($row->required) {
$attr['required'] = 'required';
}
$value = isset($row->value) ? $row->value : 0;
$no_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
@endphp
<td> {{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif </td>
<td>
<div id="{{ $row->name }}" class="starRating"
data-value="{{ $value }}" data-no_of_star="{{ $no_of_star }}">
</div>
@for ($x = 0; $x < $no_of_star; $x++)
@if (floor($value) - $x >= 1)
<img class="email_star" src="{{ asset('assets/images/star.png') }}"
width="25px">
@elseif( $value-$x > 0 )
<img class="email_star"
src="{{ asset('assets/images/half-star.png') }}" width="25px">
@else
<img class="email_star"
src="{{ asset('assets/images/black-star.png') }}" width="25px">
@endif
@endfor
<input type="hidden" name="{{ $row->name }}" value="{{ $value }}">
</td>
</tr>
@endif
@endforeach
@endforeach
</table>
</div>
</div>
</div>
</div>
Thanks,<br>
{{ config('app.name') }}
@endcomponent
