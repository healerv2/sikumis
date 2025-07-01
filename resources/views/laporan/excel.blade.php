<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Tanggal</th>
            <th>Status Minum</th>
            <th>Catatan</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $row)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $row->user->name ?? '-' }}</td>
                <td>{{ $row->tanggal->format('d-m-Y') }}</td>
                <td>{{ $row->status_minum ? 'Sudah Minum' : 'Belum Minum' }}</td>
                <td>{{ $row->catatan }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
