<x-app-layout>
    <x-header>
        {{ __('Vote em uma pergunta!') }}
    </x-header>

    <x-container>

        <x-form post :action="route('question.store')">

            <x-textarea name="question" label="Faça sua pergunta"/>

            <x-btn.primary type="submit">Enviar Pergunta</x-btn.primary>

            <x-btn.reset type="reset">Cancelar</x-btn.reset>

        </x-form>

        <hr class="border-gray-700 border-dashed my-3">

        {{-- Listagem das perguntas --}}

        <div class="dark:text-gray-300 uppercase font-bold mb-1">
            Lista de Perguntas
        </div>

        <div class="space-y-4">
        @foreach($questions as $item)
            <x-question :question="$item" />
        @endforeach
        </div>
    </x-container>

</x-app-layout>
