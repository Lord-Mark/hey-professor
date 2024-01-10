<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, assertDatabaseHas, put};

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

// Testes das regras de QuestionRequest também utilizadas para a criação de perguntas

it('should be able to update a new question bigger than 255 characters', function () {

    // Arrange
    $user = factoryNewUser();
    actingAs($user);
    $question           = Question::factory()->for($user)->create(['draft' => true]);
    $updatedQuestionMsg = str_repeat("*", 260) . "?";

    // Act
    $request = put(route("question.update", $question), [
        'question' => $updatedQuestionMsg,
    ]);

    $question->refresh();

    // Assert :: Verificar
    $request->assertRedirect();

    expect($question->getAttribute('question'))->toBe($updatedQuestionMsg);

});

it('should have at least 10 characters', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create(['draft' => true]);

    $oldQuestionMsg     = $question->getAttribute('question');
    $updatedQuestionMsg = str_repeat("*", 8) . "?";

    actingAs($user);

    // Act

    $request = put(route("question.update", $question), [
        'question' => $updatedQuestionMsg,
    ]);

    $question->refresh();

    // Assert
    $request->assertSessionHasErrors([
        'question' => __("validation.min.string", ["min" => 10, 'attribute' => 'question']),
    ]);

    expect($question->getAttribute('question'))->toBe($oldQuestionMsg);

});

it('should check if it ends with a question mark', function () {
    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create(['draft' => true]);

    $oldQuestionMsg     = $question->getAttribute('question');
    $updatedQuestionMsg = str_repeat("*", 10);

    actingAs($user);

    // Act
    $request = put(route("question.update", $question), [
        'question' => $updatedQuestionMsg,
    ]);

    $question->refresh();

    // Assert

    $request->assertSessionHasErrors([
        'question' => "Are you sure that it is a question, it's missing a question mark (?) in the end.",
    ]);

    expect($question->getAttribute('question'))->toBe($oldQuestionMsg);
});

it('should update a question and keep it as a draft always', function () {

    // Arrange
    $user     = factoryNewUser();
    $question = Question::factory()->for($user)->create(['draft' => true]);

    $oldQuestionMsg     = $question->getAttribute('question');
    $updatedQuestionMsg = str_repeat("*", 10) . "?";

    actingAs($user);

    // Act
    $request = put(route("question.update", $question), [
        'question' => $updatedQuestionMsg,
    ]);

    $question->refresh();

    // Assert
    assertDatabaseHas('questions', [
        'question' => $updatedQuestionMsg,
        'draft'    => true,
    ]);
});
