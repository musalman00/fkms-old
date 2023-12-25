<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            @lang('crud.complaints.index_title')
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-partials.card>
                <div class="mb-5 mt-4">
                    <div class="flex flex-wrap justify-between">
                        <div class="md:w-1/2">
                            <form>
                                <div class="flex items-center w-full">
                                    <x-inputs.text
                                        name="search"
                                        value="{{ $search ?? '' }}"
                                        placeholder="{{ __('crud.common.search') }}"
                                        autocomplete="off"
                                    ></x-inputs.text>

                                    <div class="ml-1">
                                        <button
                                            type="submit"
                                            class="button button-primary"
                                        >
                                            <i class="icon ion-md-search"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="md:w-1/2 text-right">
                            @can('create', App\Models\Complaint::class)
                            <a
                                href="{{ route('complaints.create') }}"
                                class="button button-primary"
                            >
                                <i class="mr-1 icon ion-md-add"></i>
                                @lang('crud.common.create')
                            </a>
                            @endcan
                        </div>
                    </div>
                </div>

                <div class="block w-full overflow-auto scrolling-touch">
                    <table class="w-full max-w-full mb-4 bg-transparent">
                        <thead class="text-gray-700">
                            <tr>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.kiosk_participant_id')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.title')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.category')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.attachment')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.description')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.technician_assign')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.reply')
                                </th>
                                <th class="px-4 py-3 text-left">
                                    @lang('crud.complaints.inputs.status')
                                </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-600">
                            @forelse($complaints as $complaint)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-left">
                                    {{
                                    optional($complaint->kioskParticipant)->id
                                    ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->title ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->category ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    <x-partials.thumbnail
                                        src="{{ $complaint->attachment ? \Storage::url($complaint->attachment) : '' }}"
                                    />
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->description ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->technician_assign ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->reply ?? '-' }}
                                </td>
                                <td class="px-4 py-3 text-left">
                                    {{ $complaint->status ?? '-' }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center"
                                    style="width: 134px;"
                                >
                                    <div
                                        role="group"
                                        aria-label="Row Actions"
                                        class="
                                            relative
                                            inline-flex
                                            align-middle
                                        "
                                    >
                                        @can('update', $complaint)
                                        <a
                                            href="{{ route('complaints.edit', $complaint) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i
                                                    class="icon ion-md-create"
                                                ></i>
                                            </button>
                                        </a>
                                        @endcan @can('view', $complaint)
                                        <a
                                            href="{{ route('complaints.show', $complaint) }}"
                                            class="mr-1"
                                        >
                                            <button
                                                type="button"
                                                class="button"
                                            >
                                                <i class="icon ion-md-eye"></i>
                                            </button>
                                        </a>
                                        @endcan @can('delete', $complaint)
                                        <form
                                            action="{{ route('complaints.destroy', $complaint) }}"
                                            method="POST"
                                            onsubmit="return confirm('{{ __('crud.common.are_you_sure') }}')"
                                        >
                                            @csrf @method('DELETE')
                                            <button
                                                type="submit"
                                                class="button"
                                            >
                                                <i
                                                    class="
                                                        icon
                                                        ion-md-trash
                                                        text-red-600
                                                    "
                                                ></i>
                                            </button>
                                        </form>
                                        @endcan
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="9">
                                    @lang('crud.common.no_items_found')
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="9">
                                    <div class="mt-10 px-4">
                                        {!! $complaints->render() !!}
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </x-partials.card>
        </div>
    </div>
</x-app-layout>
