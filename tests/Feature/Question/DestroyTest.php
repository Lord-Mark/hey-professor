<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, assertDatabaseMissing, delete, put};

it('should be able to destroy a question', function () {
    // Arrange
    $user = factoryNewUser();
    actingAs($user);
    $question = Question::factory()->for($user)->create(['draft' => true]);

    // Act
    delete(route('question.destroy', $question))->assertRedirect();

    // Assert
    assertDatabaseMissing('questions', ['id' => $question]);
});
