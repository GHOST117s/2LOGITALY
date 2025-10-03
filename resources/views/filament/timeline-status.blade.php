{{-- filepath: /home/sidharth-kumar-samal/Live_Projects/2logitaly/resources/views/filament/timeline-status.blade.php --}}
<div class="timeline-container">
    @php
        $steps = ['Booked', 'Picked Up', 'Departed', 'Arrived', 'Delivered'];
        $currentStep = 0; // Default to first step

        // Determine current step based on booking status
        if (isset($getRecord) && $getRecord()) {
            $status = $getRecord()->booking_status;
            $currentStep = array_search($status, $steps);
            if ($currentStep === false) $currentStep = 0;
        }

        $progressPercentage = ($currentStep / (count($steps) - 1)) * 100;
    @endphp

    <!-- Progress Bar Header -->
    <div class="timeline-header">
        <div class="timeline-title-section">
            <h3 class="timeline-title">Shipment Progress</h3>
            <span class="timeline-percentage">{{ round($progressPercentage) }}% Complete</span>
        </div>

        <!-- Main Progress Bar -->
        <div class="timeline-progress-bar">
            <div class="timeline-progress-fill" style="width: {{ $progressPercentage }}%;"></div>
        </div>
    </div>

    <!-- Timeline Steps -->
    <div class="timeline-steps-container">
        <div class="timeline-steps-wrapper">
            @foreach ($steps as $i => $step)
                <div class="timeline-step">
                    <!-- Step Circle -->
                    <div class="timeline-step-circle-wrapper">
                        <div class="timeline-step-circle
                            {{ $i <= $currentStep ? 'timeline-step-completed' : '' }}
                            {{ $i == $currentStep + 1 ? 'timeline-step-next' : '' }}
                            {{ $i > $currentStep + 1 ? 'timeline-step-future' : '' }}
                        ">
                            @if($i < $currentStep)
                                <!-- Completed Step - Checkmark -->
                                <svg class="timeline-check-icon" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            @elseif($i == $currentStep)
                                <!-- Current Step - Pulsing Dot -->
                                <div class="timeline-pulse-dot"></div>
                            @else
                                <!-- Future Step - Number -->
                                <span class="timeline-step-number">{{ $i + 1 }}</span>
                            @endif
                        </div>
                    </div>

                    <!-- Step Label -->
                    <div class="timeline-step-label">
                        <span class="timeline-step-title
                            {{ $i <= $currentStep ? 'timeline-step-title-active' : '' }}
                            {{ $i == $currentStep + 1 ? 'timeline-step-title-next' : '' }}
                        ">
                            {{ $step }}
                        </span>
                        <span class="timeline-step-status
                            {{ $i == $currentStep ? 'timeline-step-status-current' : '' }}
                            {{ $i < $currentStep ? 'timeline-step-status-completed' : '' }}
                        ">
                            @if($i == $currentStep)
                                Current
                            @elseif($i < $currentStep)
                                ✓ Done
                            @else
                                Pending
                            @endif
                        </span>
                    </div>
                </div>

                <!-- Connector Line between steps -->
                @if($i < count($steps) - 1)
                    <div class="timeline-connector {{ $i < $currentStep ? 'timeline-connector-completed' : '' }}"
                         style="left: {{ (($i + 1) / count($steps)) * 100 - (50 / count($steps)) }}%; width: {{ (100 / count($steps)) }}%;">
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>

<style>
/* Base styles (Light Mode) */
.timeline-container {
    background: #ffffff;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
}

.timeline-header {
    margin-bottom: 20px;
}

.timeline-title-section {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
}

.timeline-title {
    font-size: 18px;
    font-weight: 600;
    color: #111827;
    margin: 0;
}

.timeline-percentage {
    font-size: 14px;
    font-weight: 500;
    color: #6b7280;
}

.timeline-progress-bar {
    width: 100%;
    background-color: #e5e7eb;
    border-radius: 9999px;
    height: 8px;
    overflow: hidden;
}

