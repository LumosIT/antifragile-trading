<?php

namespace App\Services\TelegramMailing;

/**
 * Сервис содержит части Telegram-бота, связанные с тестированием на 3 ступень
 */

use App\Consts\TariffModes;
use App\Models\User;
use App\Services\OptionsService;
use App\Services\TelegramService;
use App\Services\TextsService;
use TelegramBot\Api\Types\Inline\InlineKeyboardMarkup;
use TelegramBot\Api\Types\Message;

class TelegramUpgradeService
{

    protected $telegramService;
    protected $textsService;
    protected $optionsService;

    protected $questions = [
        ['title' => 'Что является основной задачей трейдера?', 'answers' => ['Предсказать цену на 100%', 'Сделать как можно больше сделок', 'Найти ситуации, где есть статистическое преимущество', 'Купить дешево, продать дорого, как получится'], 'result' => 2],
        ['title' => 'Какой из ордеров позволяет вам точно задать цену входа и избежать проскальзывания?', 'answers' => ['Рыночный', 'Лимитный', 'Условный', 'Маржинальный'], 'result' => 1],
        ['title' => 'Что из ниже перечисленного является правдой про маржинальную торговлю?', 'answers' => ['Это способ торговать без собственных денег', 'Это бесплатный способ увеличить прибыль', 'Это торговля с заемными средствами под процент', 'Это доступно только институциональным инвесторам'], 'result' => 2],
        ['title' => 'В чем суть короткой (short) позиции?', 'answers' => ['Купить дешево, продать дорого', 'Купить актив на заемные деньги', 'Продать актив, которого у вас нет, чтобы выкупить его дешевле', 'Открыть сделку на короткое время'], 'result' => 2],
        ['title' => 'Что происходит, если трейдер берет третье плечо, а актив падает на 1%?', 'answers' => ['Потери будут 1%', 'Потери будут 3%', 'Плечо защитит от убытков', 'Брокер компенсирует просадку'], 'result' => 1],
        ['title' => 'Можно ли стабильно зарабатывать в трейдинге без статистического преимущества?', 'answers' => ['Можно, если соблюдать дисциплину', 'Нет, это казино', 'Да, если торговать по тренду и не фиксировать убытки', 'Можно, если быть терпеливым'], 'result' => 1],
        ['title' => 'Что важнее при входе в сделку?', 'answers' => ['Чтобы быстро “запрыгнуть”', 'Чтобы не упустить движение', 'Контроль входной цены и расчет риска', 'Слухи в телеграм-каналах'], 'result' => 2],
        ['title' => 'Ваша торговая стратегия имеет только 35% прибыльных сделок. Что это означает?', 'answers' => ['Стратегия убыточна', 'Такая стратегия может быть прибыльной, все зависит от соотношения риск/прибыль', 'Такую стратегию нельзя использовать'], 'result' => 1],
        ['title' => 'Какой из подходов к оценке стратегии наиболее адекватный?', 'answers' => ['Сколько в среднем зарабатывается на прибыльной сделке и сколько теряется на убыточной', 'Сколько прибыльных сделок из 10', 'Сколько сигналов в день', 'Сколько денег можно разогнать за месяц'], 'result' => 0],
        ['title' => 'Что вы почувствуете, если стратегия покажет 5 убыточных сделок подряд?', 'answers' => ['Стратегия не работает', 'Паника и желание закрыть все позиции', 'Это допустимо, если соблюдены риск и статистика', 'Срочно менять стратегию'], 'result' => 2],
        ['title' => 'Что происходит, если использовать рыночный ордер во время волатильности?', 'answers' => ['Сделка точно пройдет по нужной цене', 'Вы можете потерять контроль над риском', 'Вы получите более выгодную цену', 'Ничего не меняется'], 'result' => 1],
        ['title' => 'Каким образом изменятся результаты торговли, если входить в сделку всегда на 1% выше автора стратегии?', 'answers' => ['Результат будет хуже автора, но все равно положительным', 'Вы начнете торговать в убыток', 'Результаты станут лучше, из-за более надежного входа', 'Ничего не изменится'], 'result' => 1],
        ['title' => 'Если в прибыльных позициях закрывать сделку сильно раньше, чем достигается цель, то ваш результат на длительной дистанции станет:', 'answers' => ['Положительным', 'Отрицательным', 'Ничего не изменится'], 'result' => 1],
        ['title' => 'Выходит новость и цена на акцию резко улетает вверх. Является ли это поводом спекулятивно купить ее?', 'answers' => ['Да, стоит попытаться заработать на краткосрочном росте', 'Нет, так как отсутствует торговый сетап'], 'result' => 1],
        ['title' => 'На какую доходность от спекуляций вы рассчитываете?', 'answers' => ['В идеале делать 1% в день', 'Стабильные 5-6% в месяц меня бы устроили', '100%+ годовых', 'Я понимаю, что доходность не гарантирована и результат во многом будет зависеть от рыночной ситуации'], 'result' => 3],
        ['title' => 'Если на протяжении нескольких месяцев у вас будет отрицательный результат в спекуляциях или будут отсутствовать сами сделки из-за неподходящей рыночной ситуации, то вы:', 'answers' => ['Буду пытаться изменить стратегию торговли', 'Буду сильно разочарован и перестану торговать', 'Отнесусь к этому спокойно, если понимаю причину такого результата, и продолжу торговать дальше'], 'result' => 2],
        ['title' => 'Являются ли нормой периоды убыточных сделок в спекуляциях?', 'answers' => ['Да', 'Нет'], 'result' => 0],
        ['title' => 'Что является первостепенным при открытии спекулятивной сделки?', 'answers' => ['Ожидания на рынке', 'Потенциал по прибыли', 'Наличие торгового сетапа и низкий риск', 'Наличие надежного прогноза и уверенность'], 'result' => 2],
        ['title' => 'Влияет ли размер капитала на возможность зайти или выйти из актива?', 'answers' => ['Влияет', 'Нет'], 'result' => 0],
        ['title' => 'Если одновременно большое количество людей попробует продать актив, смогут ли они это сделать по одной цене?', 'answers' => ['Смогут', 'Нет, основная масса людей продаст дешевле', 'Нет, основная масса людей продаст дороже'], 'result' => 1]
    ];

