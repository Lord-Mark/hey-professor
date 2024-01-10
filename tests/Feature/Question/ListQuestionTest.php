<?php

use App\Models\Question;

use Illuminate\Pagination\LengthAwarePaginator;

use function Pest\Laravel\{actingAs, get};

it('should list at least the first 5 questions on the dashboard', function () {
    // Arrange
    $user = factoryNewUser();
    actingAs($user);
    // Cria algumas perguntas
    $questions = Question::factory()->count(5)->create(['draft' => false]);

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

it('should paginate the result', function () {
    // Arrange
    $user = factoryNewUser();
    Question::factory()->count(25)->create(['draft' => false]);
    actingAs($user);

    // Act
    $response = get(route('dashboard'));

    // Assert → verifica se o que foi encontrado em questions é uma instância de LengthAwarePaginator
    $response->assertViewHas('questions', fn ($value) => $value instanceof LengthAwarePaginator);
});

it('should order by like and dislike, most liked on top, most disliked on bottom', function () {
    // Arrange
    $user  = factoryNewUser();
    $user2 = factoryNewUser();
    Question::factory()->count(5)->create(['draft' => false]);

    /** @var Question $mostLikedQ */
    $mostLikedQ = Question::query()->find(3);

    /** @var Question $mostDislikedQ */
    $mostDislikedQ = Question::query()->find(1);

    // Act
    $user->like($mostLikedQ);
    $user2->dislike($mostDislikedQ);

    actingAs($user);

    $request = get(route('dashboard'));

    // Assert
    $request->assertViewHas(
        'questions',
        function ($questions) use ($mostDislikedQ, $mostLikedQ) {

            expect($questions->first()->id)
                ->toBe($mostLikedQ->id)
                ->and($questions->last()->id)
                ->toBe($mostDislikedQ->id);

            return true;
        }
    );
});
