@php $editing = isset($complaint) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="kiosk_participant_id"
            label="Kiosk Participant"
            required
        >
            @php $selected = old('kiosk_participant_id', ($editing ? $complaint->kiosk_participant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Kiosk Participant</option>
            @foreach($kioskParticipants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="title"
            label="Title"
            :value="old('title', ($editing ? $complaint->title : ''))"
            maxlength="255"
            placeholder="Title"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="category"
            label="Category"
            :value="old('category', ($editing ? $complaint->category : ''))"
            maxlength="255"
            placeholder="Category"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="description"
            label="Description"
            :value="old('description', ($editing ? $complaint->description : ''))"
            maxlength="255"
            placeholder="Description"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea
            name="attachment"
            label="Attachment"
            maxlength="255"
            required
            >{{ old('attachment', ($editing ? $complaint->attachment : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="technician_assign"
            label="Technician Assign"
            :value="old('technician_assign', ($editing ? $complaint->technician_assign : ''))"
            maxlength="255"
            placeholder="Technician Assign"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.textarea name="reply" label="Reply" maxlength="255" required
            >{{ old('reply', ($editing ? $complaint->reply : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $complaint->status : '')) @endphp
            <option value="Pending" {{ $selected == 'Pending' ? 'selected' : '' }} >Pending</option>
            <option value="Done" {{ $selected == 'Done' ? 'selected' : '' }} >Done</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
