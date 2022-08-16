<table class="table">

        <thead>
        <tr>
            @foreach (['name', 'email', 'password', 'remember_token'] as $title)
            <th scope="col">{{ $title }}</th>
            @endforeach
        </tr>
        </thead>


    @foreach ($accounts as $account)
        <tbody>
            <tr>
                @foreach (['name', 'email', 'password', 'remember_token'] as $key)
                <td>{{ $account[$key] }}</td>
                @endforeach
            </tr>
        </tbody>
    @endforeach

</table>
