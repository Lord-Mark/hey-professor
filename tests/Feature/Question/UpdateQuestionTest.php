<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, put};

it('should be able to update a question', function () {
    // Arrange
    $user           = factoryNewUser();
    $question       = Question::factory()->for($user)->create(['draft' => true]);
    $newQuestionMsg = 'Updated question?';
    actingAs($user);

    // Act
    $request = put(route('question.update', $question), [
        'question' => $newQuestionMsg,
    ]);

    $question->refresh();

    // Assert
    $request->assertRedirect();
    expect($question->getAttribute('question'))->toBe($newQuestionMsg);

});
