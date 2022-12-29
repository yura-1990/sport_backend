<table>
    <thead>
    <tr>
        <th>ID</th>
        <th>Login</th>
        <th>PINFL</th>
        <th>Passport Series</th>
        <th>Passport Number</th>
        <th>Branch</th>
        <th>Role</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $user)
        <tr>
            <td>{{ $user->id }}</td>
            <td>{{ $user->login }}</td>
            <td>{{ $user->pasport->pnfl }}</td>
            <td>{{ $user->pasport->pasport_seria }}</td>
            <td>{{ $user->pasport->pasport_seria_code }}</td>
            <td>{{ $user->fillial->name_ru }}</td>
            <td>{{ $user->role->type }}</td>
            <td>{{ $user->created_at }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
