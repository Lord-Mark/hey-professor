@props(['question'])
<div class="
        rounded dark:bg-gray-800/50 dark:text-gray-400 p-3
        shadow shadow-blue-500/20 flex justify-between items-center
    ">
    <span>{{ $question->question }}</span>
    <div class="flex space-x-2.5">
        <x-form :action="route('question.like', $question)">
            <button type="submit" class="flex items-center space-x-1">
                <span>{{$question->votes_sum_like ?: 0}}</span>
                <x-icons.thumbs-up class="w-5 h-5 text-sky-600/80 hover:text-sky-500 cursor-pointer"/>
            </button>
        </x-form>

        <x-form :action="route('question.dislike', $question)">
            <button type="submit" class="flex items-center space-x-1">
                <span>{{$question->votes_sum_dislike ?: 0}}</span>
                <x-icons.thumbs-down class="w-5 h-5 text-red-700 hover:text-red-800 cursor-pointer"/>
            </button>
        </x-form>
    </div>
</div>
