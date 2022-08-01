<div class="accordion" id="accordionQuestion">
    {{ !($index = ($offset ?? 0) + 1) }}
    @foreach ($questions ?? [] as $question)
        <div class="accordion-item">
            <div class="accordion-header " id="heading-{{ $question->id }}">
                <div class="accordion-button" type="button" data-bs-toggle="collapse"
                    data-bs-target="#collapse-{{ $question->id }}" aria-expanded="true"
                    aria-controls="collapse-{{ $question->id }}">
                    {{ $index++ }}. {!! $question->questionInHTML() !!}
                    @isset($question->category)
                        <span class="btn btn-sm btn-warning float-end mb-1" >{{$question->category->name}}</span>
                    @endisset
                </div>
            </div>

            <div id="collapse-{{ $question->id }}" class="accordion-collapse collapse show"
                aria-labelledby="heading-{{ $question->id }}" data-bs-parent="#accordionQuestion">

                @if ($editable ?? false)
                    <div class="accordion-body">
                        @include('common.block.icon-button', [
                        'type' => 'edit',
                        'link' => route('question', ['id' => $question->id])
                        ])
                    </div>
                @endif

                <div class="tags accordion-body">
                    @foreach($question->tags ?? [] as $tag)
                        <span class="btn btn-sm btn-light disabled">{{ $tag->name }}</span>
                    @endforeach
                </div>

                @php
                    $isCheckBox = $question->answers->where('correct_answer', 'yes')->count() > 1;
                @endphp

                @foreach ($question->answers ?? [] as $answer)
                    <div class="accordion-body">
                        <div class="form-check">

                            @if ($showChosen ?? false)
                                <input class="form-check-input" type="{{ $isCheckBox ? 'checkbox' : 'radio'  }}" value=""
                                    id="answers-{{ $answer->id }}" disabled
                                    {{ isset($answerSheet[$question->id]) && in_array($answer->id, $answerSheet[$question->id]) ? 'checked' : '' }} />

                            @endif

                            <label class="form-check-labelx" for="answers-{{ $answer->id }}">
                                @if ($answer->correct_answer === 'yes' && ($showAnswer ?? false))
                                    <b>{{ $answer->text }}</b>
                                @else
                                    {{ $answer->text }}
                                @endif

                                @if ($showExplain ?? false)
                                    <br>
                                    <i>{!! $answer->explainInHtml() !!}</i>
                                @endif

                            </label>
                        </div>

                    </div>
                @endforeach
            </div>
        </div>
    @endforeach

</div>
