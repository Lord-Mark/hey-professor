<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <form action="{{route('question.store')}}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="question" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Sua pergunta
                    </label>
                    <textarea id="question"
                              rows="4"
                              name="question"
                              class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border
                              border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700
                              dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500
                              dark:focus:border-blue-500"
                              placeholder="Escreva sua pergunta aqui!">{{old('question')}}</textarea>
                    @error('question')
                    <span class="text-red-600">{{$message}}</span>
                    @enderror
                </div>
                <button type="submit"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4
                        focus:ring-blue-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2
                        dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                    Enviar Pergunta
                </button>
                <button type="reset"
                        class="py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white
                        rounded-full border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10
                        focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400
                        dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    Cancelar
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
