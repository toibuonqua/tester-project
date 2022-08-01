<div class="card my-3">
    <header class="card-header">{{ __('title.knowledge') }}</header>
    <main class="card-body">

        @foreach($tagResults as $tag => $tagResult)
            @php
                $correctPercent = round(( $tagResult['correct'] /  ($tagResult['correct'] + $tagResult['incorrect'])  )* 100);
                $wrongPercent = 100 - $correctPercent;
            @endphp
                <label>{{ $tag }} ({{ $tagResult['correct'] + $tagResult['incorrect'] }} Questions)</label>
                <div class="progress mb-3">
                    <div class="progress-bar bg-success bg-gradient" role="progressbar" style="width: {{ $correctPercent }}%" aria-valuenow="{{ $correctPercent }}" aria-valuemin="0" aria-valuemax="100">{{ $correctPercent }}%</div>
                    <div class="progress-bar  bg-danger bg-gradient" role="progressbar" style="width: {{ $wrongPercent }}%" aria-valuenow="{{ $wrongPercent }}" aria-valuemin="0" aria-valuemax="100">{{ $wrongPercent }}%</div>
                </div>
        @endforeach


    </main>
</div>
