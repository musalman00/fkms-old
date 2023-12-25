@php $editing = isset($promotion) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select
            name="kiosk_participant_id"
            label="Kiosk Participant"
            required
        >
            @php $selected = old('kiosk_participant_id', ($editing ? $promotion->kiosk_participant_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Kiosk Participant</option>
            @foreach($kioskParticipants as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $promotion->id ? \Storage::url($promotion->id) : '' }}')"
        >
            <x-inputs.partials.label
                name="id"
                label="Picture"
            ></x-inputs.partials.label
            ><br />

            <!-- Show the image -->
            <template x-if="imageUrl">
                <img
                    :src="imageUrl"
                    class="object-cover rounded border border-gray-200"
                    style="width: 100px; height: 100px;"
                />
            </template>

            <!-- Show the gray box when image is not available -->
            <template x-if="!imageUrl">
                <div
                    class="border rounded border-gray-200 bg-gray-100"
                    style="width: 100px; height: 100px;"
                ></div>
            </template>

            <div class="mt-2">
                <input type="file" name="id" id="id" @change="fileChosen" />
            </div>

            @error('id') @include('components.inputs.partials.error') @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="description"
            label="Description"
            :value="old('description', ($editing ? $promotion->description : ''))"
            maxlength="255"
            placeholder="Description"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="publish_time"
            label="Publish Time"
            value="{{ old('publish_time', ($editing ? optional($promotion->publish_time)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.datetime
            name="promotion_ends"
            label="Promotion Ends"
            value="{{ old('promotion_ends', ($editing ? optional($promotion->promotion_ends)->format('Y-m-d\TH:i:s') : '')) }}"
            max="255"
            required
        ></x-inputs.datetime>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $promotion->status : 'pending')) @endphp
            <option value="approved" {{ $selected == 'approved' ? 'selected' : '' }} >Approved</option>
            <option value="rejected" {{ $selected == 'rejected' ? 'selected' : '' }} >Rejected</option>
            <option value="pending" {{ $selected == 'pending' ? 'selected' : '' }} >Pending</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
