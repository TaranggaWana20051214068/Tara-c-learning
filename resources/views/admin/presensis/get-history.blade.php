<table class="table">
    <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($history as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->name }}</td>
                <td>{{ date('d-m-Y', strtotime($data->tgl_presensi)) }}</td>
                <td>
                    <span class="badge {{ $data->jam_in < '07:00' ? 'badge-success' : 'badge-danger' }}">
                        {{ $data->jam_in }}
                    </span>
                </td>
                <td>
                    <span class="badge badge-primary">{{ $data->jam_out }}</span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan='5'style="text-align: center">No data available to show</td>
            </tr>
        @endforelse
    </tbody>
</table>
