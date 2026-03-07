@extends('layouts.guest', [
    'title' => 'Тестирование на 3 ступень'
])

@section('content')
<div class="container py-5" style="max-width:900px" id="app">
    @isset($completed)
    <div class="card shadow-lg p-5 text-success text-center">
        <h2>🎉 Вы уже успешно прошли тестирование!</h2>
        <p>Переход на <strong>3-ю ступень</strong> уже доступен для вас.</p>
    </div>
    @endisset
    @isset($questions) 
    <h1 class="mb-4 text-center">Тестирование на 3 ступень</h1>
    <form action="/max/complete-test" id="testForm">
        @csrf

        <input type="hidden" name="auth_id" id="auth_id" value="{{ $auth_id }}">

        @foreach($questions as $index => $question)
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="mb-3">{{ $index + 1 }}. {{ $question['title'] }}</h5>

                    @foreach($question['answers'] as $answerIndex => $answer)
                        <div class="form-check mb-2">
                            <input type="radio"
                                   class="form-check-input"
                                   name="answers[{{ $index }}]"
                                   value="{{ $answerIndex }}"
                                   required>
                            <label class="form-check-label">{{ $answer }}</label>
                        </div>
                    @endforeach
                </div>
            </div>
        @endforeach

        <button type="submit" class="btn btn-dark btn-lg w-100 mb-5">Отправить ответы</button>
    </form>
    @endisset

    @isset($next_try)
        <div id="testResult" class="text-center">
            <div class="card shadow-lg p-5 text-danger">
                <h2>❌ Тест не пройден</h2>
                <p class="text-muted">Повторная попытка будет доступна {{ $next_try }}</p>
            </div>
        </div>
        @else
        <div id="testResult" class="text-center"></div>
    @endisset

</div>

<script>
document.getElementById('testForm').addEventListener('submit', async function(e) {
    e.preventDefault();

    const form = e.target;
    const formData = new FormData(form);

    const response = await fetch(form.action, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': formData.get('_token'),
            'Accept': 'application/json'
        },
        body: formData
    });

    const resultDiv = document.getElementById('testResult');

    if (!response.ok) {
        resultDiv.innerHTML = '<p class="text-danger">Произошла ошибка, попробуйте ещё раз.</p>';
        return;
    }

    const data = await response.json();

    // data: { passed: true/false, score: X, total: Y }
    if (data.passed) {
        resultDiv.innerHTML = `
            <div class="card shadow-lg p-5 text-success">
                <h2>🎉 Тест успешно пройден!</h2>
                <p>Вы набрали <strong>${data.score} / ${data.total}</strong> баллов.</p>
                <p>Теперь вам доступен переход на <strong>3-ю ступень</strong>.</p>
            </div>
        `;
    } else {
        resultDiv.innerHTML = `
            <div class="card shadow-lg p-5 text-danger">
                <h2>❌ Тест не пройден</h2>
                <p>Ваш результат: <strong>${data.score} / ${data.total}</strong></p>
                <p class="text-muted">Повторная попытка будет доступна через 30 дней.</p>
            </div>
        `;
    }

    form.style.display = 'none';
});
</script>
@endsection