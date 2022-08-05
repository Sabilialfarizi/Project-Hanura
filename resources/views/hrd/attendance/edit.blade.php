@extends('layouts.master',['title' => 'Attendance'])

@section('content')
<div class="row">
    <div class="col-sm-12">
        <h4 class="page-title">Attendance Show</h4>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        {{ $user->name }}
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        {{--<table class="table table-striped">
            <tr class="text-center">
                <th>No</th>
                <th>Shift 1</th>
                <th>Shift 2</th>
                <th>Libur</th>
            </tr>
            @for($i = 1;$i <= 31; $i++)
            <tr class="text-center">
                <td>{{ $i }}</td>
                <td><input @if(Carbon\Carbon::parse($holiday[$i]->holiday_date ?? 3)->format('d') == $i) disabled @endif type="checkbox"name="" id=""></td>
                <td><input @if(Carbon\Carbon::parse($holiday[$i]->holiday_date ?? 3)->format('d') == $i) disabled @endif type="checkbox"name="" id=""></td>
                <td><input @if(Carbon\Carbon::parse($holiday[$i]->holiday_date ?? 3)->format('d') == $i) disabled @endif type="checkbox"name="" id=""></td>
            </tr>
            @endfor
        </table>
    </div>
</div>
<script>

</script>
@stop
