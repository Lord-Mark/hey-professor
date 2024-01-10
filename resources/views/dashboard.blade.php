<x-app-layout>
    <x-header>
        {{ __('Vote em uma pergunta!') }}
    </x-header>

    <x-container>

        <x-search-input
            placeholder="Busque uma pergunta"
            label="Buscar"
            :action="route('dashboard')"
            name="search"
        />

        <hr class="border-gray-700 border-dashed my-5">


        {{-- Listagem das perguntas --}}

        <div class="dark:text-gray-300 uppercase font-bold mb-1">
            Lista de Perguntas
        </div>

        @if($questions->isEmpty())
            <div class="space-y-5 mt-10">
                <div class="flex justify-center">
                    <x-draw.searching width="300"/>
                </div>
                <div class="text-center text-gray-400 font-bold text-2xl">
                    Pergunta não encontrada...
                </div>
            </div>
        @else
            <div class="space-y-4">
                @foreach($questions as $item)
                    <x-question :question="$item"/>
                @endforeach

                {{ $questions->withQueryString()->links() }}
            </div>
        @endif
    </x-container>

</x-app-layout>
