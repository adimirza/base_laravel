@extends('_partials.main')
@section('container')
<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>{{ $title }}</h1>
      </div>
    </div>
  </div>
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Tabel User API</h3>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
      <table id="example2" class="table table-bordered table-hover">
        <thead>
          <tr>
            <th>Nama</th>
            <th>Email</th>
          </tr>
        </thead>
        <tbody>
          @foreach($data as $dt)
          <tr>
            <td>{{ $dt['name'] }}</td>
            <td>{{ $dt['email'] }}</td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</section>
@endsection