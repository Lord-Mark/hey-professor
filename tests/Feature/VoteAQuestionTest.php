<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it("should be able to vote on a question", function () {
    // Arrange
    $user = User::factory()->create();
    actingAs($user);
    $question = Question::factory()->create();
    // Act
    post(route('question.like', $question))->assertRedirect();

    // Assert
    assertDatabaseHas('votes', [
        'question_id' => $question->id,
        'like'        => 1,
        'dislike'     => 0,
        'user_id'     => $user->id,
    ]);
});
