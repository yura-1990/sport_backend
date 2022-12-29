<table>
    <thead>
    <tr>
        <th>pnfl</th>
        <th>pasport_seria</th>
        <th>pasport_seria_code</th>
        <th>user_name</th>
        <th>email</th>
        <th>nationality</th>
        <th>birth_date</th>
        <th>phone</th>
        <th>user_id</th>
        <th>gender</th>
        <th>avatar</th>
        <th>all_score</th>
        <th>training_direction</th>
        <th>training_date_end</th>
        <th>training_date_start</th>
        <th>education_specialization</th>
        <th>education_name</th>
        <th>work_name</th>
        <th>work_place</th>
    </tr>
    </thead>
    <tbody>
    @foreach($datas as $data)
        <tr>
            <td>{{ $data['pnfl'] ?? null}}</td>
            <td>{{ $data['pasport_seria'] }}</td>
            <td>{{ $data['pasport_seria_code'] }}</td>
            <td>{{ $data['user_name'] }}</td>
            <td>{{ $data['nationality'] }}</td>
            <td>{{ $data['birth_date'] }}</td>
            <td>{{ $data['phone'] }}</td>
            <td>{{ $data['user_id'] }}</td>
            <td>{{ $data['gender'] }}</td>
            <td>{{ $data['avatar'] }}</td>
            <td>{{ $data['all_score'] }}</td>
            <td>{{ $data['training_direction'] }}</td>
            <td>{{ $data['training_date_end'] }}</td>
            <td>{{ $data['training_date_start'] }}</td>
            <td>{{ $data['education_specialization'] }}</td>
            <td>{{ $data['education_name'] }}</td>
            <td>{{ $data['work_name'] }}</td>
            <td>{{ $data['work_place'] }}</td>

        </tr>
    @endforeach
    </tbody>
</table>
