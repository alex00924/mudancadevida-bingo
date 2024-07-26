<div>
    <div class="block w-full p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700">
        <h5 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white text-center">
            Cartões de bingo
        </h5>

        <div class="mt-4 grid grid-cols-2 lg:grid-cols-4 gap-4">
            @foreach ($cards as $card)
                <div class="w-full border border-yellow_border">
                    <img src="/storage/imgs/card.jpeg?dummy={{$rand}}" class="w-full" />
                    <div class="bg-white p-4">
                        <p class="pl-4 md:pl-8 my-2 md:my-4 text-xl font-bold text-gray-900 dark:text-gray-200"><span class="underline">{{$card['card_number']}}-{{$card['card_digit']}}</p>
                        <table class="w-full text-xl text-center text-gray-900 dark:text-gray-200">
                            <thead class="text-xl md:text-3xl font-bold uppercase bg-gray-500 text-white">
                                <tr>
                                    <th scope="col" class="md:p-2 border-l border-l-gray-500 border-r border-r-gray-300">
                                        B
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        I
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        N
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-300">
                                        G
                                    </th>
                                    <th scope="col" class="md:p-2 border-r border-gray-500">
                                        O
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @for($column=0; $column < 5; $column+=1)
                                    <tr class="bg-white">
                                        @for($row=0; $row < 5; $row+=1)
                                            <td class="md:p-2 border border-gray-500">
                                                {{$card['d' . ($row * 5 + $column + 1)]}}
                                            </td>
                                        @endfor
                                    </tr>
                                @endfor
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
