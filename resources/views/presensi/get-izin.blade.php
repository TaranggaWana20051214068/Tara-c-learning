<table class="table table-striped">
    <thead>
        <tr>
            <th>Tanggal Izin</th>
            <th>Status</th>
            <th>Keterangan</th>
            <th>Status Persetujuan</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($datas as $data)
            <tr>
                <td>{{ date('d-m-Y', strtotime($data->tgl_izin)) }}</td>
                <td>{{ $data->status == 's' ? 'Sakit' : 'Izin' }}</td>
                <td>{{ $data->keterangan }}</td>
                <td>
                    @if ($data->status_approved == 0)
                        <span class="badge bg-warning">Pending</span>
                    @elseif($data->status_approved == 1)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-danger">Rejected</span>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-center">No data available to show</td>
            </tr>
        @endforelse
    </tbody>
</table>
