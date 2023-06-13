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
    <!-- /.card-header -->
    <div class="card-body">
      <div class="accordion" id="accordionExample">
        @foreach($data as $dt)
        @if($dt != 'created_by' AND $dt != 'updated_by' AND $dt != 'id')
        <div class="card">
          <div class="card-header" id="headingOne">
            <h2 class="mb-0">
              <button class="btn btn-link btn-block text-left" type="button" data-toggle="collapse" data-target="#{{$dt}}" aria-expanded="true" aria-controls="{{$dt}}">
                {{ strtoupper($dt) }}
              </button>
            </h2>
          </div>
          <div id="{{$dt}}" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
            <div class="card-body">
              @if($dt != 'logo')
                {{ $getProfil->getProfil()[$dt]->$dt }}
              @else
                <img src="{{ url('upload/image/logo/'.$getProfil->getProfil()[$dt]->$dt) }}" style="height: 100px; width: 150px;">
              @endif
            </div>
            <div class="card-footer">
              @if($button->btnEdit('Profil Web'))
                <button data-toggle="modal" data-field="{{ $dt }}" data-id="{{ $getProfil->getProfil()['id']->id }}" data-value="{{ $getProfil->getProfil()[$dt]->$dt }}" data-target="{{ $dt == 'logo' ? '#modal-logo' : '#modal-ubah'}}" class="btn btn-warning btn-sm btn-ubah">Ubah</button>
              @endif
            </div>
          </div>
          
        </div>
        @endif
        @endforeach
      </div>
    </div>
  </div>
</section>
<div class="modal fade" id="modal-ubah">
  <div class="modal-dialog">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h4 class="modal-title">Ubah <span id="nama-field"></span></h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url($button->formEdit('Profil Web')) }}" method="post">
      @csrf
      <div class="modal-body">
        <textarea class="form-control" name="value" id="ubah-value" required></textarea>
        <input type="hidden" name="id" id="ubah-id">
        <input type="hidden" name="field" id="ubah-field">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade" id="modal-logo">
  <div class="modal-dialog">
    <div class="modal-content bg-secondary">
      <div class="modal-header">
        <h4 class="modal-title">Ubah Logo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form action="{{ url($button->formEdit('Profil Web')) }}" method="post" enctype="multipart/form-data">
      @csrf
      <div class="modal-body">
        <!-- <textarea class="form-control" name="value" id="ubah-value"></textarea> -->
        <input type="file" name="value" class="form-control" required>
        <input type="hidden" name="id" value="{{ $getProfil->getProfil()['id']->id }}">
        <input type="hidden" name="field" value="logo">
      </div>
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-light" data-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-info">Simpan</button>
      </div>
      </form>
    </div>
  </div>
</div>
@endsection
@section('footlib_req')
<script src="{{ url('/assets/dist/js/sweetalert.min.js') }}"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".btn-ubah").click(function() {
      console.log('ubah');
      var id = $(this).data('id');
      var field = $(this).data('field');
      var value = $(this).data('value');
      $('#ubah-id').val(id);
      $('#ubah-field').val(field);
      $('#ubah-value').val(value);
      $('#nama-field').html(field);
    });
  });
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