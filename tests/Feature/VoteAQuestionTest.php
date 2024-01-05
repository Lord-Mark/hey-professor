<?php

use App\Models\{Question, User, Vote};

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

    /** @var User $user */
    $user = User::factory()->create();// User2

    /** @var User $user2 */
    $user2 = User::factory()->create();

    $question = Question::factory()->create();

    // Act
    actingAs($user);

    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));
    post(route('question.like', $question));

    actingAs($user2);

    post(route('question.like', $question));
    post(route('question.like', $question));

    // Assert
    expect(
        $user
            ->votes()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(1)->and(
        $user2->votes()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(1)->and(
        Vote::query()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(2);

});

//////////// DISLIKE ////////////

it("should be able to dislike a question", function () {

    // Arrange
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);
    $question = Question::factory()->create();

    // Act
    $response = post(route('question.dislike', $question));

    // Assert
    $response->assertRedirect();
    assertDatabaseHas('votes', [
        'question_id' => $question->getAttribute('id'),
        'like'        => 0,
        'dislike'     => 1,
        'user_id'     => $user->getAttribute('id'),
    ]);
});

it("should not be able to dislike twice", function () {

    // Arrange

    /** @var User $user */
    $user = User::factory()->create();// User2

    /** @var User $user2 */
    $user2 = User::factory()->create();

    $question = Question::factory()->create();

    // Act
    actingAs($user);

    post(route('question.dislike', $question));
    post(route('question.dislike', $question));
    post(route('question.dislike', $question));
    post(route('question.dislike', $question));

    actingAs($user2);

    post(route('question.dislike', $question));
    post(route('question.dislike', $question));

    // Assert
    expect(
        $user
            ->votes()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(1)->and(
        $user2->votes()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(1)->and(
        Vote::query()
            ->where('question_id', '=', $question->getAttribute('id'))->get()
    )->toHaveCount(2);

});
