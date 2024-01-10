<?php

use App\Models\{Question, User};

use function Pest\Laravel\{actingAs, assertDatabaseCount, assertDatabaseHas, post, postJson};

it('should be able to create a new question bigger than 255 characters', function () {

    // Arrange :: Preparar

    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route("question.store"), [
        'question' => str_repeat("*", 260) . "?",
    ]);

    // Assert :: Verificar
    $request->assertRedirect();

    assertDatabaseCount('questions', 1);

    assertDatabaseHas('questions', ['question' => str_repeat("*", 260) . "?"]);

});

it('should have at least 10 characters', function () {
    // Arrange :: Preparar
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route("question.store"), [
        'question' => str_repeat("*", 8) . "?",
    ]);

    // Assert :: Verificar
    $request->assertSessionHasErrors([
        'question' => __("validation.min.string", ["min" => 10, 'attribute' => 'question']),
    ]);
    assertDatabaseCount('questions', 0);

});

it('should check if it ends with a question mark', function () {
    // Arrange :: Preparar
    /** @var User $user */
    $user = User::factory()->create();
    actingAs($user);

    // Act :: Agir
    $request = post(route("question.store"), [
        'question' => str_repeat("*", 10),
    ]);

    // Assert :: Verificar
    $request->assertSessionHasErrors([
        'question' => "Are you sure that it is a question, it's missing a question mark (?) in the end.",
    ]);
    assertDatabaseCount('questions', 0);
});

it('should create a question as a draft always', function () {

    //Arrange
    $user = factoryNewUser();
    actingAs($user);

    // Act
    $request = post(route("question.store"), [
        'question' => str_repeat("*", 10) . "?",
    ]);

    // Assert
    assertDatabaseHas('questions', [
        'question' => str_repeat("*", 10) . "?",
        'draft'    => true,
    ]);
});

test('only authenticated users can create new question', function () {

    // Act
    $request = post(route("question.store"), [
        'question' => str_repeat("*", 10) . "?",
    ]);

    // Assert
    $request->assertRedirect(route('login'));

});

test('question should be unique', function () {
    $user = factoryNewUser();

    actingAs($user);

    $questionMsg = 'Alguma pergunta?';

    Question::factory()->create(['question' => $questionMsg, 'draft' => false]);

    post(route('question.store'), [
        'question' => $questionMsg,
    ])->assertSessionHasErrors(['question' => 'This question already exists!']);
});
