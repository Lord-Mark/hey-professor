<x-app-layout>
    <x-header>
        {{ __('Dashboard') }}
    </x-header>

    <x-container>

        <x-form post :action="route('question.store')">

            <x-textarea name="question" label="Faça sua pergunta" />

            <x-btn.primary type="submit"> Enviar Pergunta </x-btn.primary>

            <x-btn.reset type="reset"> Cancelar </x-btn.reset>

        </x-form>

    </x-container>

</x-app-layout>
