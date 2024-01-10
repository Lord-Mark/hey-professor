<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, get};

it('should be able to list all questions created by me', function () {

    // Arrange
    $user      = factoryNewUser();
    $wrongUser = factoryNewUser();

    $question      = Question::factory()->for($user)->count(10)->create();
    $wrongQuestion = Question::factory()->for($wrongUser)->count(10)->create();

    // Act
    actingAs($user);
    $response = get(route('question.index'));

    // Assert
    foreach ($question as $item) {
        $response->assertSee($item->getAttribute('question'));
    }

    foreach ($wrongQuestion as $item) {
        $response->assertDontSee($item->getAttribute('question'));
    }

});