    public function __construct(
        TelegramService $telegramService,
        TextsService $textsService,
        OptionsService $optionsService
    ){
        $this->telegramService = $telegramService;
        $this->textsService = $textsService;
        $this->optionsService = $optionsService;
    }

    public function validateScore(int $score) : bool
    {
        return $score >= 15;
    }

    public function getQuestion(int $question_index) : ?array
    {

        if($this->hasQuestion($question_index)) {
            return $this->questions[$question_index];
        }

        throw new \Exception('Question not found');

    }

    public function hasQuestion(int $question_index) : bool
    {
        return array_key_exists($question_index, $this->questions);
    }

    public function getQuestionsCount() : int
    {
        return count($this->questions);
    }

    public function sendInvite(User $user) : Message
    {
        return $this->telegramService->send(
            $user,
            $this->textsService->get('third_stair_test'),
            new InlineKeyboardMarkup([
                [
                    [
                        'text' => 'Пройти тестирование',
                        'callback_data' => 'testing'
                    ]
                ]
            ])
        );
    }

    public function sendQuestion(User $user, int $question_index = 0, int $score = 0) : Message
    {

        $question = $this->getQuestion($question_index);
        $questions_count = $this->getQuestionsCount();

        $text = $this->textsService->get('third_stair_test_question', [
            'index' => $question_index,
            'count' => $questions_count,
            'question' => $question['title']
        ]);

        $buttons = [];
        foreach($question['answers'] as $answer_index => $answer) {

            $cost = ($answer_index === $question['result'] ? 1 : 0);

            $buttons[] = [
                [
                    'text' => $answer,
                    'callback_data' => 'testing,' . ($question_index + 1) . ',' . ($score + $cost),
                ]
            ];
        }

        return $this->telegramService->send(
            $user,
            $text,
            new InlineKeyboardMarkup($buttons)
        );


    }

    public function sendResult(User $user, bool $result) : Message
    {

        if($result){

            return $this->telegramService->send(
                $user,
                $this->textsService->get('third_stair_test_result_success'),
                new InlineKeyboardMarkup([
                    [
                        [
                            'text' => 'Приобрести 3 ступень',
                            'callback_data' => 'buy,' . TariffModes::FULL
                        ]
                    ]
                ])
            );

        }else{

            return $this->telegramService->send(
                $user,
                $this->textsService->get('third_stair_test_result_fail'),
                new InlineKeyboardMarkup([
                    [
                        [
                            'text' => 'Попробовать еще раз',
                            'callback_data' => 'testing'
                        ]
                    ]
                ])
            );

        }

    }

}
