@extends('layouts.dashboard')
@section('title', 'Admin | Edit Jemaat Monding')
@section('content')
  <div class="row">
    <div class="col-12">
      <div class="card shadow">
        <div class="card-header">
          <h6 class="fw-bold">Edit Data Jemaat Monding</h6>
        </div>
        <div class="card-body">
          <form action="{{ route('monding.update', $monding->id) }}" method="POST">
            @csrf
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="sektor_id">Sektor</label>
                <select name="sector_id" id="sector_id" class="form-control @error('sector_id') is-invalid @enderror">
                  <option>--Pilih Sektor Gereja--</option>
                  @foreach ($sectors as $sector)
                    @if ($sector->id == $monding->sector_id)
                      <option value="{{ $sector->id }}" selected>{{ $sector->nama }}</option>  
                    @else
                      <option value="{{ $sector->id }}">{{ $sector->nama }}</option>
                    @endif
                  @endforeach
                </select>
                @error('sector_id')
                  <div class="alert alert-danger mt-2 p-2">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="family_id">Keluarga</label>
                <select name="family_id" id="family_id" class="form-control @error('family_id') is-invalid @enderror">
                  <option>--Pilih Keluarga--</option>
                  @foreach ($families as $family)
                    @if ($monding->family_id == $family->id)
                      <option value="{{ $family->id }}" selected>{{ $family->keluarga }}</option>
                    @else
                      <option value="{{ $family->id }}">{{ $family->keluarga }}</option>
                    @endif
                  @endforeach
                </select>
                @error('family_id')
                  <div class="alert alert-danger mt-2 p-2 mb-2">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row">
              <div class="form-group col-md-6">
                <label for="family_member_id">Anggota Jemaat</label>
                <select name="family_member_id" id="family_member_id" class="form-control @error('family_member_id') is-invalid @enderror">
                  <option>--Pilih Anggota Jemaat--</option>
                  @foreach ($family_members as $fm)
                    @if ($monding->family_member_id == $fm->id)
                      <option value="{{ $fm->id }}" selected>{{ $fm->nama }}</option>
                    @else
                      <option value="{{ $fm->id }}">{{ $fm->nama }}</option>
                    @endif
                  @endforeach
                </select>
                @error('family_member_id')
                  <div class="alert alert-danger mt-2 p-2 mb-2">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group col-md-6">
                <label for="monding">Monding</label>
                <input type="text" name="monding" value="{{ $mondingStatus }}" id="monding" class="form-control @error('monding') is-invalid @enderror" readonly>
                @error('monding')
                    <div class="alert alert-danger mt-2 mb-2 p-2">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="form-row mb-3">
              <div class="form-group col-md-6">
                <label for="tanggal">Tanggal</label>
                <input type="date" name="tanggal" value="{{ $monding->tanggal }}" id="tanggal" class="form-control @error('tanggal') is-invalid @enderror">
                @error('tanggal')
                  <div class="alert alert-danger mt-2 p-2 mb-2">{{ $message }}</div>
                @enderror
              </div>
              <div class="col-md-6">
                <label for="keterangan" class="form-label">Keterangan</label>
                <textarea name="keterangan" id="keterangan" cols="30" rows="5" class="form-control @error('keterangan') is-invalid @enderror">{{ $monding->keterangan }}</textarea>
                @error('keterangan')
                    <div class="alert alert-danger mt-2 mb-2 p-2">{{ $message }}</div>
                @enderror
              </div>
            </div>
            <div class="d-flex justify-content-end">
              <button type="submit" class="btn btn-primary mr-3">Edit Jemaat Monding</button>
              <a href="{{ route('monding.index') }}" class="btn btn-warning">Kembali</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  @push('scripts')
  {{-- Axios --}}
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script>
    $(function() {
      $('#sector_id').on('change', function() {
        axios.post('{{ route('family') }}', {id: $(this).val()})
        .then(function(response) {
          $('#family_id').empty();
          $('#family_id').append(new Option('--Pilih Keluarga--'));
          $.each(response.data, function(id, keluarga) {
              $('#family_id').append(new Option(keluarga, id));
          });
        });
      });
    });
    $(document).ready(function() {
    $('#family_id').on('change', function() {
       var categoryID = $(this).val();
       if(categoryID) {
           $.ajax({
               url: '/admin/getFamilyMember/'+categoryID,
               type: "GET",
               data : {"_token":"{{ csrf_token() }}"},
               dataType: "json",
               success:function(data)
               {
                 if(data){
                    $('#family_member_id').empty();
                    $('#family_member_id').append('<option hidden>--Pilih Anggota Jemaat--</option>'); 
                    $.each(data, function(key, family_member_id){
                        $('select[name="family_member_id"]').append('<option value="'+ family_member_id.id +'">' + family_member_id.nama+ '</option>');
                    });
                }else{
                    $('#family_member_id').empty();
                }
             }
           });
       }else{
         $('#family_member_id').empty();
       }
    });
    });
  </script>
    <script>
      function handleStatus() {
        let statusMonding = document.getElementById('monding').value
        if(statusMonding == '--Pilih Status Monding--' || statusMonding == 'Belum Monding') {
          document.getElementById('tgl').setAttribute('disabled', 'true');
        } else {
          document.getElementById('tgl').removeAttribute('disabled');
        }
      }
    </script>
  @endpush
@endsection