<?php

use App\Models\Question;

use function Pest\Laravel\actingAs;

it('should be able to search questions by text', function () {
    $user        = factoryNewUser();
    $questionMsg = 'My question?';

    $wrongQuestions = Question::factory()->count(10)->create(['draft' => false]);
    $rightQuestion  = Question::factory()->create(['question' => $questionMsg, 'draft' => false]);

    actingAs($user);

    $response = \Pest\Laravel\get(route('dashboard', ['search' => 'question']));

    /** @var Question $item */
    foreach ($wrongQuestions as $item) {
        $response->assertDontSee($item->question);
    }

    $response->assertSee($questionMsg);
});
