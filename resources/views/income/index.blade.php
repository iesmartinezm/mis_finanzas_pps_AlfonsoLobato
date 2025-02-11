<x-layouts.main :title="$title">
    <p>El body de incomes:</p>
    <ul>
    @foreach ($incomes as $income)
        <li>{{$income[0]}}</li>
    @endforeach
    </ul>
</x-layouts.main>
