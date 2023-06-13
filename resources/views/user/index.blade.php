@extends('_partials.main')
@section('container')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ $title }} {!! $button->btnCreate('User') !!}</h1>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel {{ $title }}</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Role</th>
            <th>Email</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $dt)
          <tr>
            <td>{{ $dt['name'] }}</td>
            <td>{{ $dt['nama_role'] }}</td>
            <td>{{ $dt['email'] }}</td>
            <td>

              <form action="{{ url($button->formDelete('User'), ['id' => $dt->id]) }}" method="POST">
                {!! $button->btnEdit('User', $dt['id']) !!}
                <a href="#reset" class="btn btn-info btn-sm" data-toggle="modal" data-target="#reset">Reset</a>

                @csrf
                @method('DELETE')

                {!! $button->btnDelete('User') !!}
              </form>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection
@section('footlib_req')
<script src="{{ url('/assets/dist/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  $('.show_confirm').click(function(event) {
    var form = $(this).closest("form");
    var name = $(this).data("name");
    event.preventDefault();
    swal({
        title: "Apakah yakin ingin menghapus data?",
        text: "Jika dihapus, data akan hilang selamanya.",
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          form.submit();
        }
      });
  });
</script>
@endsection