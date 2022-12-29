
<table>
    <thead>
    <tr>
        <th>pnfl</th>
        <th>pasport_seria</th>
        <th>pasport_seria_code</th>
        <th>user_name</th>
        <th>gender</th>
        <th>email</th>
        <th>nationality</th>
        <th>birth_date</th>
        <th>phone</th>
        <th>all_score</th>
        <th>training_direction</th>
        <th>training_date_end</th>
        <th>training_date_start</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td>{{ $data['pnfl'] }}</td>
            <td>{{ $data['pasport_seria']  }}</td>
            <td>{{ $data['pasport_seria_code'] }}</td>
            <td>{{ $data['user_name'] }}</td>
            <td>{{ $data['gender'] }}</td>
            <td>{{ $data['email'] }}</td>
            <td>{{ $data['nationality'] }}</td>
            <td>{{ $data['birth_date'] }}</td>
            <td>{{ $data['phone'] }}</td>
            <td>{{ $data['all_score'] }}</td>
            <td>{{ $data['training_direction'] }}</td>
            <td>{{ $data['training_date_end'] }}</td>
            <td>{{ $data['training_date_start'] }}</td>
            <td>{{ $data['user_id'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
