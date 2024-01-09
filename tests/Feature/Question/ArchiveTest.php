<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, assertSoftDeleted, patch};

it('should be able to archive a question', function () {
    // Arrange
    $user = factoryNewUser();
    actingAs($user);

    /** @var Question $question */
    $question = Question::factory()->for($user)->create(['draft' => true]);

    // Act
    $request = patch(route('question.archive', $question));
    $question->refresh();

    // Assert
    $request->assertRedirect();
    assertSoftDeleted('questions', ['id' => $question->id]);
    expect($question)->not->toBeNull();
});

it('should let only the question owner to archive it', function () {
    // Arrange
    $rightUser = factoryNewUser();
    $wrongUser = factoryNewUser();

    $question = Question::factory()->for($rightUser)->create();

    // Act
    actingAs($wrongUser);
    $wrongRequest = patch(route('question.archive', $question));
    actingAs($rightUser);
    $rightRequest = patch(route('question.archive', $question));

    // Assert
    $wrongRequest->assertForbidden();
    $rightRequest->assertRedirect();

});
