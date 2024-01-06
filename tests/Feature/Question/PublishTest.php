<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    // Arrange
    $user = factoryNewUser();
    actingAs($user);
    $question = Question::factory()->for($user)->create(['draft' => true]);

    // Act
    put(route('question.publish', $question))->assertRedirect();
    $question->refresh();

    // Assert
    expect($question->getAttribute('draft'))->toBeFalse();
});

test('checks if only the user who created a question can publish it', function () {
    // Arrange
    $ownerUser = factoryNewUser();
    $wrongUser = factoryNewUser();

    //Act
    actingAs($ownerUser);

    $question = Question::factory()->for($ownerUser)->create(['draft' => true]);
    $question->refresh();

    // Assert
    actingAs($wrongUser);
    put(route('question.publish', $question))->assertForbidden();

});
