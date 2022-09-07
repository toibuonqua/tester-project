<table class="table">

        <thead>
        <tr>
            @foreach (['username', 'email', 'department_id', 'role_id', 'workarea_id','created_at', 'action'] as $title)
            <th scope="col">{{ $title }}</th>
            @endforeach
        </tr>
        </thead>


    @foreach ($accounts as $account)
        <tbody>
            <tr>
                @foreach (['username', 'email', 'department_id', 'role_id', 'workarea_id','created_at', 'action'] as $key)
                <td>{{ $account->$key }}</td>
                @endforeach
            </tr>
        </tbody>
    @endforeach

</table>
