@props(['icon', 'label', 'value'])

<div class="col-md-4">
    <div class="border rounded shadow-sm p-3 h-100 transition bg-light bg-opacity-75 hover-shadow">
        <div class="d-flex align-items-center mb-2">
            <span class="material-symbols-outlined text-primary me-2">{{ $icon }}</span>
            <strong>{{ $label }}</strong>
        </div>
        <div class="fs-6">{!! $value !!}</div>
    </div>
</div>

<style>
    .hover-shadow:hover {
        box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, 0.1);
        transform: translateY(-2px);
        transition: all 0.3s ease;
    }
</style>
