@extends('layouts.app')

@section('title', 'Create Trade Offer')
@section('page-title', 'Create Trade Offer')

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Make an Offer for {{ $item->name }}</h3>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <div class="card">
                            <img src="{{ $item->getImageUrl() }}" class="card-img-top" alt="{{ $item->name }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $item->name }}</h5>
                                <p class="card-text text-muted">{{ Str::limit($item->description, 100) }}</p>
                                <h4 class="text-primary">${{ number_format($item->price, 2) }}</h4>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <form action="{{ route('user.transactions.store', $item) }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="type">Offer Type *</label>
                                <select name="type" id="type" class="form-control @error('type') is-invalid @enderror" required>
                                    <option value="">-- Select Type --</option>
                                    <option value="buy" @if(old('type') === 'buy') selected @endif>Buy with Money</option>
                                    <option value="trade" @if(old('type') === 'trade') selected @endif>Trade with Item</option>
                                </select>
                                @error('type')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Buy Option -->
                            <div id="buy-option" class="form-group" style="display: none;">
                                <label for="offer_amount">Offer Amount ($) *</label>
                                <input type="number" name="offer_amount" id="offer_amount" 
                                       class="form-control @error('offer_amount') is-invalid @enderror" 
                                       value="{{ old('offer_amount', $item->price) }}" step="0.01" min="0">
                                @error('offer_amount')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Trade Option -->
                            <div id="trade-option" class="form-group" style="display: none;">
                                <label for="offer_item_id">Select Your Item to Trade *</label>
                                <select name="offer_item_id" id="offer_item_id" 
                                        class="form-control @error('offer_item_id') is-invalid @enderror">
                                    <option value="">-- Select Item --</option>
                                    @foreach($user_items as $user_item)
                                        <option value="{{ $user_item->id }}" @if(old('offer_item_id') == $user_item->id) selected @endif>
                                            {{ $user_item->name }} (${{ number_format($user_item->price, 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('offer_item_id')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                
                                @if($user_items->isEmpty())
                                    <div class="alert alert-warning mt-2">
                                        <i class="fas fa-exclamation-triangle"></i> You don't have any available items to trade.
                                        <a href="{{ route('user.items.create') }}">Create one</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Hidden field for total_price -->
                            <input type="hidden" name="total_price" id="total_price" value="{{ $item->price }}">

                            <div class="form-group">
                                <label for="notes">Message (Optional)</label>
                                <textarea name="notes" id="notes" class="form-control @error('notes') is-invalid @enderror" 
                                          rows="3" placeholder="Add a message for the seller...">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-paper-plane"></i> Send Offer
                                </button>
                                <a href="{{ route('user.marketplace.show', $item) }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        function toggleOfferOptions() {
            const type = $('#type').val();
            
            if (type === 'buy') {
                $('#buy-option').show();
                $('#trade-option').hide();
                $('#offer_amount').prop('required', true);
                $('#offer_item_id').prop('required', false);
            } else if (type === 'trade') {
                $('#buy-option').hide();
                $('#trade-option').show();
                $('#offer_amount').prop('required', false);
                $('#offer_item_id').prop('required', true);
            } else {
                $('#buy-option').hide();
                $('#trade-option').hide();
                $('#offer_amount').prop('required', false);
                $('#offer_item_id').prop('required', false);
            }
        }

        $('#type').on('change', toggleOfferOptions);
        
        // Initial toggle
        toggleOfferOptions();
    });
</script>
@endpush
