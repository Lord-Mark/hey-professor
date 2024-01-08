<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, get};

it('should be able access an edit question route', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create(['draft' => true]);

    actingAs($user);

    // Act
    $request = get(route('question.edit', $question));

    // Assert
    $request->assertSuccessful();
});

it('should return an edit view', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create(['draft' => true]);

    actingAs($user);

    // Act
    $request = get(route('question.edit', $question));

    // Assert
    $request->assertViewIs('question.edit');
});

it('should be sure that only draft questions can be edited', function () {
    // Arrange
    $user             = factoryNewUser();
    $draftQuestion    = Question::factory()->for($user)->create(['draft' => true]);
    $notDraftQuestion = Question::factory()->for($user)->create(['draft' => false]);

    actingAs($user);

    // Act
    $draftRequest    = get(route('question.edit', $draftQuestion));
    $notDraftRequest = get(route('question.edit', $notDraftQuestion));

    // Assert
    $draftRequest->assertSuccessful();
    $notDraftRequest->assertForbidden();
});
