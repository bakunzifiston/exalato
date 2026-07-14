@php
    $record = $user ?? null;
@endphp

<x-admin.form :method="$method ?? 'POST'" :action="$action">
    <x-admin.input label="Name" name="name" :value="$record->name ?? null" :required="true" />
    <x-admin.input label="Email" name="email" type="email" :value="$record->email ?? null" :required="true" />
    <x-admin.input label="Email Verified At" name="email_verified_at" type="datetime-local" :value="isset($record) && $record->email_verified_at ? $record->email_verified_at->format('Y-m-d\\TH:i') : null" />
    <x-admin.input label="Password" name="password" type="password" :required="true" />

    <div class="flex flex-wrap gap-3 pt-2">
        <x-admin.button type="submit">{{ $submitLabel }}</x-admin.button>
        <x-admin.button variant="secondary" :href="route('admin.users.index')">Cancel</x-admin.button>
    </div>
</x-admin.form>
