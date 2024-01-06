<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, put};

it('should be able to publish a question', function () {
    // Arrange
    actingAs(factoryNewUser());
    $question = Question::factory()->create(['draft' => true]);

    // Act
    put(route('question.publish', $question))->assertRedirect();
    $question->refresh();

    // Assert
    expect($question->getAttribute('draft'))->toBeFalse();
});
