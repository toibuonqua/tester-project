<table class="table table-bordered m-0">
    <tbody>
    @foreach ($item->courses as $courses)
        <tr>
            <td>{{ $courses->name }}</td>
        </tr>
    @endforeach
    @foreach ($item->accessClasses as $class)
        <tr>
            <td>{{ $class->course->name }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
