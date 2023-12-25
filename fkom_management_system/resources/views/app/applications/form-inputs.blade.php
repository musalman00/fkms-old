@php $editing = isset($application) @endphp

<div class="flex flex-wrap">
    <x-inputs.group class="w-full">
        <x-inputs.select name="kiosk_id" label="Kiosk" required>
            @php $selected = old('kiosk_id', ($editing ? $application->kiosk_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Kiosk</option>
            @foreach($kiosks as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="user_id" label="User" required>
            @php $selected = old('user_id', ($editing ? $application->user_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the User</option>
            @foreach($users as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="payment_id" label="Payment" required>
            @php $selected = old('payment_id', ($editing ? $application->payment_id : '')) @endphp
            <option disabled {{ empty($selected) ? 'selected' : '' }}>Please select the Payment</option>
            @foreach($payments as $value => $label)
            <option value="{{ $value }}" {{ $selected == $value ? 'selected' : '' }} >{{ $label }}</option>
            @endforeach
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="start_date"
            label="Start Date"
            value="{{ old('start_date', ($editing ? optional($application->start_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.date
            name="end_date"
            label="End Date"
            value="{{ old('end_date', ($editing ? optional($application->end_date)->format('Y-m-d') : '')) }}"
            max="255"
            required
        ></x-inputs.date>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="operating_day"
            label="Operating Day"
            :value="old('operating_day', ($editing ? $application->operating_day : ''))"
            maxlength="255"
            placeholder="Operating Day"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="operating_hour"
            label="Operating Hour"
            :value="old('operating_hour', ($editing ? $application->operating_hour : ''))"
            maxlength="255"
            placeholder="Operating Hour"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="business_type"
            label="Business Type"
            :value="old('business_type', ($editing ? $application->business_type : ''))"
            maxlength="255"
            placeholder="Business Type"
            required
        ></x-inputs.text>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.select name="status" label="Status">
            @php $selected = old('status', ($editing ? $application->status : 'pending')) @endphp
            <option value="approved" {{ $selected == 'approved' ? 'selected' : '' }} >Approved</option>
            <option value="rejected" {{ $selected == 'rejected' ? 'selected' : '' }} >Rejected</option>
            <option value="pending" {{ $selected == 'pending' ? 'selected' : '' }} >Pending</option>
        </x-inputs.select>
    </x-inputs.group>

    <x-inputs.group class="w-full">
        <x-inputs.text
            name="reason_reject"
            label="Reason Reject"
            :value="old('reason_reject', ($editing ? $application->reason_reject : ''))"
            maxlength="255"
            placeholder="Reason Reject"
            required
        ></x-inputs.text>
    </x-inputs.group>
</div>
