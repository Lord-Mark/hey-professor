<x-app-layout>
    <x-header>
        {{ __('Minhas perguntas') }}
    </x-header>

    <x-container>

        <x-form post :action="route('question.store')">

            <x-textarea name="question" label="Faça sua pergunta"/>

            <x-btn.primary type="submit">Enviar Pergunta</x-btn.primary>

            <x-btn.reset type="reset">Cancelar</x-btn.reset>

        </x-form>


        <hr class="border-gray-700 border-dashed my-3">

        {{-- Listagem de drafts --}}

        <div class="dark:text-gray-300 uppercase font-bold mb-1">
            Meus rascunhos
        </div>

        <div class="space-y-4">

            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>
                            Rascunho
                        </x-table.th>
                        <x-table.th>
                            Ações
                        </x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($questions->where('draft', true) as $item)
                    <x-table.tr>
                        <x-table.td>
                            {{ $item->question }}
                        </x-table.td>
                        <x-table.td>
                            <div class="flex">

                                <x-form delete :action="route('question.destroy', $item)">

                                    <x-btn.danger type="submit">
                                        Deletar
                                    </x-btn.danger>

                                </x-form>

                                <x-form get :action="route('question.edit', $item)">
                                    <x-btn.purple type="submit">
                                        Editar
                                    </x-btn.purple>
                                </x-form>

                                <x-form put :action="route('question.publish', $item)">
                                    <x-btn.primary type="submit">
                                        Publicar
                                    </x-btn.primary>
                                </x-form>

                            </div>
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

        <hr class="border-gray-700 border-dashed my-3">

        {{-- Listagem das perguntas --}}

        <div class="dark:text-gray-300 uppercase font-bold mb-1">
            Minhas perguntas
        </div>

        <div class="space-y-4">

            {{--            <x-question :question="$item"/>--}}
            <x-table>
                <x-table.thead>
                    <tr>
                        <x-table.th>
                            Pergunta
                        </x-table.th>
                        <x-table.th>
                            Ações
                        </x-table.th>
                    </tr>
                </x-table.thead>
                <tbody>
                @foreach($questions->where('draft', false) as $item)
                    <x-table.tr>
                        <x-table.td>
                            {{ $item->question }}
                        </x-table.td>
                        <x-table.td>
                            // Botão delete
                            // Botão publicar
                        </x-table.td>
                    </x-table.tr>
                @endforeach
                </tbody>
            </x-table>
        </div>

    </x-container>

</x-app-layout>
