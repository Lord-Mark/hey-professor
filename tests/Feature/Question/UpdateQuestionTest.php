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

it('should be sure that only draft questions can be edited', function () {
    // Arrange
    $user             = factoryNewUser();
    $draftQuestion    = Question::factory()->for($user)->create(['draft' => true]);
    $notDraftQuestion = Question::factory()->for($user)->create(['draft' => false]);

    $questionMsg = 'New question?';

    actingAs($user);

    // Act
    $draftRequest    = put(route('question.update', $draftQuestion), ['question' => $questionMsg]);
    $notDraftRequest = put(route('question.update', $notDraftQuestion), ['question' => $questionMsg]);

    // Assert
    $draftRequest->assertRedirect();
    $notDraftRequest->assertForbidden();
});

it('should be sure that only the question owner can edit it', function () {
    // Arrange
    $rightUser = factoryNewUser();
    $wrongUser = factoryNewUser();

    $question    = Question::factory()->for($rightUser)->create(['draft' => true]);
    $questionMsg = 'New question?';

    // Act
    actingAs($wrongUser);
    $wrongRequest = put(route('question.update', $question), ['question' => $questionMsg]);

    actingAs($rightUser);
    $rightRequest = put(route('question.update', $question), ['question' => $questionMsg]);

    // Assert
    $rightRequest->assertRedirect();
    $wrongRequest->assertForbidden();
});
