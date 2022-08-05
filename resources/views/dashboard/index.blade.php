@extends('layouts.master', ['title' => 'Dashboard'])

@section('content')

@role('super-admin')
@include('dashboard._super-admin')
@endrole


@role('dpc')
@include('dpc.dashboard')
@endrole
@role('dpp')
@include('dpp.dashboard')
@endrole
@role('dpd')
@include('dpd.dashboard')
@endrole


@stop


@section('footer')
<link rel=" stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag==" crossorigin="anonymous" referrerpolicy="no-referrer" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js" integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
    $(document).ready(function() {

        $('.stts').on('click', function(e) {
            e.preventDefault();
            var form = this;
            Swal.fire({
                title: 'Ubah status pasien ?',
                text: "Apakah anda yakin ubah status pasien?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.isConfirmed) {
                    return form.submit();
                }
            })
        });
    })
</script>

@if(session('success'))
<script>
    iziToast.success({
        title: 'Success',
        position: 'topRight',
        message: "{{ session('success') }}",
    });
</script>
@endif
@stop
