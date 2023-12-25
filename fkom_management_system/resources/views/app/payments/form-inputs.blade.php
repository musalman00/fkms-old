@php $editing = isset($payment) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $payment->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.number
            name="amount"
            label="Amount"
            :value="old('amount', ($editing ? $payment->amount : ''))"
            max="255"
            step="0.01"
            placeholder="Amount"
        ></x-inputs.number>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <div
            x-data="imageViewer('{{ $editing && $payment->qr_picture ? \Storage::url($payment->qr_picture) : '' }}')"
        >
            <x-inputs.partials.label
                name="qr_picture"
                label="Qr Picture"
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
                <input
                    type="file"
                    name="qr_picture"
                    id="qr_picture"
                    @change="fileChosen"
                />
            </div>

            @error('qr_picture') @include('components.inputs.partials.error')
            @enderror
        </div>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $payment->status : 'pending')) @endphp
            <option value="paid" {{ $selected == 'paid' ? 'selected' : '' }} >Paid</option>
            <option value="unpaid" {{ $selected == 'unpaid' ? 'selected' : '' }} >Unpaid</option>
            <option value="pending" {{ $selected == 'pending' ? 'selected' : '' }} >Pending</option>
        </x-inputs.select>
    </x-inputs.group>
</div>
