<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, get};

it('should be able access an edit question route', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create();

    actingAs($user);

    // Act
    $request = get(route('question.edit', $question));

    // Assert
    $request->assertSuccessful();
});

it('should return an edit view', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create();

    actingAs($user);

    // Act
    $request = get(route('question.edit', $question));

    // Assert
    $request->assertViewIs('question.edit');

});
