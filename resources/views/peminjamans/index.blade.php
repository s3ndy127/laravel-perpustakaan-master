@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    List Peminjaman Buku
                    <a href="{{ route('peminjamans.create') }}" class="btn btn-primary btn-xs pull-right">Buat Peminjaman Baru</a>
                </div>

                <div class="panel-body">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Buku</th>
                                <th>Nama Mahasiswa/Siswa</th>
                                <th>Tanggal Pinjam</th>
                                <th>Tanggal Kembali</th>
                                <th>Durasi Peminjaman</th>
                                <th>Denda</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($peminjamans as $peminjaman)
                                <tr>
                                    <th>{{ $peminjaman->book->name }}</th>
                                    <th>{{ $peminjaman->user->name }}</th>
                                    <th>{{ $peminjaman->tgl_pinjam }}</th>
                                    <th>{{ $peminjaman->tgl_kembali }}</th>
                                    <th>
                                        <?php 
                                            $datetime2 = strtotime($peminjaman->tgl_kembali) ;
                                            $datenow = strtotime($peminjaman->tgl_pinjam);
                                            $durasi = ($datenow - $datetime2) / 86400 ;
                                            $durasi2 = ($durasi) + 7;
                                        ?>
                                        @if ($durasi < -7 )
                                            Durasi Habis / {{ $durasi2 }} Hari
                                        @else
                                            <?php $durasi1 = abs($durasi) ?>
                                            {{ $durasi1 }} Hari
                                        @endif
                                    </th>
                                    <th>
                                        @if ($durasi < -12)
                                            <?php $denda = 50000 ; ?>
                                            {{ $denda }}
                                        @elseif ($durasi < -7)
                                            <?php $denda = abs($durasi2) * 10000 ; ?>
                                            {{ $denda }}
                                        @else
                                            0
                                        @endif
                                    </th>
                                    <th>
                                        {!! Form::model($peminjaman, ['route' => ['peminjamans.destroy', $peminjaman], 'method' => 'delete', 'class' => 'form-inline'] ) !!}
                                          <a href="{{ route('peminjamans.edit', $peminjaman->id)}}" class="btn btn-xs btn-success">Edit</a>
                                          {!! Form::submit('delete', ['class'=>'btn btn-xs btn-danger']) !!}
                                        {!! Form::close()!!}
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('style')
    <link rel="stylesheet" href="{{ url('css/dataTables.bootstrap.css') }}">
@stop

@section('script')
    <script src="{{ url('js/jquery.dataTables.js') }}"></script>
    <script src="{{ url('js/dataTables.bootstrap.js') }}"></script>
    <script>
        $(window).ready(function(){
            $('table').DataTable();
        });
    </script>
@stop