.timeline-progress-fill {
    background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%);
    height: 8px;
    border-radius: 9999px;
    transition: width 0.7s ease-out;
}

.timeline-steps-container {
    position: relative;
    margin: 24px 0;
}

.timeline-steps-wrapper {
    display: flex;
    align-items: flex-start;
    position: relative;
}

.timeline-step {
    display: flex;
    flex-direction: column;
    align-items: center;
    position: relative;
    flex: 1;
    min-width: 0;
}

.timeline-step-circle-wrapper {
    position: relative;
    z-index: 10;
    margin-bottom: 16px;
}

.timeline-step-circle {
    border-radius: 50%;
    width: 48px;
    height: 48px;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #d1d5db;
    transition: all 0.3s ease;
    background-color: #f9fafb;
    color: #9ca3af;
}

.timeline-step-completed {
    background: linear-gradient(135deg, #3b82f6 0%, #10b981 100%);
    border-color: transparent;
    color: white;
    box-shadow: 0 4px 8px rgba(59, 130, 246, 0.3);
}

.timeline-step-next {
    background-color: #fef3c7;
    border-color: #f59e0b;
    color: #d97706;
}

.timeline-step-future {
    background-color: #f9fafb;
    border-color: #d1d5db;
    color: #9ca3af;
}

.timeline-check-icon {
    width: 20px;
    height: 20px;
}

.timeline-pulse-dot {
    width: 8px;
    height: 8px;
    background-color: white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

.timeline-step-number {
    font-size: 14px;
    font-weight: 600;
}

.timeline-step-label {
    text-align: center;
    width: 100%;
}

.timeline-step-title {
    display: block;
    font-size: 13px;
    font-weight: 600;
    line-height: 1.2;
    color: #6b7280;
}

.timeline-step-title-active {
    color: #2563eb;
}

.timeline-step-title-next {
    color: #d97706;
}

.timeline-step-status {
    display: block;
    font-size: 11px;
    font-weight: 500;
    margin-top: 4px;
    color: #9ca3af;
}

.timeline-step-status-current {
    color: #3b82f6;
}

.timeline-step-status-completed {
    color: #10b981;
}

.timeline-connector {
    position: absolute;
    top: 24px;
    height: 2px;
    background-color: #d1d5db;
    transition: all 0.3s ease;
    z-index: 1;
}

.timeline-connector-completed {
    background: linear-gradient(90deg, #3b82f6 0%, #10b981 100%);
}

/* Dark Mode Styles */
.dark .timeline-container,
.fi-dark .timeline-container,
[data-theme="dark"] .timeline-container {
    background: #1f2937;
    border-color: #374151;
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.3);
    color: #f9fafb;
}

.dark .timeline-title,
.fi-dark .timeline-title,
[data-theme="dark"] .timeline-title {
    color: #f9fafb;
}

.dark .timeline-percentage,
.fi-dark .timeline-percentage,
[data-theme="dark"] .timeline-percentage {
    color: #d1d5db;
}

.dark .timeline-progress-bar,
.fi-dark .timeline-progress-bar,
[data-theme="dark"] .timeline-progress-bar {
    background-color: #374151;
}

.dark .timeline-step-circle,
.fi-dark .timeline-step-circle,
[data-theme="dark"] .timeline-step-circle {
    background-color: #374151;
    border-color: #4b5563;
    color: #9ca3af;
}

.dark .timeline-step-future,
.fi-dark .timeline-step-future,
[data-theme="dark"] .timeline-step-future {
    background-color: #374151;
    border-color: #4b5563;
    color: #9ca3af;
}

.dark .timeline-step-title,
.fi-dark .timeline-step-title,
[data-theme="dark"] .timeline-step-title {
    color: #d1d5db;
}

.dark .timeline-step-status,
.fi-dark .timeline-step-status,
[data-theme="dark"] .timeline-step-status {
    color: #9ca3af;
}

.dark .timeline-connector,
.fi-dark .timeline-connector,
[data-theme="dark"] .timeline-connector {
    background-color: #4b5563;
}


/* Pulse animation */
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}
</style>
