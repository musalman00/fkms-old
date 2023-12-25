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
        <x-inputs.textarea
            name="qr_picture"
            label="Qr Picture"
            maxlength="255"
            required
            >{{ old('qr_picture', ($editing ? $payment->qr_picture : ''))
            }}</x-inputs.textarea
        >
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $payment->status : '')) @endphp
        </x-inputs.select>
    </x-inputs.group>
</div>
