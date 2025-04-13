@props(['tones', 'colorSuggestions' => null])

@php
if ($colorSuggestions === null) {
    $colorSuggestions = [
        'Fair' => [
            'Navy' => '#000080',
            'Brown' => '#8B4513',
            'Burgundy' => '#800020',
            'Green' => '#006400',
            'Olive' => '#808000'
        ],
        'Olive' => [
            'Burgundy' => '#800020',
            'Maroon' => '#800000',
            'Purple' => '#800080',
            'Green' => '#006400',
            'Navy' => '#000080'
        ],
        'Light Brown' => [
            'Navy' => '#000080',
            'Royal Blue' => '#4169E1',
            'Teal' => '#008080',
            'Grey' => '#808080',
            'Burgundy' => '#800020'
        ],
        'Brown' => [
            'Navy' => '#000080',
            'Mid Blue' => '#0000CD',
            'Green' => '#006400',
            'Bright Yellow' => '#FFFF00',
            'Sky Blue' => '#87CEEB'
        ],
        'Black Brown' => [
            'Black' => '#000000',
            'Navy' => '#000080',
            'Burgundy' => '#800020',
            'Pink' => '#FFC0CB',
            'Pastel Blue' => '#ADD8E6'
        ]
    ];
}
@endphp

<div class="card mb-4 border-left-info">
    <div class="card-body">
        <h6 class="font-weight-bold text-info mb-3">Color Suggestions by Skin Tone</h6>
        <div class="row">
            <div class="col-md-3">
                <div class="form-group">
                    <label for="{{ $idPrefix }}toneSuggestion">Select Skin Tone</label>
                    <select class="form-select" id="{{ $idPrefix }}toneSuggestion">
                        <option value="">Select a tone for suggestions</option>
                        @foreach($tones as $tone)
                            <option value="{{ $tone->tone_name }}">{{ $tone->tone_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-9">
                <div id="{{ $idPrefix }}colorSuggestions" class="d-none">
                    <label>Suggested Colors:</label>
                    <div class="d-flex flex-wrap" id="{{ $idPrefix }}suggestedColorsList">
                        <!-- Suggested colors will appear here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>