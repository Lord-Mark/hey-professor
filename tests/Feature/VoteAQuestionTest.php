<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseHas, post};

it("should be able to vote on a question", function () {

    // Arrange
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);
    $question = Question::factory()->create();

    // Act
    $response = post(route('question.like', $question));

    // Assert
    $response->assertRedirect();
    assertDatabaseHas('votes', [
        'question_id' => $question->getAttribute('id'),
        'like'        => 1,
        'dislike'     => 0,
        'user_id'     => $user->getAttribute('id'),
    ]);

});

it("should not be able to vote twice", function () {
    // Arrange

    // Act
    // Assert
})->todo();
