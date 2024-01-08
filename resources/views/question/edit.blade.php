<x-app-layout>
    <x-header>
        {{ __('Editar pergunta') }} :: {{ $question->id }}
    </x-header>
    <x-container>

        <x-form put :action="route('question.update', $question)">

            <x-textarea name="question" label="Edite sua pergunta" :value="$question->question"/>

            <x-btn.primary type="submit">Editar Pergunta</x-btn.primary>

            <x-btn.reset type="reset">Cancelar</x-btn.reset>

        </x-form>

    </x-container>
</x-app-layout>
