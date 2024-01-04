<?php

use App\Models\Question;

use function Pest\Laravel\{actingAs, get};

it('should list all the questions on the dashboard', function () {
    // Arrange
    $user = \App\Models\User::factory()->create();
    actingAs($user);
    // Cria algumas perguntas
    $questions = Question::factory()->count(5)->create();

    // Act
    // Acessa a rota
    $response = get(route('dashboard'));

    // Assert
    // Verificar se a lista de perguntas está sendo exibida

    /** @var Question $q */
    foreach ($questions as $q) {
        $response->assertSee($q->question);
    }

});
